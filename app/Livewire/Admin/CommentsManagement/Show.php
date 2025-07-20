<?php

namespace App\Livewire\Admin\CommentsManagement;

use App\Livewire\BaseComponent;
use App\Models\Comment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Comments Management')]
#[Layout('components.layouts.admin')]
class Show extends BaseComponent
{
    public Comment $comment;

    public function mount($id)
    {
        $this->comment = Comment::with(['user', 'parent.user', 'children.user'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.comments-management.show');
    }
}
