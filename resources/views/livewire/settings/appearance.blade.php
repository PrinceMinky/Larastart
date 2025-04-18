<div class="flex flex-col items-start">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun" wire:click="update">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon" wire:click="update">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop" wire:click="update">{{ __('System') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</div>
