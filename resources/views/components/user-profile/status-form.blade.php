<div>
    <!-- Post Form -->
    @if(auth()->user()->id === $this->user->id)
        <div class="mb-4">
        <flux:textarea 
            x-data="{shiftPressed: false}" 
            @keydown.enter.prevent="
                if (shiftPressed) {
                    $event.target.value += '\n'; // Allows Shift + Enter to add a new line
                } else {
                    $wire.post();
                }
            "
            @keydown.shift="shiftPressed = true"
            @keyup.shift="shiftPressed = false"
            wire:model="status"
            type="text"
            class="w-full"
            placeholder="What are you up to?"
            rows="auto"
            resize="none"
            wire:loading.class="opacity-50"
        />

        <flux:error name="status" />
    </div>
    @endauth
</div>