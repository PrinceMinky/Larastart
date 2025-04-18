<flux:modal name="delete-permission-form" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete permission?</flux:heading>

            <flux:subheading>
                <p>You're about to delete a permission.</p>
                <p>This action cannot be reversed.</p>
            </flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" wire:click="delete" autofocus>Delete permission</flux:button>
        </div>
    </div>
</flux:modal>