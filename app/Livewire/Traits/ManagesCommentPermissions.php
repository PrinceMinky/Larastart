<?php

namespace App\Livewire\Traits;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

trait ManagesCommentPermissions
{
    public function canEdit(Comment $comment): bool
    {
        return Auth::user()?->can('update', $comment) ?? false;
    }

    public function canDelete(Comment $comment): bool
    {
        return Auth::user()?->can('delete', $comment) ?? false;
    }

    public function canReply(Comment $comment): bool
    {
        return Auth::check();
    }

    public function canCreateComment(): bool
    {
        return Auth::user()?->can('create', Comment::class) ?? false;
    }
}
