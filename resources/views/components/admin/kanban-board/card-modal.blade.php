<flux:modal name="card-form" class="w-full">
    <flux:heading>{{ !$this->cardId ? "Add Card" : "Edit Card" }}</flux:heading>

    <form wire:submit="saveCard" class="my-6 w-full space-y-6">
        <!-- Title -->
        <flux:input 
            wire:model="cardTitle"
            :label="__('Title')"
            type="text"
            required
            :placeholder="__('Title')"
        />

        <!-- Description -->
        <flux:textarea
            wire:model="cardDescription"
            :label="__('Description (optional)')"
            :placeholder="__('Enter a description')"
        />

        <!-- Assigned User -->
        <flux:select 
            wire:model="cardUser"
            :label="__('Assign a Team Member')"
        >
            <flux:select.option value="0">{{ __('--- assign a team member ---') }}</flux:select.option>
            <flux:select.option value="{{ $this->currentBoard->owner->id }}">{{ $this->currentBoard->owner->name }}</flux:select.option>
            @foreach($this->eligibleUsers as $user)
                <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <!-- Due Date -->
        <flux:label>Due: </flux:label>
        <flux:card class="my-6 w-full space-y-6 mt-2">
            <flux:date-picker
                label="Date"
                wire:model="dueAtDate"
                with-today
                clearable
            >
                <x-slot name="trigger">
                    <flux:date-picker.input />
                </x-slot>
            </flux:date-picker>

            <flux:input.group>
                <flux:button size="sm" wire:click="addDays(1)" icon="plus">1 Day</flux:button>
                <flux:button size="sm" wire:click="addDays(7)" icon="plus">1 Week</flux:button>
                <flux:button size="sm" wire:click="addDays(30)" icon="plus">1 Month</flux:button>
            </flux:input.group>

            <!-- Show time only if date is set -->
            @if ($this->dueAtDate)
                <flux:input
                    label="Time"
                    description="Leaving this field blank will set a default time of midnight."
                    type="time"
                    wire:model="dueAtTime"
                />

                <flux:input.group>
                    <flux:button size="sm" wire:click="addMinutes(15)" icon="plus">15 minutes</flux:button>
                    <flux:button size="sm" wire:click="addMinutes(60)" icon="plus">1 hour</flux:button>
                    <flux:button size="sm" wire:click="addMinutes(240)" icon="plus">4 hours</flux:button>
                </flux:input.group>
            @endif
        </flux:card>

        <!-- Column -->
        <flux:select wire:model="columnId" label="Column" placeholder="Column...">
            @foreach($this->getColumnOptions() as $id => $title)
                <flux:select.option :value="$id">{{ $title }}</flux:select.option>
            @endforeach
        </flux:select>

        <!-- Badge(s) -->
        <flux:select wire:model.live="badgeTitle" label="Badge(s)" placeholder="Select badge title...">
            <flux:select.option value="">Select a badge...</flux:select.option>
            @foreach ($this->boardBadges as $badge)
                <flux:select.option :value="$badge['title']">{{ $badge['title'] }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:error name="badges" />

        <!-- Preview Added Badges -->
        @if(count($this->badges) > 0)
            <div class="flex flex-wrap gap-2">
                @foreach ($this->badges as $index => $badge)
                    <flux:badge :color="$badge['color']">
                        {{ $badge['title'] }}
                        <flux:badge.close wire:click="removeBadge({{ $index }})" />
                    </flux:badge>
                @endforeach
            </div>
        @endif
        
        <!-- Actions -->
        <div class="flex gap-2">
            <flux:spacer />

            <flux:button x-on:click="$flux.modal('card-form').close()">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Save</flux:button>
        </div>
    </form>
</flux:modal>
