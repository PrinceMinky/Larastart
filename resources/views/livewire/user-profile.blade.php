<section>
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Left Pane (profile picture, name etc) -->
        <div class="flex flex-col gap-3 w-full md:w-1/4">
            <flux:avatar :name="$this->user->name" color="auto" size="xl" />

            <div class="flex flex-col gap-0">
                <flux:heading size="xl">{{ $this->user->name }}</flux:heading>
                <flux:subheading>{{ $this->user->username }}</flux:subheading>
            </div>

            <div class="flex flex-col gap-0">
                <div class="flex justify-between w-full">
                    <flux:text variant="strong">Age</flux:text>
                    <flux:text>{{ $this->user->date_of_birth->age }}</flux:text>
                </div>

                <div class="flex justify-between w-full">
                    <flux:text variant="strong">Email</flux:text>
                    <flux:text>{{ $this->user->email }}</flux:text>
                </div>

                <div class="flex justify-between w-full">
                    <flux:text variant="strong">Country</flux:text>
                    <flux:text>{{ $this->user->country->label() }}</flux:text>
                </div>
            </div>

            @if(auth()->user()->id === $user->id)
                <flux:button wire:navigate :href="route('settings.profile')" size="sm">Edit Profile</flux:button>
            @endif
        </div>

        <!-- Right Pane (posts etc) -->
        <div class="w-full md:w-3/4">
            <!-- Post Form -->
            @if(auth()->user()->id === $user->id)
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
            @endauth

            <!-- Show Posts -->
            <div class="flex flex-col gap-2 mt-4">
                @forelse ($user->posts()->latest()->get() as $post)
                <flux:card class="relative flex flex-col gap-2 group" size="sm">
                    <div class="absolute top-2 right-2">
                        <flux:dropdown position="bottom" align="end">
                            <flux:button icon="ellipsis-horizontal" size="sm" />
                
                            <flux:menu>
                                <flux:menu.item icon="trash" wire:confirm="Are you sure you wish to delete this post?" wire:click="deletePost({{ $post->id }})" variant="danger">Delete Post</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>

                    <div class="flex gap-2">
                        <flux:avatar :name="$user->name" color="auto" />
                        
                        <div class="flex flex-col gap-0">
                            <flux:heading>{{ $user->name }}</flux:heading>
                            <flux:text>Posted on {{ $post->created_at->format('M d, Y') }}</flux:text>
                        </div>
                    </div>

                    <flux:separator />

                    <flux:text>{{ $post->content }}</flux:text>
                    
                    <flux:separator />

                    <div class="flex gap-5">
                    <flux:text class="flex gap-2 items-center text-xs">
                        <flux:icon.hand-thumb-up size="sm" />
                        <flux:link variant="subtle" clase="text-sm" class="cursor-pointer" @click="alert('Coming Soon...')">
                            Like
                        </flux:link>
                    </flux:text>

                    <flux:text class="flex gap-2 items-center text-xs">
                        <flux:icon.chat-bubble-left-ellipsis size="sm" />
                        <flux:link variant="subtle" clase="text-sm" class="cursor-pointer" @click="alert('Coming Soon...')">
                            Comment
                        </flux:link>
                    </flux:text>
                    </div>
                </flux:card>
                @empty
                    @if(auth()->user()->id === $user->id)
                        <flux:text>You have not posted before. Post something!</flux:text>
                    @else
                        <flux:text>User has not posted before.</flux:text>
                    @endif
                @endforelse
            </div>
        </div>
    </div>
</section>