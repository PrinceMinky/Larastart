<?php

namespace App\Providers;

use App\Events\Badwords\{BadwordCreated, BadwordDeleted, BadwordUpdated};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Listeners\LogActivityListener;
use App\Events\UserLoggedIn;
use App\Events\UserFailedLoggedIn;
use App\Events\UserDeleted;
use App\Events\PasswordSent;
use App\Events\PasswordReset;
use App\Events\ProfileUpdated;
use App\Events\PasswordUpdated;
use App\Events\PrivacyUpdated;
use App\Events\VerifiedEmail;

use App\Events\Comments\CommentCreated;
use App\Events\Comments\CommentUpdated;
use App\Events\Comments\CommentDeleted;
use App\Events\Comments\ReplyPosted;

use App\Events\Kanban\BoardCreated;
use App\Events\Kanban\BoardUpdated;
use App\Events\Kanban\BoardDeleted;
use App\Events\Kanban\ColumnCreated;
use App\Events\Kanban\ColumnUpdated;
use App\Events\Kanban\ColumnDeleted;
use App\Events\Kanban\CardCreated;
use App\Events\Kanban\CardUpdated;
use App\Events\Kanban\CardDeleted;
use App\Events\Kanban\UserAssigned;
use App\Events\Kanban\UserUnassigned;
use App\Events\UserCreated;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(UserCreated::class, LogActivityListener::class);
        Event::listen(UserLoggedIn::class, LogActivityListener::class);
        Event::listen(UserFailedLoggedIn::class, LogActivityListener::class);
        Event::listen(UserDeleted::class, LogActivityListener::class);
        Event::listen(PasswordSent::class, LogActivityListener::class);
        Event::listen(PasswordReset::class, LogActivityListener::class);
        Event::listen(ProfileUpdated::class, LogActivityListener::class);
        Event::listen(PasswordUpdated::class, LogActivityListener::class);
        Event::listen(PrivacyUpdated::class, LogActivityListener::class);
        Event::listen(VerifiedEmail::class, LogActivityListener::class);

        Event::listen(CommentCreated::class, LogActivityListener::class);
        Event::listen(CommentUpdated::class, LogActivityListener::class);
        Event::listen(CommentDeleted::class, LogActivityListener::class);
        Event::listen(ReplyPosted::class, LogActivityListener::class);

        Event::listen(BoardCreated::class, LogActivityListener::class);
        Event::listen(BoardUpdated::class, LogActivityListener::class);
        Event::listen(BoardDeleted::class, LogActivityListener::class);
        Event::listen(ColumnCreated::class, LogActivityListener::class);
        Event::listen(ColumnUpdated::class, LogActivityListener::class);
        Event::listen(ColumnDeleted::class, LogActivityListener::class);
        Event::listen(CardCreated::class, LogActivityListener::class);
        Event::listen(CardUpdated::class, LogActivityListener::class);
        Event::listen(CardDeleted::class, LogActivityListener::class);
        Event::listen(UserAssigned::class, LogActivityListener::class);
        Event::listen(UserUnassigned::class, LogActivityListener::class);

        Event::listen(BadwordCreated::class, LogActivityListener::class);
        Event::listen(BadwordUpdated::class, LogActivityListener::class);
        Event::listen(BadwordDeleted::class, LogActivityListener::class);
    }
}