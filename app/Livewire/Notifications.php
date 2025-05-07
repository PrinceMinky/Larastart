<?php

namespace App\Livewire;

use App\Livewire\BaseComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

class Notifications extends BaseComponent
{
    public $notificationLimit = 10;
    public $showAllNotifications = false;
    public Collection $usersCache;
    public $notifications = [];
    public $processedNotifications = [];
    
    protected $listeners = [
        'refreshNotifications' => 'refresh',
        'markAsRead' => 'markAsRead',
        'markAllAsRead' => 'markAllAsRead',
    ];    
    
    public function mount()
    {
        $this->usersCache = new Collection();
        $this->loadNotifications();
    }

    public function refresh()
    {
        $this->loadNotifications();
        $this->getUnreadCountProperty();
    }

    #[Computed]
    public function loadNotifications()
    {
        $query = Auth::user()->notifications()
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->latest();
        
        if (!$this->showAllNotifications) {
            $query->limit($this->notificationLimit);
        }
        
        $this->notifications = $query->get();
        
        $userIds = collect($this->notifications)->pluck('data.user_id')->filter()->unique()->values();
        
        $uncachedUserIds = $userIds->diff($this->usersCache->keys());
        
        if ($uncachedUserIds->isNotEmpty()) {
            $newUsers = User::whereIn('id', $uncachedUserIds)->get()->keyBy('id');
            
            foreach ($newUsers as $id => $user) {
                $this->usersCache[$id] = $user;
            }
        }
        
        $this->processedNotifications = $this->processNotifications();
    }

    public function processNotifications() 
    {
        $processed = [];
    
        foreach ($this->notifications as $notification) {
            $notificationData = $notification->data;
            $userId = $notificationData['user_id'] ?? null;
            $user = $userId && isset($this->usersCache[$userId]) ? $this->usersCache[$userId] : null;
    
            $processed[] = [
                'id' => $notification->id,
                'isRead' => !is_null($notification->read_at),
                'data' => $notificationData,
                'user' => $user, 
                'icon' => $notificationData['icon'] ?? null,
                'action' => $notificationData['action'] ?? 'did something',
                'url' => $notificationData['url'] ?? null,
                'timeAgo' => ($notification->updated_at ?? $notification->created_at)->diffForHumans()
            ];
        }
    
        return $processed; 
    }    
    
    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);

        // Disable timestamps for this update
        $notification->timestamps = false;
        $notification->markAsRead();

        // Re-enable timestamps for future updates
        $notification->timestamps = true;
        
        $this->dispatch('notificationRead', $notificationId);
        $this->dispatch('notify', [
            'message' => 'Notification marked as read',
            'type' => 'success'
        ]);
        
        $this->loadNotifications();
    }
    
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        $this->dispatch('allNotificationsRead');
        $this->dispatch('notify', [
            'message' => 'All notifications marked as read',
            'type' => 'success'
        ]);
        
        $this->loadNotifications();
    }

    public function toggleShowAll()
    {
        $this->showAllNotifications = !$this->showAllNotifications;
        $this->loadNotifications();
    }
    
    public function getUnreadCountProperty()
    {
        return Auth::user()->unreadNotifications()->count();
    }
    
    public function render()
    {
        return view('livewire.notifications', [
            'unreadCount' => $this->unreadCount
        ]);
    }
}