<?php

namespace App\Livewire;

use App\Livewire\BaseComponent;
use App\Traits\NotifiableTrait;

class Notifications extends BaseComponent
{
    use NotifiableTrait;
    
    public $page = 1;
    public $hasMoreNotifications = false;
    
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
        $this->loadInitialNotifications();
    }
    
    /**
     * Load initial notifications and determine if there are more
     */
    public function loadInitialNotifications()
    {
        $this->processedNotifications = $this->loadNotifications();
        
        // Check if there are more notifications beyond the initial batch
        $this->hasMoreNotifications = $this->hasMoreNotifications($this->notificationLimit);
    }
    
    /**
     * Load more notifications for pagination
     */
    public function loadMoreNotifications()
    {
        $this->page++;
        $offset = ($this->page - 1) * $this->notificationLimit;
        
        $newNotifications = $this->loadNotifications($offset);
        
        // Append the new notifications to the existing list
        $this->processedNotifications = array_merge($this->processedNotifications, $newNotifications);
        
        // Check if there are more notifications after this batch
        $this->hasMoreNotifications = $this->hasMoreNotifications($offset + $this->notificationLimit);
    }
        
    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.notifications');
    }
}