@props(['comment', 'level' => 0])

<div 
    class="relative flex gap-4" 
    style="{{ $this->indentReplies ? 'margin-left: ' . ($level * 20) . 'px;' : '' }}">

    <!-- Avatar -->
    <flux:avatar
        :name="($this->useFullName) ? $comment->user->name : $comment->user->username"
        color="auto"
        size="sm"
        :href="route('profile.show', ['username' => $comment->user->username])"
    />

    <!-- Comment Body -->
    <div class="w-full">
        <div class="flex flex-row sm:items-center">
            <div class="flex flex-col gap-0.5 sm:gap-2 sm:flex-row sm:items-center">
                <div class="flex items-center gap-2">
                    <flux:heading>
                        <flux:link 
                            variant="subtle"
                            :href="route('profile.show', ['username' => $comment->user->username])"
                            :external="true">
                            {{ ($this->useFullName) ? $comment->user->name : $comment->user->username ?? 'Unknown User' }}
                        </flux:link>
                    </flux:heading>
                    @if ($comment->user->is_moderator)
                        <flux:badge color="lime" size="sm" icon="check-badge" inset="top bottom">Moderator</flux:badge>
                    @endif
                </div>
                <flux:text class="text-sm">{{ $comment->created_at->diffForHumans() }}</flux:text>
            </div>
        </div>

        @if ($this->editingId === $comment->id)
            <div x-data x-on:click.outside="$wire.cancelEditing()">
                <flux:textarea 
                    wire:model.defer="updateCommentForm.body" 
                    class="w-full border rounded p-2 mt-1"
                    id="edit-textarea"
                />
                <flux:error name="updateCommentForm.body" />

                <div class="mt-3 flex gap-2 justify-end">
                    <flux:button size="sm" wire:click="cancelEditing" variant="ghost">Cancel</flux:button>
                    <flux:button size="sm" wire:click="saveEdit">Save</flux:button>
                </div>
            </div>
        @else
            <flux:text variant="strong">{{ $comment->body }}</flux:text>

            <!-- Interactions -->
            <div class="flex items-center gap-2 mt-2">
                <div class="flex items-center gap-2">
                    @php
                        $userLiked = $comment->is_liked_by_current_user;
                    @endphp

                    <flux:icon.hand-thumb-up
                        :variant="$userLiked ? 'solid' : 'outline'"
                        class="size-4 cursor-pointer text-{{ $userLiked ? 'blue-500' : 'zinc-400' }} [&_path]:stroke-[2.25]"
                        wire:click="like({{ $comment->id }})"
                    />

                    <flux:text
                        class="text-sm tabular-nums cursor-pointer"
                        wire:click="showLikes({{ $comment->id }})"
                    >
                        {{ $this->getLikeText($comment, $comment->likedByUsers->count()) }}
                    </flux:text>
                </div>

                @if ($this->canEdit($comment) || $this->canDelete($comment))
                    <flux:dropdown position="bottom" align="end" class="absolute top-2 right-2">
                        <flux:button variant="ghost" icon="ellipsis-horizontal" square size="sm" />

                        <flux:menu>
                            @if ($this->canEdit($comment))
                                <flux:menu.item wire:click="startEditing({{ $comment->id }})">Edit</flux:menu.item>
                            @endif

                            @if ($this->canDelete($comment))
                                <flux:menu.item variant="danger" wire:click="deleteComment({{ $comment->id }})">Delete</flux:menu.item>
                            @endif
                        </flux:menu>
                    </flux:dropdown>
                @endif
            </div>

            <!-- Reply toggle and box -->      
            <div
                class="mt-2"
                x-data="{
                    showReply: false,
                    username: '',
                    open() {
                        this.showReply = true;

                        $nextTick(() => {
                            const textarea = this.$refs.replyTextarea;
                            textarea.focus();

                            if (!textarea.value.startsWith(this.username)) {
                                textarea.value = this.username + ' ';
                                textarea.dispatchEvent(new Event('input'));
                            }
                        });
                    },
                    close() {
                        this.showReply = false;
                        // No network request - just hide the UI
                    }
                }"
                x-init="
                    username = {{ json_encode('@' . $comment->user->username) }};

                    Livewire.on('reply-posted', event => {
                        if (event.commentId === {{ $comment->id }}) {
                            showReply = false;
                        }
                    });
                "
            >
                <flux:button
                    inset="left"
                    size="sm"
                    variant="ghost"
                    @click="open"
                >
                    Reply
                </flux:button>

                <div 
                    x-show="showReply" 
                    x-transition 
                    x-cloak 
                    class="mt-2 space-y-2"
                    x-on:click.outside="close()"
                >
                    <flux:textarea
                        x-ref="replyTextarea"
                        wire:model.defer="storeReplyForm.body.{{ $comment->id }}"
                        class="w-full border rounded p-2"
                        placeholder="Write a reply..."
                        resize="none"
                        rows="1"
                    />
                    <flux:error name="storeReplyForm.body.{{ $comment->id }}" />

                    <div class="flex justify-end gap-2">
                        <flux:button
                            size="sm"
                            variant="ghost"
                            @click="close"
                        >
                            Cancel
                        </flux:button>
                        <flux:button
                            size="sm"
                            wire:click="postReply({{ $comment->id }})"
                        >
                            Post Reply
                        </flux:button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recursive children -->
        @if ($comment->children->count())
            @if($level === 0)
            <div x-data="{ open: false }">
                <flux:button size="sm" inset="left right" variant="subtle" x-on:click="open = ! open" x-show="!open">
                    {{ $comment->children->count() }}
                    {{ str_plural('Comment', $comment->children->count()) }}
                </flux:button>

                <div x-show="open" x-cloak class="flex flex-col gap-2">
                    @foreach ($comment->children as $child)
                        <x-comments.item :comment="$child" :level="$level + 1" />
                    @endforeach
                </div>
            </div>
            @else
                <div class="flex flex-col gap-2">
                    @foreach ($comment->children as $child)
                        <x-comments.item :comment="$child" :level="$level + 1" />
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</div>

@script
<script>
    Livewire.on('focus-edit-textarea', () => {
        requestAnimationFrame(() => {
            const textarea = document.getElementById('edit-textarea');
            if (textarea) textarea.focus();
        });
    });
</script>
@endscript
