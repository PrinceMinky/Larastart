<flux:modal name="showModal" class="md:w-96">
    <flux:heading size="lg">{{ $this->modalType === 'following' ? 'Following' : 'Followers' }}</flux:heading>
    
    <div class="flex flex-col gap-3 mt-4">
        @foreach($this->modalType === 'following' ? $this->getFollowing() : $this->getFollowers() as $followUser)
        <div class="flex items-center justify-between gap-2">
            <div class="flex gap-2">
                <flux:avatar :name="$followUser->name" color="auto" />
                
                <div class="flex flex-col gap-0">
                    <flux:heading>
                        <flux:link wire:navigate :href="route('profile.show', ['username' => $followUser->username])" variant="ghost" class="flex gap-0 !no-underline !hover:no-underline">
                            {{ $followUser->name }}
                        </flux:link>
                    </flux:heading>
                    <flux:text>{{ $followUser->username }}</flux:text>
                </div>
            </div>

            <div>
                <x-user-profile.follow-button :user="$followUser" />
            </div>
        </div>
        @endforeach
    </div>
</flux:modal>