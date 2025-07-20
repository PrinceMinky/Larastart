<?php

namespace App\Livewire\Admin\ActivityLog;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\Sortable;
use Livewire\Attributes\Computed;
use App\Livewire\Traits\Filterable;
use App\Livewire\Traits\Searchable;
use Spatie\Activitylog\Models\Activity;

#[Title('Activities')]
#[Layout('components.layouts.admin')]
class Index extends BaseComponent
{
    use Filterable, Sortable, Searchable, WithPagination;

    protected ?array $cachedModelsList = null;
    protected ?array $cachedUsersList = null;

    #[Computed]
    public function activities()
    {
        $query = Activity::query()
            ->with('subject');

        $this->applyFilters($query);
        $this->applySorting($query);
        $this->applySearch($query, ['description']);

        $activities = $query->paginate(25);

        // Optional: lazy eager-load nested relationships on subject
        $activities->loadMorph('subject', [
            \App\Models\Comment::class => ['user'],
            \App\Models\KanbanColumn::class => ['board'],
            \App\Models\KanbanCard::class => ['board','column'],
        ]);

        return $activities;
    }

    #[Computed]
    public function getUsersList(): \Illuminate\Support\Collection
    {
        return $this->getCachedList('usersList', function () {
            return User::orderBy('name')
                ->get(['id', 'username', 'name'])
                ->keyBy('id');
        });
    }

    #[Computed]
    public function getModelsList(): \Illuminate\Support\Collection
    {
        return $this->getCachedList('modelsList', function () {
            return Activity::query()
                ->distinct()
                ->pluck('subject_type')
                ->filter()
                ->mapWithKeys(function ($subjectType) {
                    $displayName = class_basename($subjectType);
                    return [
                        $subjectType => (object) [
                            'name' => $displayName,
                            'subject_type' => $subjectType,
                        ]
                    ];
                });
        });
    }

    public function filterConfig(): array 
    {
        return [
            'model' => [
                'label' => 'Model',
                'type' => 'select',
                'searchable' => true,
                'options' => $this->getModelsList,
                'column' => 'subject_type',
            ],
            'causer_id' => [
                'label' => 'Causer',
                'type' => 'select',
                'searchable' => true,
                'options' => $this->getUsersList,
                'display' => fn ($id) => \App\Models\User::find($id)?->name ?? 'Unknown',
            ],
            'date_range' => $this->dateRangeFilter(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.activity-log.index',[
            'usersList' => $this->getUsersList, 
        ]);
    }
}
