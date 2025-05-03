<flux:modal name="show-likes" class="md:w-2xl">
    <div class="flex flex-col gap-2">
        <flux:heading size="lg">Likes</flux:heading>
        
        <flux:input type="text" wire:model.live="likesSearch" class="w-full" placeholder="Search Users..." />
    </div>
    
    <div class="flex flex-col gap-3 mt-4">
        @foreach($this->getFilteredLikedUsers() as $user)
            <x-user-profile.modal-row :$user :showButton="true" />
        @endforeach
    </div>
</flux:modal>