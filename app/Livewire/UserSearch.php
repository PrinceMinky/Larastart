<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Country;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Livewire\Traits\WithDataTables;

#[Title('Users')]
class UserSearch extends Component
{
    use WithPagination, WithDataTables;

    #[Computed]
    public function users()
    {
        $query = User::query();

        $query->with(['posts', 'following','followers']);

        $this->applyFilters($query);
        $this->applySearch($query, ['name','username','email']);

        return $query->paginate(25);
    }

    public function filterConfig()
    {
        return [
            'hide_private_profiles' => [
                'label' => 'Hide Private Profiles',
                'type' => 'switch',
            ],
            'hide_unverified_profiles' => [
                'label' => 'Hide Unverified Profiles',
                'type' => 'switch',
                'active' => in_array(\Illuminate\Contracts\Auth\MustVerifyEmail::class, class_implements(User::class)),
            ],
            'new_users' => [
                'label' => 'New Users',
                'type' => 'switch',
            ],
            'filter_by_country' => [
                'label' => 'Country',
                'type' => 'select',
                'column' => 'country',
                'searchable' => true,
                'multiple' => true,
                'options' => collect(Country::cases())->mapWithKeys(fn($case) => [
                    $case->value => $case->label(),
                ])->toArray(),
                'display' => function ($value) {
                    if (is_array($value)) {
                        return collect($value)
                            ->map(fn($code) => Country::tryFrom($code)?->label() ?? $code)
                            ->join(', ');
                    }
                    return Country::tryFrom($value)?->label() ?? $value;
                },
            ],
            'age_range' => $this->ageRangeFilter(),
        ];
    }
    
    public function filterOverrides(): array
    {
        return [
            'hide_private_profiles' => function ($query, $value) {
                if ($value) {
                    $query->where('is_private', false); 
                }
            },
            'hide_unverified_profiles' => function ($query, $value) {
                if ($value) {
                    $query->where('email_verified_at', '!=', null); 
                }
            },
            'new_users' => function ($query, $value) {
                if ($value) {
                    $query->where('created_at', '>=', now()->subDays(7));
                }
            },
            'age_range' => function ($query, $value) {
                if (!is_array($value)) {
                    return;
                }

                $minAge = isset($value['min_age']) && $value['min_age'] !== '' ? (int) $value['min_age'] : null;
                $maxAge = isset($value['max_age']) && $value['max_age'] !== '' ? (int) $value['max_age'] : null;

                $today = Carbon::today();

                if ($minAge !== null) {
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, ?) >= ?', [$today, $minAge]);
                }

                if ($maxAge !== null) {
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, ?) <= ?', [$today, $maxAge]);
                }
            },
        ];
    }

    public function render()
    {
        return view('livewire.user-search.index');
    }
}
