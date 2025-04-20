<section>
    <!-- Display Heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Users') }}</x-slot>
    </x-page-heading>

    <!-- Display Search -->
    <div class="mb-6">
        <flux:input wire:model.live="search" placeholder="Search Users..." clearable />
    </div>

    <!-- Display Users -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
        @foreach ($this->users as $user)
        <flux:card size="sm" wire:key="{{ $user->id }}" wire:navigate :href="route('profile.show', ['username' => $user->username])"
            class="cursor-pointer transition-shadow hover:shadow-md">
            
            <div class="flex gap-2">
                <flux:avatar :name="$user->name" color="auto" />
                
                <div class="flex flex-col gap-0">
                    <flux:heading>{{ $user->name }}</flux:heading>
                    <flux:text>{{ $user->username }}</flux:text>
                </div>
            </div>

            <div>
                <!-- Stats Section Below the Card -->
                <div class="flex gap-4 text-sm text-gray-600 mt-2">
                    <flux:text size="sm" variant="subtle" class="flex flex-col items-start">
                        Posts
                        <flux:badge size="sm">{{ $user->posts->count() }}</flux:badge>
                    </flux:text>
                </div>
            </div>
        </flux:card>
        @endforeach
    </div>

    <!-- Pagination -->
    <flux:pagination class="mt-6" :paginator="$this->users" />
</section>