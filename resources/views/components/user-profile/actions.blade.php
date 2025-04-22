<div class="flex flex-col gap-3 w-full">
    @if(auth()->user()->me($this->user->id))
    <flux:button wire:navigate :href="route('settings.profile')" size="sm">Edit Profile</flux:button>
    @else
    <x-user-profile.follow-button :user="$this->user" />

    <x-user-profile.block-button />
    @endif
</div>