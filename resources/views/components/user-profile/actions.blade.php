<div class="flex flex-col gap-3 w-full">
    @if($this->user->is_me())
        <flux:button wire:navigate :href="route('settings.profile')" size="sm">Edit Profile</flux:button>
    @else
        @if($this->isBlocked === false)
            <x-user-profile.follow-button :user="$this->user" />
        @endif

        <x-user-profile.block-button />
    @endif
</div>