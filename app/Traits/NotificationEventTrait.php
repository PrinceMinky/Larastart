<?php

namespace App\Traits;

trait NotificationEventTrait
{   
    public function dispatchNotificationReadEvent($notificationId)
    {
        $this->dispatch('refreshNotifications');
    }

    public function dispatchNotificationDeletedEvent($notificationId)
    {
        $this->dispatch('refreshNotifications');
        $this->toast([
            'text' => 'Notification deleted successfully',
            'variant' => 'danger'
        ]);
    }
    
    public function dispatchAllNotificationsReadEvent()
    {
        $this->dispatch('refreshNotifications');
    }
}