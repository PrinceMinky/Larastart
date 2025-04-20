<section>
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Left Pane (profile picture, name etc) -->
        <x-user-profile.user-information />

        <!-- Right Pane (posts etc) -->
        <div class="w-full md:w-3/4">
            <x-user-profile.status-form />

            <!-- Show Posts -->
            @if(auth()->user()->hasAccessToUser($this->user, 'view users'))
            <div class="flex flex-col gap-2">
                @forelse ($this->posts() as $post)
                    <x-user-profile.post :$post />
                @empty
                    @if(auth()->user()->id === $this->user->id)
                        <flux:text>You have not posted before. Post something!</flux:text>
                    @else
                        <flux:text>User has not posted before.</flux:text>
                    @endif
                @endforelse
            </div>
            @else
                <x-user-profile.private />
            @endif
        </div>
    </div>
</section>