<section>
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Left Pane (profile picture, name etc) -->
        <x-user-profile.user-information />

        <!-- Right Pane (posts etc) -->
        <div class="w-full md:w-3/4">
            <!-- Show Posts -->
            @if(auth()->user()->hasAccessToUser($this->user))
                @livewire('user-post', ['userId' => $user->id])
            @else
                <x-user-profile.private />
            @endif
        </div>
    </div>
</section>