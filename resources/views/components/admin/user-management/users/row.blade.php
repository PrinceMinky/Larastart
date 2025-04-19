<flux:table.row :key="$user->id">
    <flux:table.cell class="whitespace-nowrap">
        @if(! $user->hasRole('Super Admin'))
        <flux:checkbox wire:model="selectedUserIds" value="{{ $user->id }}" />
        @endif
    </flux:table.cell>

    <flux:table.cell class="flex items-center gap-3">
        <flux:profile
            avatar:color="auto"
            :name="$user->name"
            :chevron="false"
            :circle="true"
        />
    </flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $user->date_of_birth->age }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $user->email }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">
        @foreach ($user->roles as $role)
            <flux:badge>{{ $role->name }}</flux:badge>
        @endforeach
    </flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">
        {{ $user->created_at->format('jS F Y') }}
    </flux:table.cell>

    <flux:table.cell class="whitespace-nowrap text-right">
        <flux:dropdown>
            <flux:button icon="ellipsis-horizontal" size="sm" />

            <flux:menu>
                @if(! $user->hasRole('Super Admin'))
                    @can('impersonate users')
                        <flux:menu.item icon="key" wire:click="impersonate({{ $user->id }})">Impersonate User</flux:menu.item>
                    @endcan
                @endif

                <flux:menu.item icon="pencil" wire:click="showForm({{ $user->id }})">Edit User</flux:menu.item>
                
                @if(! $user->hasRole('Super Admin'))
                <flux:menu.item icon="trash" wire:click="showConfirmDeleteForm({{ $user->id }})" variant="danger">Delete User</flux:menu.item>
                @endif
            </flux:menu>
        </flux:dropdown>
    </flux:table.cell>
</flux:table.row>