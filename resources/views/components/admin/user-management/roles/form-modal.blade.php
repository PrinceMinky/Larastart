<flux:modal variant="flyout" name="show-role-form">
    <flux:heading>
        @if(!$this->roleId)
            Add Role
        @else
            Edit Role
        @endif
    </flux:heading>
    <flux:subheading>Assigning permissions to a role.</flux:subheading>

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input 
            wire:model="name" 
            label="Name" 
            type="text" 
            :readonly="in_array($this->roleId, [2, 3])" 
            :disabled="in_array($this->roleId, [2, 3])" 
        />

        <flux:label>Permissions</flux:label>

        @php
            $resourceGroups = [];
            $singlePermissions = [];

            foreach ($this->permissions as $permission) {
                $permissionParts = explode(' ', $permission->name);
                $permissionAction = $permissionParts[0] ?? '';
                $permissionResource = implode(' ', array_slice($permissionParts, 1)) ?? '';

                if (in_array($permissionAction, ['create', 'edit', 'view', 'delete','export']) && !empty($permissionResource)) {
                    $resourceGroups[$permissionResource][] = $permission->name;
                } else {
                    $singlePermissions[] = $permission->name;
                }
            }
        @endphp

        @foreach($resourceGroups as $resource => $actions)
        <flux:checkbox.group>
            <flux:card class="flex flex-col gap-2">
                <flux:heading>{{ ucwords($resource) }}</flux:heading>

                <flux:tooltip content="Select all permissions for {{ ucwords($resource) }}">
                    <flux:checkbox.all />
                </flux:tooltip>
                
                <flux:fieldset>
                    <div class="flex flex-wrap gap-4">
                    @foreach($actions as $action)
                        <flux:checkbox wire:model="selectedPermissions" value="{{ $action }}" label="{{ ucfirst($action) }}" />
                    @endforeach
                    </div>
                </flux:fieldset>
            </flux:card>
        </flux:checkbox.group>
        @endforeach

        @if(!empty($singlePermissions))
        <flux:checkbox.group>
            <flux:card class="flex flex-col gap-2">
                <flux:heading>Other Permissions</flux:heading>
                
                <flux:tooltip content="Select all other permissions">
                    <flux:checkbox.all />
                </flux:tooltip>

                <flux:fieldset>
                    <div class="flex flex-wrap gap-4">
                    @foreach($singlePermissions as $permission)
                        <flux:checkbox wire:model="selectedPermissions" value="{{ $permission }}" label="{{ ucwords($permission) }}" />
                    @endforeach
                    </div>
                </flux:fieldset>
            </flux:card>
        </flux:checkbox.group>
        @endif

        <div class="flex gap-2">
            <flux:spacer />
            <flux:button x-on:click="$flux.modal('show-role-form').close()">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:modal>