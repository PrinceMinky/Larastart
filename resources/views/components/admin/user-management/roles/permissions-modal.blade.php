<flux:modal name="show-permissions-modal" class="w-full">
    <flux:heading>Permissions for {{ $this->name }}</flux:heading>
    <flux:subheading>Showing a list of permissions for a selected role.</flux:subheading>

    <div class="mt-4">
        @php
            $resourceGroups = [];
            $singlePermissions = [];
            
            // Group resource permissions (create, edit, view, delete)
            foreach($this->selectedPermissions as $permission) {
                $parts = explode(' ', $permission);
                $action = $parts[0] ?? '';
                $resource = implode(' ', array_slice($parts, 1)) ?? '';
                
                if (in_array($action, ['create', 'edit', 'view', 'delete']) && !empty($resource)) {
                    $resourceGroups[$resource][] = $action;
                } else {
                    $singlePermissions[] = $permission;
                }
            }
        @endphp
        
        @if(!empty($resourceGroups) || !empty($singlePermissions))
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                {{-- Display resource groups --}}
                @foreach($resourceGroups as $resource => $actions)
                    <div>
                        <flux:text size="sm" class="font-semibold">{{ ucwords($resource) }}</flux:text>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($actions as $action)
                                <flux:badge size="sm">{{ ucfirst($action) }}</flux:badge>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                {{-- Display remaining single permissions with proper wrapping --}}
                @if(!empty($singlePermissions))
                    <div class="@if(count($resourceGroups) === 0) col-span-full @endif">
                        <flux:text size="sm" class="font-semibold">Other Permissions</flux:text>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($singlePermissions as $permission)
                                <flux:badge size="sm">{{ ucwords($permission) }}</flux:badge>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @else
            <flux:text size="sm">This role has no permissions.</flux:text>
        @endif
    </div>
</flux:modal>