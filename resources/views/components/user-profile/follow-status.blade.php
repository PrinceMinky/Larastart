<div>
    <!-- Followers and Following counts -->
    <div class="flex justify-left gap-3">
        @if($this->followingCount() > 0)
            <flux:text variant="strong" wire:click="showModal('following')" class="cursor-pointer">Following</flux:text>
        @else
            <flux:text variant="strong">Following</flux:text>
        @endif
        <flux:text>{{ $this->followingCount() }}</flux:text>
        
        @if($this->followerCount() > 0)
            <flux:text variant="strong" wire:click="showModal('followers')" class="cursor-pointer">Followers</flux:text>
        @else
            <flux:text variant="strong">Followers</flux:text>
        @endif
        <flux:text>{{ $this->followerCount() }}</flux:text>
    </div>

    <!-- Display if user follows authenticated user -->
    @if($this->user->followsMe())
    <div class="flex justify-center mt-2">
        <flux:badge>Follows You</flux:badge>
    </div>
    @endif

    <!-- Following Modal -->
    <x-user-profile.following-modal />
</div>