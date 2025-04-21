<div class="flex flex-col gap-3 w-full md:w-1/4">
    <flux:avatar :name="$this->user->name" color="auto" size="xl" />

    <div class="flex flex-col gap-0">
        <flux:heading size="xl">{{ $this->user->name }}</flux:heading>
        <flux:subheading>{{ $this->user->username }}</flux:subheading>
    </div>

    @if(auth()->user()->hasAccessToUser($this->user, 'view users'))
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

        <div class="flex justify-left gap-3">
            @if($this->followingCount() > 0)
                <flux:text variant="strong" wire:click="showModal('following')" class="cursor-pointer">Following</flux:text>
            @else
                <flux:text variant="strong">Following</flux:text>
            @endif
            <flux:text>{{ $this->followingCount() }}</flux:text>
            
            @if($this->followerCount() > 0)
                <flux:text variant="strong" wire:click="showModal('followers')" class="cursor-pointer">Followers</flux:text>
            @else
                <flux:text variant="strong">Followers</flux:text>
            @endif
            <flux:text>{{ $this->followerCount() }}</flux:text>
        </div>

        @if($this->user->followers->contains(Auth::id()))
        <div class="flex justify-center mt-2">
            <flux:badge>Follows You</flux:badge>
        </div>
        @endif
    </div>
    @endif

    @if(auth()->user()->me($this->user->id))
        <flux:button wire:navigate :href="route('settings.profile')" size="sm">Edit Profile</flux:button>
    @else
        <x-user-profile.follow-button :user="$this->user" />

        <livewire:block-user :user="$this->user" />
    @endif

    @if(! auth()->user()->me($this->user->id) && $this->mutualFollowers->isNotEmpty())
        <div class="mt-4">
            <flux:heading>Mutual Followers</flux:heading>
            <flux:avatar.group>
                @foreach($this->mutualFollowers->take(3) as $mutualFollower)
                    <flux:avatar :name="$mutualFollower->name" color="auto" />
                @endforeach
                @if($this->mutualFollowers->count() > 3)
                    <flux:avatar>{{ $this->mutualFollowers->count() - 3 }}+</flux:avatar>
                @endif
            </flux:avatar.group>    
        </div>
    @endif

    <!-- Following Modal -->
    <x-user-profile.following-modal />
</div>