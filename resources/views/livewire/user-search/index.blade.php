<section class="flex flex-col gap-2">
    <!-- Display Heading -->
    <x-page-heading>
        <x-slot name="heading">{{ __('Users') }}</x-slot>
    </x-page-heading>

    <!-- Display Search -->
    <div class="flex gap-2">
        <x-user-search.search />

        {!! $this->filtersDropdown() !!}
    </div>

    {!! $this->activeFilters() !!}

    <!-- Display Users -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
        @foreach ($this->users as $user)
            <x-user-search.card :$user />
        @endforeach
    </div>

    <!-- Pagination -->
    <flux:pagination class="mt-6" :paginator="$this->users" />
</section>