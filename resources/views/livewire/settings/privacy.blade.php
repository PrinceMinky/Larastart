<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Privacy')" :subheading="__('Update your privacy settings.')">
        <form wire:submit="updatePrivacy" class="my-6 w-full space-y-6">
            <!-- Privacy -->
            <flux:switch wire:model.live="privacy" label="Make profile private" align="left" />
        </form>

        <livewire:blocked-user-list />
    </x-settings.layout>
</section>
