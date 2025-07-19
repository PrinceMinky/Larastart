<flux:modal name="users-associate-form" class="w-full">
    <flux:heading>Associate Users</flux:heading>

    <form wire:submit="associateUsers" class="my-6 w-full space-y-6">
        <flux:select  
            variant="listbox" 
            multiple 
            placeholder="Select users to associated with board..."
            wire:model="selectedUserIds"
        >
            @foreach($this->eligibleUsers as $user)
                <flux:select.option value="{{ $user->id }}">
                    {{ $user->name }} ({{ $user->email }})
                </flux:select.option>
            @endforeach
        </flux:select>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:button x-on:click="$flux.modal('users-associate-form').close()">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:modal>