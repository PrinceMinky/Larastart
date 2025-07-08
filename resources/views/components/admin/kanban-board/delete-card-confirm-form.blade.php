<flux:modal name="delete-card-form" class="min-w-[22rem]">
    <form wire:submit="deleteCard" class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Card?</flux:heading>

            <flux:subheading>
                <p>You're about to delete a card.</p>
                <p>This action cannot be reversed.</p>
            </flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" autofocus>Delete card</flux:button>
        </div>
    </form>
</flux:modal>