<section>
    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>Blocked users</flux:heading>
    </div>

    @if($this->blockedUsers->count() > 0)
        <flux:table>
            <flux:table.rows>
                @foreach($this->blockedUsers as $user)
                <div class="flex justify-between items center">
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex items-center gap-2 sm:gap-4">
                                <flux:avatar size="sm" class="max-sm:size-8" color="auto" :name="$user->name" />
                                <div class="flex flex-col">
                                    <flux:heading>
                                        <flux:link :href="$user->url" variant="ghost">
                                            {{ $user->name }}
                                        </flux:link>
                                    </flux:heading>
                                    <flux:text variant="subtle">{{ $user->pivot->created_at->diffForHumans() }}</flux:text>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex justify-end items-center gap-2">
                                <flux:button size="sm" variant="subtle" icon="trash" class="shrink-0" wire:click="unblock({{ $user->id }})" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                </div>    
                @endforeach
            </flux:table.rows>
        </flux:table>
    @else
        <flux:text class="mt-2">You have blocked no users.</flux:text>
    @endif
    </div>
</section>