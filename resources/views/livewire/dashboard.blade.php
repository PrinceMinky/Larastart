<section>
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Dashboard') }}</x-slot>
        <x-slot name="subheading">{{ __('Welcome to your dashboard!') }}</x-slot>

        <x-slot name="actions">
            <div class="flex gap-2">
            <flux:button :href="route('profile.show',['username' => Auth::user()->username])" variant="primary">Your Profile</flux:button>

            @can('view admin dashboard')
                <flux:separator vertical class="my-2" />

                <flux:button :href="route('admin.dashboard')">Admin Dashboard</flux:button>
            @endcan
            </div>
        </x-slot>
    </x-page-heading>

    @livewire('user-post')
</section>