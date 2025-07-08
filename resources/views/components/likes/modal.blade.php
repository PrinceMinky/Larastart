@props([
    'enableSearch' => true,
])

<flux:modal name="show-likes-modal" class="md:w-2xl">
    <div class="flex flex-col gap-2">
        <flux:heading size="lg">Likes</flux:heading>

        @if($enableSearch)
            <flux:input
                type="text"
                wire:model.live="likesSearch"
                class="w-full"
                placeholder="Search Likes..."
            />
        @endif
    </div>
    
    <div class="flex flex-col gap-3 mt-4">
        @if($this->getFilteredLikedUsers()->isEmpty())
            <flux:text variant="muted">No users found.</flux:text>
        @else
            @foreach($this->getFilteredLikedUsers() as $user)
                <x-user-profile.modal-row :user="$user" :showButton="true" />
            @endforeach
        @endif
    </div>
</flux:modal>