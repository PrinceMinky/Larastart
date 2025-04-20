@props(['user'])

@if(auth()->user()->id !== $user->id)
    @if(auth()->user()->isFollowing($user) && $user->followers()->where('follower_id', auth()->id())->where('status', 'accepted')->exists())
        <flux:button wire:click="unfollow({{ $user->id }})">Unfollow</flux:button>
    @elseif(auth()->user()->isFollowing($user) && $user->followers()->where('follower_id', auth()->id())->where('status', 'pending')->exists())
        <flux:button wire:click="unfollow({{ $user->id }})">Cancel Request</flux:button>
    @elseif($user->isFollowing(auth()->user()) && !$user->followers()->where('follower_id', auth()->id())->where('status', 'accepted')->exists())
        <flux:button wire:click="follow({{ $user->id }})">Follow Back</flux:button>
    @else
        <flux:button wire:click="follow({{ $user->id }})">Follow</flux:button>
    @endif
@endif