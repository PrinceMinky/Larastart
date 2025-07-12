<section class="flex flex-col gap-2">
    <!-- Display heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Activities') }}</x-slot>
        <x-slot name="subheading">{{ __('An overview of what\'s been going on.') }}</x-slot>
    </x-page-heading>

    <!-- Search/Filters and Actions -->
    <div class="flex gap-2">
        <div class="flex gap-2 w-2/4">
            <flux:input wire:model.live="search" placeholder="Search Logs" clearable />

            {!! $this->filtersDropdown() !!}
        </div>

        <flux:spacer />
        
        <div class="flex gap-2"></div>
    </div>

    {!! $this->activeFilters() !!}

    <!-- List of Activities -->
    <flux:table :paginate="$this->activities">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection" wire:click="sort('id')">ID</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'description'" :direction="$sortDirection" wire:click="sort('description')">Description</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'subject_type'" :direction="$sortDirection" wire:click="sort('subject_type')">Link</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'causer_type'" :direction="$sortDirection" wire:click="sort('causer_type')">Causer</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">Date</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->activities as $activity)
                <flux:table.row :key="$activity->id">
                    <flux:table.cell class="flex items-center gap-3">{{ $activity->id }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $activity->description }}</flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        @if($activity->subject_type && isset($activity->subject->url))
                            <flux:link href="{{ $activity->subject->url ?? '#' }}" variant="subtle">
                                {{ $activity->subject->display_name ?? 'N/A' }}
                            </flux:link>
                        @else
                            -
                        @endif
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">
                        @php
                            $causerId = $activity->causer_id;
                            $user = $usersList[$causerId] ?? null;
                        @endphp

                        @if($user)
                            <flux:link href="{{ route('profile.show', $user->username) }}" variant="subtle">
                                {{ $user->name }}
                            </flux:link>
                        @else
                            System
                        @endif
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $activity->created_at->format('jS F Y') }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</section>