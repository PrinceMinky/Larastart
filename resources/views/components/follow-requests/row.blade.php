<flux:card :key="$request->id">
    <div class="flex items-center justify-between gap-2">
        <x-follow-requests.user-info :$request />
        <x-follow-requests.actions :$request />
    </div>
</flux:card>