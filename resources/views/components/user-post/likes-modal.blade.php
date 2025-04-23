<flux:modal name="show-likes" class="md:w-2xl">
    <flux:heading size="lg">Likes</flux:heading>
    
    <div class="flex flex-col gap-3 mt-4">
        @foreach($this->likedUsers as $user)
            <x-user-profile.modal-row :$user :showButton="false" />
        @endforeach
    </div>
</flux:modal>