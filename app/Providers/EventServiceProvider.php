<?php

namespace App\Providers;

use App\Listeners\LogActivityListener;
use App\Events\Comments\CommentCreated;
use App\Events\Comments\CommentDeleted;
use App\Events\Comments\CommentUpdated;
use App\Events\Comments\ReplyPosted;
use App\Events\Kanban\BoardCreated;
use App\Events\Kanban\BoardUpdated;
use App\Events\Kanban\BoardDeleted;
use App\Events\Kanban\CardCreated;
use App\Events\Kanban\CardDeleted;
use App\Events\Kanban\CardUpdated;
use App\Events\Kanban\ColumnCreated;
use App\Events\Kanban\ColumnDeleted;
use App\Events\Kanban\ColumnUpdated;
use App\Events\Kanban\UserAssigned;
use App\Events\Kanban\UserRemoved;
use App\Events\Kanban\UserUnassigned;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        /**
         * Comments Component
         */
        CommentCreated::class => [
            LogActivityListener::class,
        ],
        CommentUpdated::class => [
            LogActivityListener::class,
        ],
        CommentDeleted::class => [
            LogActivityListener::class,
        ],
        ReplyPosted::class => [
            LogActivityListener::class,
        ],

        /**
         * KanbanBoard Component
         */
        BoardCreated::class => [
            LogActivityListener::class,
        ],
        BoardUpdated::class => [
            LogActivityListener::class,
        ],
        BoardDeleted::class => [
            LogActivityListener::class,
        ],

        ColumnCreated::class => [
            LogActivityListener::class,
        ],
        ColumnUpdated::class => [
            LogActivityListener::class,
        ],
        ColumnDeleted::class => [
            LogActivityListener::class,
        ],

        CardCreated::class => [
            LogActivityListener::class,
        ],
        CardUpdated::class => [
            LogActivityListener::class,
        ],
        CardDeleted::class => [
            LogActivityListener::class,
        ],

        UserAssigned::class => [
            LogActivityListener::class,
        ],

        UserUnassigned::class => [
            LogActivityListener::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}