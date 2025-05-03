<!-- resources/views/components/user-follow-button.blade.php -->
@props(['user'])

@if(auth()->check() && auth()->user()->id !== $user->id)
    @php
        $followButtonState = $this->getFollowButtonState($user->id);
    @endphp
    
    @if($followButtonState === 'following')
        <flux:button wire:click="unfollow({{ $user->id }})">Unfollow</flux:button>
    @elseif($followButtonState === 'pending')
        <flux:button wire:click="unfollow({{ $user->id }})">Cancel Request</flux:button>
    @elseif($followButtonState === 'follow_back')
        <flux:button wire:click="follow({{ $user->id }})">Follow Back</flux:button>
    @else
        <flux:button wire:click="follow({{ $user->id }})">Follow</flux:button>
    @endif
@endif