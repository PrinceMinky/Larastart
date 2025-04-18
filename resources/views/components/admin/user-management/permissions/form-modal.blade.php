<flux:modal name="show-permission-form" class="w-full">
    <flux:heading>{{ !$this->permissionId ? "Add Permission" : "Edit Permission" }}</flux:heading>
    <flux:subheading>Adding a permission that can later be assigned to a user group.</flux:heading>

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" label="Name" type="text" />

        @if(!$this->permissionId)
        <flux:tooltip content="Resource: create, edit, delete and view." position="left">
            <flux:checkbox wire:model="createResource" label="Create as Resource" />
        </flux:tooltip>
        @endif

        <div class="flex gap-2">            
            <flux:spacer />

            <flux:button x-on:click="$flux.modal('show-permission-form').close()">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:modal>