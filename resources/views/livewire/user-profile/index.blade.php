<section>
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Left Pane (profile picture, name etc) -->
        <x-user-profile.user-information />

        <!-- Right Pane (posts etc) -->
        <div class="w-full md:w-3/4">
            @if(Auth::user()->hasAccessToUser($this->user) && $this->isBlocked === false)
                <livewire:user-post
                    :userId="$user->id"
                />
            @elseif(Auth::user()->hasAccessToUser($this->user) && $this->isBlocked === true)
                <x-user-profile.blocked />
            @else
                <x-user-profile.private />
            @endif
        </div>
    </div>
</section>