@props(['user'])

@if(auth()->check() && auth()->user()->id !== $user->id)
    @php
        // Check if the follow status is preloaded
        $isUserFollowing = false;
        $followStatus = null;
        
        if (auth()->user()->relationLoaded('following')) {
            $isUserFollowing = auth()->user()->following->contains('id', $user->id);
        }
        
        if ($user->relationLoaded('followers')) {
            $follower = $user->followers->where('id', auth()->id())->first();
            if ($follower) {
                $followStatus = $follower->pivot->status ?? null;
            }
        }
        
        $isFollowingCurrentUser = false;
        if (auth()->user()->relationLoaded('followers')) {
            $isFollowingCurrentUser = auth()->user()->followers->contains('id', $user->id);
        }
    @endphp

    @if($isUserFollowing && $followStatus === 'accepted')
        <flux:button wire:click="unfollow({{ $user->id }})">Unfollow</flux:button>
    @elseif($isUserFollowing && $followStatus === 'pending')
        <flux:button wire:click="unfollow({{ $user->id }})">Cancel Request</flux:button>
    @elseif($isFollowingCurrentUser && !$isUserFollowing)
        <flux:button wire:click="follow({{ $user->id }})">Follow Back</flux:button>
    @else
        <flux:button wire:click="follow({{ $user->id }})">Follow</flux:button>
    @endif
@endif