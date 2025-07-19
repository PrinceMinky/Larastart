@php
    // Find the column object whose slug matches the selectedColumn slug
    $selectedColumnObject = $this->currentBoard->columns->firstWhere('slug', $this->selectedColumn);

    // Get the column name/title or fallback to slug if not found
    $selectedColumnTitle = $selectedColumnObject ? $selectedColumnObject->title ?? $selectedColumnObject->name ?? $this->selectedColumn : $this->selectedColumn;
@endphp

<flux:breadcrumbs class="mb-3">
    <flux:breadcrumbs.item href="{{ route('admin.kanban_list') }}">
        Kanban Boards
    </flux:breadcrumbs.item>

    @if($this->selectedColumn)
        <flux:breadcrumbs.item href="{{ route('admin.kanban_board', $this->currentBoard->slug) }}">
            {{ $this->currentBoard->title ?? $this->currentBoard->name }}
        </flux:breadcrumbs.item>

        <flux:breadcrumbs.item>
            {{ $selectedColumnTitle }}
        </flux:breadcrumbs.item>
    @else
        <flux:breadcrumbs.item>
            {{ $this->currentBoard->title ?? $this->currentBoard->name }}
        </flux:breadcrumbs.item>
    @endif
</flux:breadcrumbs>
