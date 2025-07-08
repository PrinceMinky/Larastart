<?php

namespace App\Livewire\Admin\UserManagement;

use Faker\Factory as FakerFactory;

use App\Enums\Country;
use App\Livewire\BaseComponent;
use App\Models\User;
use App\Livewire\Traits\Searchable;
use App\Livewire\Traits\Sortable;
use App\Livewire\Traits\WithModal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Title('User Management')]
#[Layout('components.layouts.admin')]
class UserList extends BaseComponent
{
    use Searchable, Sortable, WithModal, WithPagination;

    public ?int $userId = 0;
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public $hasVerifiedEmail = false;
    public ?Carbon $date_of_birth;
    public Country $country;
    public string $password = '';
    public bool $is_private = false;
    public $roles = [];
    public bool $isSuperAdmin = false;
    public array $selectedUserIds = [];
    protected ?Collection $cachedRoles = null;
    protected ?LengthAwarePaginator $cachedUsers = null;

    public array $filters = [];

    #[Computed]
    public function getNeedsVerifiedEmailProperty()
    {
        return in_array(\Illuminate\Contracts\Auth\MustVerifyEmail::class, class_implements(User::class));
    }

    #[Computed]
    public function getActiveFiltersCountProperty()
    {
        return collect($this->filters)->flatten()->filter()->count();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9._-]+$/', Rule::unique(User::class)->ignore($this->userId)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->userId)],
            'date_of_birth' => ['required', Rule::date()->before(today()->subYears(13))],
            'roles' => 'required',
            'password' => ['nullable', 'string', Rules\Password::defaults()],
        ];
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        if ($this->cachedUsers !== null) {
            return $this->cachedUsers;
        }

        $query = User::query();
        $query->with('roles');
        
        $this->applySearch($query, ['name', 'username', 'email']);
        $this->applyFilters($query);

        if ($this->sortBy) {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $this->cachedUsers = $query->paginate(25);
    }

    #[Computed]
    public function getStatsProperty(): array
    {
        $now = now();
        $recentStart = $now->copy()->subDays(30);
        $previousStart = $now->copy()->subDays(60);
        $previousEnd = $now->copy()->subDays(31);

        $counts = User::selectRaw("
            COUNT(*) as total,
            COUNT(CASE WHEN email_verified_at IS NOT NULL THEN 1 END) as verified,
            COUNT(CASE WHEN email_verified_at IS NULL THEN 1 END) as unverified,
            COUNT(CASE WHEN created_at >= ? THEN 1 END) as recent,
            COUNT(CASE WHEN created_at BETWEEN ? AND ? THEN 1 END) as previous,
            COUNT(CASE WHEN email_verified_at IS NOT NULL AND created_at >= ? THEN 1 END) as verified_recent,
            COUNT(CASE WHEN email_verified_at IS NOT NULL AND created_at BETWEEN ? AND ? THEN 1 END) as verified_previous,
            COUNT(CASE WHEN email_verified_at IS NULL AND created_at >= ? THEN 1 END) as unverified_recent,
            COUNT(CASE WHEN email_verified_at IS NULL AND created_at BETWEEN ? AND ? THEN 1 END) as unverified_previous
        ", [
            $recentStart, 
            $previousStart, $previousEnd,
            $recentStart,
            $previousStart, $previousEnd,
            $recentStart,
            $previousStart, $previousEnd,
        ])->first();

        $calculateTrend = fn($recent, $previous) => [
            'trendUp' => $recent >= $previous,
            'trend' => $recent >= $previous
                ? '+' . ($recent - $previous) . ' users'
                : '-' . ($previous - $recent) . ' users',
        ];

        $totalTrend = $calculateTrend($counts->recent, $counts->previous);
        $verifiedTrend = $calculateTrend($counts->verified_recent, $counts->verified_previous);
        $unverifiedTrend = $calculateTrend($counts->unverified_recent, $counts->unverified_previous);
        $newUsersTrend = $totalTrend; // same as total recent vs previous

        if($this->getNeedsVerifiedEmailProperty)
        {
            return [
                [
                    'title' => 'Total Users',
                    'value' => number_format($counts->total),
                    'trendUp' => $totalTrend['trendUp'],
                    'trend' => $totalTrend['trend'],
                ],
                [
                    'title' => 'Verified Users',
                    'value' => number_format($counts->verified),
                    'trendUp' => $verifiedTrend['trendUp'],
                    'trend' => $verifiedTrend['trend'],
                ],
                [
                    'title' => 'Unverified Users',
                    'value' => number_format($counts->unverified),
                    'trendUp' => $unverifiedTrend['trendUp'],
                    'trend' => $unverifiedTrend['trend'],
                ],
                [
                    'title' => 'New Users Last 30 Days',
                    'value' => number_format($counts->recent),
                    'trendUp' => $newUsersTrend['trendUp'],
                    'trend' => $newUsersTrend['trend'],
                ],
            ];
        }

        return [
            [
                'title' => 'Total Users',
                'value' => number_format($counts->total),
                'trendUp' => $totalTrend['trendUp'],
                'trend' => $totalTrend['trend'],
            ],
            [
                'title' => 'New Users Last 30 Days',
                'value' => number_format($counts->recent),
                'trendUp' => $newUsersTrend['trendUp'],
                'trend' => $newUsersTrend['trend'],
            ],
        ];
    }

    public function updatedFiltersStats($value)
    {
        if (!empty($value)) {
            $this->filters['verified_email'] = [];
            $this->filters['roles'] = [];
            $this->filters['countries'] = [];
            $this->filters['account_type'] = [];
            $this->filters['min_age'] = null;
            $this->filters['max_age'] = null;

            $this->resetPage();
        }
    }

    public function updatedFilters($value, $key)
    {
        if ($key !== 'stats' && !empty($this->filters['stats'])) {
            $this->filters['stats'] = null;
        }

        $this->resetPage();
    }

    private function applyFilters($query)
    {
        // Apply radio card filter first
        if (!empty($this->filters['stats'])) {
            match ($this->filters['stats']) {
                '1' => $query->whereNotNull('email_verified_at'),
                '2' => $query->whereNull('email_verified_at'),
                '3' => $query->where('created_at', '>=', now()->subDays(30)),
                default => null,
            };
        }

        // Email verification filter
        if (!empty($this->filters['verified_email'])) {
            $verifiedFilters = $this->filters['verified_email'];

            if (in_array('verified', $verifiedFilters) && in_array('unverified', $verifiedFilters)) {
                // Both selected, no filter needed
            } elseif (in_array('verified', $verifiedFilters)) {
                $query->whereNotNull('email_verified_at');
            } elseif (in_array('unverified', $verifiedFilters)) {
                $query->whereNull('email_verified_at');
            }
        }

        // Role filter
        if (!empty($this->filters['roles'])) {
            $query->whereHas('roles', function ($q) {
                $q->whereIn('name', $this->filters['roles']);
            });
        }

        // Country filter
        if (!empty($this->filters['countries'])) {
            $query->whereIn('country', $this->filters['countries']);
        }

        // Account type filter
        if (!empty($this->filters['account_type'])) {
            $accountTypes = $this->filters['account_type'];

            if (in_array('private', $accountTypes) && in_array('public', $accountTypes)) {
                // Both selected, no filter needed
            } elseif (in_array('private', $accountTypes)) {
                $query->where('is_private', true);
            } elseif (in_array('public', $accountTypes)) {
                $query->where('is_private', false);
            }
        }

        // Age filter
        if (!empty($this->filters['min_age']) || !empty($this->filters['max_age'])) {
            if (!empty($this->filters['min_age'])) {
                $query->whereDate('date_of_birth', '<=', Carbon::today()->subYears($this->filters['min_age']));
            }
            if (!empty($this->filters['max_age'])) {
                $query->whereDate('date_of_birth', '>=', Carbon::today()->subYears($this->filters['max_age'] + 1)->addDay());
            }
        }
    }

    public function clearFilters()
    {
        $this->filters = [];
        $this->resetPage();
    }

    public function resetAgeFilters()
    {
        $this->filters['min_age'] = null;
        $this->filters['max_age'] = null;
    }

    #[Computed]
    public function roles(): Collection
    {
        return $this->cachedRoles ??= Role::all();
    }

    #[Computed] 
    public function countries(): Collection
    {
        return collect(Country::cases())->map(function ($country) {
            return [
                'value' => $country->value,
                'label' => $country->label()
            ];
        });
    }

    public function showForm($id = null): void
    {
        (! $id) ? $this->reset() : $this->loadUserData($id);

        $this->showModal('show-user-form');
    }

    public function showConfirmDeleteForm($id = null): void
    {
        $this->loadUserData($id);

        $this->showModal('delete-user-form');
    }

    public function save(): void
    {
        $this->validate();

        (! $this->userId) ? $this->create() : $this->update();
    }

    public function create(): void
    {
        $this->authorize('create users');

        $user = User::create(array_merge([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'country' => $this->country,
            'is_private' => $this->is_private,
            'password' => ($this->password) ? $this->password : 'password',
        ], $this->getNeedsVerifiedEmailProperty() ? [
            'email_verified_at' => ($this->hasVerifiedEmail === true) ? Carbon::now() : null
        ] : []));

        $user->syncRoles($this->roles);

        $this->toast([
            'heading' => 'User created',
            'text' => 'User has been successfully created.',
            'variant' => 'success',
        ]);

        $this->closeModal();
    }

    public function update(): void
    {
        $this->authorize('edit users');

        $user = User::findOrFail($this->userId);
        $user->update(array_merge([
            'id' => $this->userId,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'country' => $this->country,
            'is_private' => $this->is_private,
        ], !empty($this->password) ? ['password' => $this->password] : [], 
        $this->getNeedsVerifiedEmailProperty() ? [
            'email_verified_at' => ($this->hasVerifiedEmail === true) ? Carbon::now() : null
        ] : []));

        $user->syncRoles($this->roles);

        $this->toast([
            'heading' => 'User updated',
            'text' => 'User has been successfully updated.',
            'variant' => 'success',
        ]);

        $this->closeModal();
    }

    public function delete(): void
    {
        $this->authorize('delete users');

        $user = User::findOrFail($this->userId);
        $user->delete();

        $this->toast([
            'heading' => 'User Deleted',
            'text' => 'User has been successfully deleted.',
            'variant' => 'danger'
        ]);

        $this->closeModal();
    }

    public function deleteSelected(): void
    {
        $this->authorize('delete users');

        User::whereIn('id', $this->selectedUserIds)->delete();

        $this->toast([
            'heading' => 'Users deleted',
            'text' => 'Users have successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->reset('selectedUserIds');
        $this->closeModal();
    }

    public function impersonate($id): void
    {
        $this->authorize('impersonate users');

        $user = User::findOrFail($id);
        Auth::loginUsingId($user->id);

        $this->toast([
            'heading' => 'Impersonating User',
            'text' => 'You are now logged in as user: ' . $user->name,
            'variant' => 'success',
        ]);

        $this->redirectRoute('dashboard', navigate: true);
    }

    private function loadUserData($id = null): void
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->hasVerifiedEmail = ($user->email_verified_at) ? true : false;
        $this->date_of_birth = $user->date_of_birth;
        $this->country = $user->country;
        $this->is_private = $user->is_private;
        $this->roles = $user->getRoleNames();
        $this->isSuperAdmin = $user->hasRole('Super Admin');
    }

    public function export()
    {
        $this->authorize('export users');
        
        return User::toCsv();
    }

    public function factory()
    {
        $this->authorize('create users');

        $faker = FakerFactory::create();

        $roles = Role::where('name', '!=', 'Super Admin')->pluck('name')->toArray();
        $countries = collect(Country::cases())->map(fn($c) => $c->value)->toArray();

        for ($i = 0; $i < 100; $i++) {
            $name = $faker->name;
            $username = $faker->unique()->userName();
            $email = $faker->unique()->safeEmail;
            $dateOfBirth = $faker->dateTimeBetween('-60 years', '-13 years')->format('Y-m-d');
            $country = $faker->randomElement($countries);
            $isPrivate = $faker->boolean(20); // 20% chance private
            $password = bcrypt('password'); // default password for testing

            $user = User::create([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'date_of_birth' => $dateOfBirth,
                'country' => $country,
                'is_private' => $isPrivate,
                'password' => $password,
                // Mark email verified randomly for variety
                'email_verified_at' => $faker->boolean(75) ? now() : null,
            ]);

            // Assign 2-3 random roles
            $assignedRoles = $faker->randomElements($roles, rand(1, 2));
            $user->syncRoles($assignedRoles);
        }

        $this->toast([
            'heading' => 'Factory Complete',
            'text' => '100 fake users have been created.',
            'variant' => 'success',
        ]);
    }

    public function render(): View
    {
        return view('livewire.admin.user-management.index');
    }
}