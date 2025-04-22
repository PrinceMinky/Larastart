<div class="flex items-center justify-between gap-2">
    <div class="flex gap-2">
        <flux:avatar :name="$user->name" color="auto" />
        
        <div class="flex flex-col gap-0">
            <flux:heading>
                <flux:link wire:navigate :href="route('profile.show', ['username' => $user->username])" variant="ghost" class="flex gap-0 !no-underline !hover:no-underline">
                    {{ $user->name }}
                </flux:link>
            </flux:heading>
            <flux:text>{{ $user->username }}</flux:text>
        </div>
    </div>

    <div>
        <x-user-profile.follow-button :user="$user" />
    </div>
</div>