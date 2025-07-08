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

    <div class="flex flex-between gap-2">
        <div class="w-3/4">
            @livewire('user-post')
        </div>

        <div class="w-1/3">
            <flux:card>
                <flux:navlist>
                    @if($user->is_private)
                    <flux:navlist.item :href="route('follow.requests')" icon="users" :badge="$user->followers_count">Follow Requests</flux:navlist.item>
                    @endif 
                    
                    <flux:navlist.item :href="route('notifications.index')" icon="bell" :badge="$user->notifications->where('read_at',null)->count()">Notifications</flux:navlist.item>
                </flux:navlist>
            </flux:card>
        </div>
    </div>
</section>