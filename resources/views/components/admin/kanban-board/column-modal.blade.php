<flux:modal name="column-form" class="w-full">
    <flux:heading>{{ !$this->columnForm->id ? "Add Column" : "Edit Column" }}</flux:heading>

<form wire:submit="saveColumn"class="my-6 w-full space-y-6">
    <!-- Title -->
    <flux:input 
        wire:model.defer="columnForm.title"
        x-model="title"
        :label="__('Title')"
        type="text"
        required
        :placeholder="__('Title')"
    />

    <div class="flex gap-2">
        <flux:spacer />

        <flux:button x-on:click="$flux.modal('column-form').close()">Cancel</flux:button>
        <flux:button type="submit" variant="primary">Save</flux:button>
    </div>
</form>

</flux:modal>