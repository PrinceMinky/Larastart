<div class="flex flex-col gap-3 w-full md:w-1/4">
    <flux:avatar :name="$this->user->name" color="auto" size="xl" />

    <div class="flex flex-col gap-0">
        <flux:heading size="xl">{{ $this->user->name }}</flux:heading>
        <flux:subheading>{{ $this->user->username }}</flux:subheading>
    </div>

    @if(Auth::user()->hasAccessToUser($this->user) && $this->isBlocked === false)
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

        <x-user-profile.follow-status />
    </div>
    @endif

    <x-user-profile.actions />

    <x-user-profile.mutual-followers />
</div>