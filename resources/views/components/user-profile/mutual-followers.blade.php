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