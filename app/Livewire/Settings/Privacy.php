<?php

namespace App\Livewire\Settings;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class Privacy extends BaseComponent
{
    public $privacy = true;

    public function mount()
    {
        $this->privacy = Auth::user()->is_private ?? false;
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatedPrivacy(): void
    {
        Auth::user()->update([
            'is_private' => $this->privacy
        ]);

        $this->toast([
            'heading' => 'Privacy updated',
            'text' => 'Your privacy settings have been updated',
            'variant' => 'success',
        ]);
    }
}
