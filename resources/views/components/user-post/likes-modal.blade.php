<flux:modal name="show-likes" class="md:w-96">
    <flux:heading size="lg">Likes</flux:heading>
    
    <div class="flex flex-col gap-3 mt-4">
        @foreach($likedUsers as $user)
            <x-user-profile.modal-row :$user />
        @endforeach
    </div>
</flux:modal>