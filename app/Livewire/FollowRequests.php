<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use App\Livewire\BaseComponent;

class FollowRequests extends BaseComponent
{
    #[Computed]
    public function requests()
    {
        return Auth::user()->followers()->whereStatus('pending')->get();
    }
    
    public function accept($requestId)
    {
        $request = Auth::user()->followers()
            ->wherePivot('follower_id', $requestId) 
            ->wherePivot('status', 'pending')
            ->first();

        $request->pivot->update(['status' => 'accepted']);
    
        $this->toast([
            'text' => 'Follow request approved.',
            'variant' => 'success'
        ]);
    }
    
    public function deny($requestId)
    {
        Auth::user()->followers()->detach($requestId);
    
        $this->toast([
            'text' => 'Follow request denied.',
            'variant' => 'danger'
        ]);
    }

    public function render()
    {
        return view('livewire.follow-requests');
    }
}
