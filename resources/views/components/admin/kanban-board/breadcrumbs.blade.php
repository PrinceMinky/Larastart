<flux:breadcrumbs class="mb-3">
    <flux:breadcrumbs.item href="{{ route('admin.kanban_list') }}">Kanban Boards</flux:breadcrumbs.item>
    <flux:breadcrumbs.item>{{ $this->currentBoard->title }}</flux:breadcrumbs.item>
</flux:breadcrumbs>