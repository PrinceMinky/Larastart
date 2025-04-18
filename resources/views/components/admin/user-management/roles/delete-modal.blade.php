<flux:modal name="delete-role-form" class="min-w-[22rem]">
    <form wire:submit="delete" class="space-y-6">
        <div>
            <flux:heading size="lg">Delete role?</flux:heading>

            <flux:subheading>
                <p>You're about to delete a role.</p>
                <p>This action cannot be reversed.</p>
            </flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" autofocus>Delete role</flux:button>
        </div>
    </form>
</flux:modal>