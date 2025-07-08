<?php

namespace App\Livewire;

use App\Livewire\BaseComponent;
use App\Traits\NotifiableTrait;
use Livewire\Attributes\On;

class NotificationsDropdown extends BaseComponent
{
    use NotifiableTrait;
    
    /**
     * Initialize component
     */
    public function boot()
    {
        $this->initializeNotifiableTrait();
    }
    
    /**
     * Set up component data
     */
    public function mount()
    {
        $this->processedNotifications = $this->loadNotifications();
    }
    
    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.notifications-dropdown', [
            'unreadCount' => $this->unreadCount
        ]);
    }
}