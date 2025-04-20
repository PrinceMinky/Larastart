<section>
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Admin Dashboard') }}</x-slot>
        <x-slot name="subheading">{{ __('Welcome to your admin dashboard!') }}</x-slot>

        <x-slot name="actions">
            @can('view dashboard')
                <flux:button :href="route('dashboard')">User Dashboard</flux:button>
            @endcan
        </x-slot>
    </x-page-heading>
</section>