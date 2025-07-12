<section>
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Kanban Board Task') }}</x-slot>
        <x-slot name="subheading">{{ __('One of the tasks you have..') }}</x-slot>
    </x-page-heading>

    <div class="flex gap-2">
        <!-- Left Column -->
        <div class="w-2/3">
            <!-- Breadcrumbs -->
            <flux:breadcrumbs class="mb-3">
                <flux:breadcrumbs.item :href="route('admin.kanban_list')">Kanban Boards</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('admin.kanban_board', $card->board->slug)">{{ $card->board->title }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('admin.kanban_board', $card->column->slug)">{{ $card->column->title }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ $card->title }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>

            <!-- Card Detail -->
            <x-admin.kanban-board.card :$card />

            <!-- Comments -->
            <flux:card size="sm" class="mt-2">
                <livewire:comments :model="$card" />
            </flux:card>
        </div>

        <!-- Right Column -->
        <div class="w-1/3">
            @if($card->assigned_user_id)
                <flux:heading size="lg">
                    Assigned Member
                </flux:heading>

                <div class="w-full flex flex-justify items-center gap-4">
                    <flux:tooltip content="Unassign {{ $card->user->name }} from this card.">
                        <flux:profile
                            wire:click="removeAssignedUser"
                            iconTrailing="minus"
                            name="{{ $card->user->name }}"
                            color="auto"
                            :chevron="false"
                            class="cursor-pointer"
                        />
                    </flux:tooltip>
                </div>
            @else
                <flux:heading size="lg">
                    Assign User
                </flux:heading>

                @foreach($boardUsers as $user)
                    <flux:tooltip content="Assign {{ $user->name }} to this card.">
                        <flux:profile
                            wire:click="assignUser({{ $user->id }})"
                            iconTrailing="plus"
                            name="{{ $user->name }}"
                            color="auto"
                            :chevron="false"
                            class="cursor-pointer"
                        />
                    </flux:tooltip>
                @endforeach
            @endif
        </div>
    </div>
</section>
