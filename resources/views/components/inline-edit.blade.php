@props([
    'model' => null,
    'field' => '',
    'permission' => '',
])

<div>
    @if(is_array($this->editing) && $model->id === $this->editing[0] && $this->editing[1] === $field)
        <div 
            @click.away="$wire.cancelEdit" 
            class="ml-1 flex items-center space-x-2"
        >
            <flux:input.group>
                <flux:input  
                    wire:model="temp"  
                    wire:keydown.enter="saveInline('{{ addslashes(get_class($model)) }}', {{ $model->id }}, '{{ $field }}', '{{ $permission }}')"
                    wire:keydown.escape="cancelEdit"
                    x-init="$el.focus()" 
                    data-inline-edit="true"
                    class:input="!focus:ring-0 !focus:ring-offset-0"
                />
                <flux:button  
                    icon="check"
                    wire:click="saveInline('{{ addslashes(get_class($model)) }}', {{ $model->id }}, '{{ $field }}', '{{ $permission }}')"
                />
            </flux:input.group>
        </div>
    @else
        <div 
            class="
                px-2 py-1 cursor-pointer rounded
                data-current:text-[var(--color-accent-content)] 
                hover:data-current:text-[var(--color-accent-content)] 
                data-current:bg-zinc-800/[4%] 
                dark:data-current:bg-white/[7%] 
                hover:text-zinc-800 
                dark:hover:text-white 
                hover:bg-zinc-800/[4%] 
                dark:hover:bg-white/[7%]"
            wire:click="startEditing({{ $model->id }}, '{{ $field }}', '{{ $model->$field }}')"
        >
            {{ $model->$field }}
        </div>
    @endif
</div>