<div>
    <!-- Post Form -->
    @if(auth()->user()->me($this->userId))
    <flux:card size="sm" class="mb-4">
        <form wire:submit="post" class="flex flex-col justify-between gap-2" x-data="{ focused: false, status: '' }">
            <flux:textarea
                wire:model="status"
                type="text"
                class="w-full"
                placeholder="What are you up to?"
                rows="auto"
                resize="none"
                wire:loading.class="opacity-50"
                @focus="focused = true"
                @blur="focused = false"
                @input="status = $event.target.value"
            />

            <flux:error name="status" />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" x-show="focused || status.length > 0">Post</flux:button>
            </div>
        </form>
    </flux:card>
    @endauth
</div>