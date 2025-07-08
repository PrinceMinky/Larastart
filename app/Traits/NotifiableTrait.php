<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;

trait NotifiableTrait
{
    public $processedNotifications = [];
    public $notificationLimit = 20;
    public $showAllNotifications = false;
    public Collection $usersCache;
    
    /**
     * Initialize trait properties
     */
    public function initializeNotifiableTrait()
    {
        $this->usersCache = new Collection();
    }

    /**
     * Load notifications from database
     * 
     * @param int $offset The offset for pagination
     * @return array Processed notifications
     */
    public function loadNotifications(int $offset = 0)
    {
        $query = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->latest()
            ->skip($offset)
            ->limit($this->notificationLimit);
        
        $notifications = $query->get();
        
        $this->cacheUserData($notifications);
        
        return $this->processNotifications($notifications);
    }

    /**
     * Cache user data for notifications to reduce database queries
     * 
     * @param Collection|null $notificationsCollection Optional collection to process
     * @return void
     */
    protected function cacheUserData($notificationsCollection = null)
    {
        if (!$notificationsCollection || $notificationsCollection->isEmpty()) {
            return;
        }
        
        $userIds = collect($notificationsCollection)
            ->pluck('data.user_id')
            ->filter()
            ->unique()
            ->values();
        
        $uncachedUserIds = $userIds->diff($this->usersCache->pluck('id')->toArray());
        
        if ($uncachedUserIds->isEmpty()) {
            return;
        }
        
        $newUsers = User::whereIn('id', $uncachedUserIds)->get();
        
        foreach ($newUsers as $user) {
            $this->usersCache->put($user->id, $user);
        }
    }

    /**
     * Process notifications to prepare for display
     * 
     * @param Collection|null $notificationsCollection Optional collection to process
     * @return array Processed notifications
     */
    public function processNotifications($notificationsCollection = null) 
    {
        if (!$notificationsCollection) {
            return [];
        }
        
        $processed = [];
    
        foreach ($notificationsCollection as $notification) {
            $notificationData = $notification->data;
            $userId = $notificationData['user_id'] ?? null;
            $user = null;
            
            if ($userId && $this->usersCache->has($userId)) {
                $user = $this->usersCache->get($userId);
            }
            
            $actionText = $notificationData['action'] ?? 'did something';
            $formattedAction = [
                'raw' => $actionText,
                'html' => $actionText
            ];
            
            if ($user) {
                $formattedAction = formatNotificationText($actionText, [$notificationData, 'user' => $user]);
            }
    
            $processed[] = [
                'id' => $notification->id,
                'isRead' => !is_null($notification->read_at),
                'data' => $notificationData,
                'user' => $user, 
                'icon' => $notificationData['icon'] ?? null,
                'action' => $actionText,
                'formattedAction' => $formattedAction,
                'url' => $notificationData['url'] ?? null,
                'timeAgo' => $notification->created_at->diffForHumans()
            ];
        }
    
        return $processed; 
    }
    
    /**
     * Get unread notifications count
     * 
     * @return int
     */
    public function getUnreadCountProperty()
    {
        return Auth::user()->unreadNotifications()->count();
    }

    /**
     * Check if there are more notifications beyond current page
     * 
     * @param int $offset Current offset
     * @return bool
     */
    public function hasMoreNotifications(int $offset)
    {
        return Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->latest()
            ->skip($offset)
            ->limit(1)
            ->exists();
    }

    /**
     * Mark a notification as read
     * 
     * @param string $notificationId ID of notification to mark as read
     * @return void
     */
    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId); 
        $notification->markAsRead();

        $this->dispatch('notification-read', ['id' => $notificationId]);
        $this->dispatch('refreshNotifications');
    }
    
    /**
     * Mark all notifications as read
     * 
     * @return void
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('all-notifications-read');
        $this->dispatch('refreshNotifications');
    }

    /**
     * Delete a notification
     * 
     * @param string $notificationId ID of notification to delete
     * @return void
     */
    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->delete();
        
        $this->dispatch('notification-deleted', ['id' => $notificationId]);
        $this->dispatch('refreshNotifications');
        $this->toast([
            'text' => 'Notification deleted successfully',
            'variant' => 'danger'
        ]);
    }

    /**
     * Refresh notifications from database
     * 
     * @return void
     */
    #[On('refreshNotifications')]
    public function refresh()
    {
        $this->processedNotifications = $this->loadNotifications();
    }
}