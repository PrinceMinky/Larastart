<?php

namespace App\Listeners;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogActivityListener
{
    /**
     * Map event class names to activity log description templates.
     * Use placeholders like :causer.name, :subject.title, etc.
     */
    protected array $activityLogTemplates = [
        // Authentication and Profile
        \App\Events\UserCreated::class => ':causer.name registered an account',
        \App\Events\UserLoggedIn::class => ':causer.name logged in',
        \App\Events\UserFailedLoggedIn::class => 'Failed login attempt for :causer.email',
        \App\Events\UserDeleted::class => ':causer.name deleted their user account',
        \App\Events\PasswordSent::class => 'Password reset sent to :properties.email',
        \App\Events\PasswordReset::class => ':causer.name reset their password',
        \App\Events\ProfileUpdated::class => ':causer.name updated their profile',
        \App\Events\PasswordUpdated::class => ':causer.name updated their password',
        \App\Events\PrivacyUpdated::class => ':causer.name updated privacy settings',
        \App\Events\VerifiedEmail::class => ':causer.name verified their email',

        // Comments Component
        \App\Events\Comments\CommentCreated::class => ':causer.name posted a comment',
        \App\Events\Comments\CommentUpdated::class => ':causer.name updated a comment',
        \App\Events\Comments\CommentDeleted::class => ':causer.name deleted a comment',
        \App\Events\Comments\ReplyPosted::class => ':causer.name replied to a comment',

        // KanbanBoard Component
        \App\Events\Kanban\BoardCreated::class => ':causer.name created board ":subject.title"',
        \App\Events\Kanban\BoardUpdated::class => ':causer.name updated board ":subject.title"',
        \App\Events\Kanban\BoardDeleted::class => ':causer.name deleted board ":subject.title"',

        \App\Events\Kanban\ColumnCreated::class => ':causer.name created column ":subject.title"',
        \App\Events\Kanban\ColumnUpdated::class => ':causer.name updated column ":subject.title"',
        \App\Events\Kanban\ColumnDeleted::class => ':causer.name deleted column ":subject.title"',

        \App\Events\Kanban\CardCreated::class => ':causer.name created card ":subject.title"',
        \App\Events\Kanban\CardUpdated::class => ':causer.name updated card ":subject.title"',
        \App\Events\Kanban\CardDeleted::class => ':causer.name deleted card ":subject.title"',

        \App\Events\Kanban\UserAssigned::class => ':causer.name assigned user :properties.assigned_user_name to card ":subject.title"',
        \App\Events\Kanban\UserUnassigned::class => ':causer.name unassigned user from card ":subject.title"',
    ];

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event): void
    {
        $eventClass = get_class($event);

        $template = $this->activityLogTemplates[$eventClass] ?? 'An action was performed';

        $subject = $this->findFirstModelProperty($event);
        $causer = $this->findFirstUserProperty($event) ?? Auth::user();

        $properties = method_exists($event, 'activityProperties') ? $event->activityProperties() : [];

        activity()
            ->performedOn($subject)
            ->causedBy($causer)
            ->withProperties($properties)
            ->log($template);
    }

    /**
     * Find first Eloquent model property on event to use as subject.
     */
    protected function findFirstModelProperty(object $event): ?Model
    {
        foreach (get_object_vars($event) as $value) {
            if ($value instanceof Model) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Find first User property on event to use as causer.
     */
    protected function findFirstUserProperty(object $event): ?User
    {
        foreach (get_object_vars($event) as $value) {
            if ($value instanceof User) {
                return $value;
            }
        }
        return null;
    }
}
