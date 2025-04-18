<section>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Welcome to your dashboard!') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    
    @can('view admin dashboard')
    <flux:card class="mb-5">
        <flux:button :href="route('admin.dashboard')">Admin Dashboard</flux:button>
    </flux:card>
    @endcan
</section>