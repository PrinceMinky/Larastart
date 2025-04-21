<flux:modal name="show-user-form" variant="flyout">
    <flux:heading>{{ !$this->userId ? "Add User" : "Edit User" }}</flux:heading>

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <!-- Name -->
        <flux:input 
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            :placeholder="__('Name')"
        />

        <!-- Username -->
        <flux:input
            wire:model="username"
            :label="__('Username')"
            type="text"
            required
            autocomplete="username"
            :placeholder="__('Username')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Date of Birth -->
        <flux:date-picker
            wire:model="date_of_birth"
            :label="__('Date of Birth')"
            selectable-header
        />

        <!-- Country -->
        <flux:select wire:model="country" placeholder="Choose Country" variant="listbox" searchable label="Country">
            @foreach (App\Enums\Country::cases() as $country)
                <flux:select.option value="{{ $country->value }}">{{ $country->label() }}</flux:select.option>
            @endforeach
        </flux:select>
        
        <!-- Roles -->
        @if(! $this->isSuperAdmin)
        <flux:select
            wire:model="roles"
            label="Role(s)"
            variant="listbox"
            searchable
            multiple
            clear="close"
            placeholder="Select role(s)"
        >
            @foreach($this->roles() as $role)
                <flux:select.option>{{ $role->name }}</flux:select.option>
            @endforeach
        </flux:select>
        @endif

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            autocomplete="new-password"
            :placeholder="__('Password')"
            description="If left blank password will be defaulted to: password"
        />

        <!-- Privacy -->
        <flux:switch wire:model="is_private" label="Make profile private" align="left" />

        <div class="flex gap-2">
            <flux:spacer />

            <flux:button x-on:click="$flux.modal('show-user-form').close()">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:modal>