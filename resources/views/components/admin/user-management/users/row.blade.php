<flux:table.row :key="$user->id">
    @can('delete users')
    <flux:table.cell class="whitespace-nowrap">
        @if(! $user->hasRole('Super Admin'))
        <flux:checkbox wire:model="selectedUserIds" value="{{ $user->id }}" />
        @endif
    </flux:table.cell>
    @endcan

    <flux:table.cell class="flex items-center gap-3">
        <div class="flex items-center gap-2">
            <flux:avatar :name="$user->name" color="auto" />

            <div class="flex flex-col gap-0">
                <flux:heading>
                    <flux:link :href="route('profile.show', ['username' => $user->username])" variant="subtle" :external="true" class="flex gap-2">
                        {{ $user->name }}
                    </flux:link>
                </flux:heading>
                <flux:text class="text-xs">{{ $user->username }}</flux:text>
            </div>
            @if($user->is_private)
            <flux:tooltip content="Profile is set to private">
                <flux:icon.lock-closed variant="micro" />
            </flux:tooltip>
            @endif
        </div>
    </flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">
        {{ $user->email }}

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! $user->hasVerifiedEmail())
            <flux:badge icon="x-mark" size="sm" color="red" inset="top bottom">
                Unverified
            </flux:badge>
        @elseif ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail())
            <flux:badge icon="check" size="sm" color="green" inset="top bottom">
                Verified
            </flux:badge>
        @endif
    </flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $user->country->label() }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $user->date_of_birth->age }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">
        @foreach ($user->roles as $role)
            <flux:badge>{{ $role->name }}</flux:badge>
        @endforeach
    </flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">
        {{ $user->created_at->format('jS F Y') }}
    </flux:table.cell>

    <flux:table.cell class="whitespace-nowrap text-right">
        @canany(['impersonate users','edit users','delete users'])
        @if(! $user->hasRole('Super Admin'))
        <flux:dropdown>
            <flux:button icon="ellipsis-horizontal" size="sm" />

            <flux:menu>
                @if(! $user->hasRole('Super Admin') && $user->id !== auth()->user()->id)
                    @can('impersonate users')
                    <flux:menu.item icon="key" wire:click="impersonate({{ $user->id }})">Impersonate User</flux:menu.item>
                    @endcan
                @endif

                @can('edit users')
                <flux:menu.item icon="pencil" wire:click="showForm({{ $user->id }})">Edit User</flux:menu.item>
                @endcan
                
                @if(! $user->hasRole('Super Admin') && $user->id !== auth()->user()->id)
                @can('delete users')
                <flux:menu.item icon="trash" wire:click="showConfirmDeleteForm({{ $user->id }})" variant="danger">Delete User</flux:menu.item>
                @endcan
                @endif
            </flux:menu>
        </flux:dropdown>
        @endif
        @endcanany
    </flux:table.cell>
</flux:table.row>