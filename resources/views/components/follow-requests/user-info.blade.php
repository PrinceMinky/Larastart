<div class="flex gap-2">
    <flux:avatar :name="$request->name" color="auto" />
    
    <div class="flex flex-col gap-0">
        <flux:heading>
            <flux:link wire:navigate :href="route('profile.show', ['username' => $request->username])" variant="ghost" class="flex gap-0 !no-underline !hover:no-underline">
                {{ $request->name }}
            </flux:link>
        </flux:heading>
        <flux:text>{{ $request->username }}</flux:text>
    </div>
</div>