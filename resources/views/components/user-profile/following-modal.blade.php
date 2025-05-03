<flux:modal name="showModal" class="md:w-96">
    <div class="flex flex-col gap-2">
        <flux:heading size="lg">{{ $this->modalType === 'following' ? 'Following' : 'Followers' }}</flux:heading>

        <flux:input type="text" wire:model.live="search" class="w-full" placeholder="Search Users..." />
    </div>
    
    <div class="flex flex-col gap-3 mt-4">
        @foreach($this->modalType === 'following' ? $this->getFollowing() : $this->getFollowers() as $user)
            <x-user-profile.modal-row :$user />
        @endforeach
    </div>
</flux:modal>