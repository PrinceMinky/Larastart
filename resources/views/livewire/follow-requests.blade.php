<section>
    <x-page-heading>
        <x-slot name="heading">Follow Requests</x-slot>
        <x-slot name="subheading">Pending requests from users that wish to follow you!</x-slot>
    </x-page-heading>

    <div class="mt-4 flex flex-col gap-2">
        @forelse ($this->requests() as $request)
        <flux:card>
        <div class="flex items-center justify-between gap-2">
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

            <div>
                <flux:button wire:click="accept({{ $request->id }})">Accept</flux:button>
                <flux:button wire:click="deny({{ $request->id }})" variant="danger">Deny</flux:button>
            </div>
        </div>
        </flux:card>
        @empty
            <flux:text>You have no requests</flux:text>
        @endforelse
    </div>
</section>
