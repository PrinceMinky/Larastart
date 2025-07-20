<div>
    <flux:modal name="mutual-followers-modal" class="md:w-96">
        <flux:heading size="lg">Mutual Followers</flux:heading>
        
        <div class="flex flex-col gap-3 mt-4">
            @foreach($this->mutualFollowers as $user)
                <x-user-profile.modal-row :$user />
            @endforeach
        </div>
    </flux:modal>
</div>