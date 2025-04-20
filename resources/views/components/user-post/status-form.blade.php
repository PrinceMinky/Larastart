<div>
    <!-- Post Form -->
    @if(auth()->user()->me($this->userId))
        <form wire:submit="post" class="mb-4">
            <flux:input
                wire:model="status"
                type="text"
                class="w-full"
                placeholder="What are you up to?"
                wire:loading.class="opacity-50"
            />

            <flux:error name="status" />
        </form>
    @endauth
</div>