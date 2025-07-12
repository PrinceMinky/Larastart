<?php

namespace App\Listeners;

use App\Events\Kanban\CardCreated;
use App\Events\Kanban\CardDeleted;
use App\Events\Kanban\CardUpdated;
use App\Events\Kanban\BoardCreated;
use App\Events\Kanban\BoardDeleted;
use App\Events\Kanban\BoardUpdated;
use App\Events\Kanban\UserAssigned;
use App\Events\Comments\ReplyPosted;
use App\Events\Kanban\ColumnCreated;
use App\Events\Kanban\ColumnDeleted;
use App\Events\Kanban\ColumnUpdated;
use Illuminate\Support\Facades\Auth;
use App\Events\Comments\CommentCreated;
use App\Events\Comments\CommentDeleted;
use App\Events\Comments\CommentUpdated;
use App\Events\Kanban\UserUnassigned;

class LogActivityListener
{
    public function handle(object $event): void
    {
        $map = [
            // Comments Component
            CommentCreated::class   =>      ['Comment Created', 'log' => 'created_comment'],
            CommentUpdated::class   =>      ['log' => 'updated_comment'],
            CommentDeleted::class   =>      ['log' => 'deleted_comment'],
            ReplyPosted::class      =>      ['log' => 'reply_posted'],

            // Kanban Component
            BoardCreated::class     =>      ['log' => 'board_created'],
            BoardUpdated::class     =>      ['log' => 'board_updated'],
            BoardDeleted::class     =>      ['log' => 'board_deleted'],

            ColumnCreated::class    =>      ['log' => 'column_created'],
            ColumnUpdated::class    =>      ['log' => 'column_updated'],
            ColumnDeleted::class    =>      ['log' => 'column_deleted'],

            CardCreated::class      =>      ['log' => 'card_created'],
            CardUpdated::class      =>      ['log' => 'card_updated'],
            CardDeleted::class      =>      ['log' => 'card_deleted'],

            UserAssigned::class      =>     ['log' => 'user_assigned'],
            UserUnassigned::class       =>     ['log' => 'user_unassigned'],
        ];

        $config = $map[get_class($event)] ?? null;

        if (! $config || ! method_exists($event, 'activityProperties') || ! property_exists($event, 'model')) {
            return;
        }

        $model = $event->model;

        activity()
            ->causedBy(Auth::user())
            ->performedOn($model)
            ->withProperties($event->activityProperties())
            ->log($config['log']);
    }
}
