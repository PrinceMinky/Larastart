@if(! auth()->user()->me($this->user->id) && $this->mutualFollowers->isNotEmpty() && Auth::user()->hasAccessToUser($this->user) && $this->isBlocked === false)
<div class="mt-4">
    <flux:heading>Mutual Followers</flux:heading>
    <flux:avatar.group class="**:ring-zinc-100 dark:**:ring-zinc-800">
        @foreach($this->mutualFollowers->take(3) as $mutualFollower)
            <flux:avatar :name="$mutualFollower->name" color="auto" :href="$mutualFollower->url()" />
        @endforeach
        @if($this->mutualFollowers->count() > 3)
            <flux:avatar x-on:click="$flux.modal('mutual-followers-modal').show()" class="cursor-pointer">{{ $this->mutualFollowers->count() - 3 }}+</flux:avatar>
        @endif
    </flux:avatar.group>

    <x-user-profile.mutual-followers-modal />
</div>
@endif