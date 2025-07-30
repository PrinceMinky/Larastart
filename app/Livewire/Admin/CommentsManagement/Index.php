<?php

namespace App\Livewire\Admin\CommentsManagement;

use App\Models\User;
use App\Models\Comment;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Livewire\Traits\WithDataTables;

#[Title('Comments Management')]
#[Layout('components.layouts.admin')]
class Index extends BaseComponent
{
    use WithDataTables;

    protected ?array $cachedUsersList = null;

    #[Computed]
    public function comments()
    {
        $query = Comment::query()
            ->with('user')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.*');

        $this->applySearch($query, ['body']);
        $this->applyFilters($query);
        $this->applySorting($query);

        return $query->paginate($this->perPage);
    }

    #[Computed]
    public function getUsersList(): \Illuminate\Support\Collection
    {
        return $this->getCachedList('usersList', function () {
            return User::whereHas('comments')
                ->orderBy('name')
                ->get(['id', 'username', 'name'])
                ->keyBy('id');
        });
    }

    public function filterConfig(): array 
    {
        return [
            'user_id' => [
                'label' => 'User',
                'type' => 'select',
                'searchable' => true,
                'options' => $this->getUsersList,
                'display' => fn ($id) => \App\Models\User::find($id)?->name ?? 'Unknown',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin.comments-management.index');
    }
}
