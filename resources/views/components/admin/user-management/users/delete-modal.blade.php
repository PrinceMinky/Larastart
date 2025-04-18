<flux:modal name="delete-user-form" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete user?</flux:heading>

            <flux:subheading>
                <p>You're about to delete user: {{ $this->userId ? $this->name : 'Unknown' }}</p>
                <p>This action cannot be reversed.</p>
            </flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" wire:click="delete">Delete user</flux:button>
        </div>
    </div>
</flux:modal>