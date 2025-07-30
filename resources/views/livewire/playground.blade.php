<section class="flex flex-col gap-4"> 
    <x-page-heading>
        <x-slot name="heading">Playground</x-slot>
        <x-slot name="subheading">This is where we get to play with Livewire and create something special.</x-slot>
    </x-page-heading>

    <div class="flex gap-2">
        <!-- User -->
        <div class="w-2/4 flex flex-col gap-2">
            <!-- Hero Info -->
            <flux:card size="sm">
                <flux:heading class="font-semibold">Hero</flux:heading>

                <flux:text>❤️ Health: {{ $hero['current_hp'] }}/{{ $hero['max_hp'] }}</flux:text>
                <flux:text>🛡️ Armor: {{ $hero['armor'] }}</flux:text>
                @if(isset($equipped['weapon']) && $equipped['weapon'])
                    <flux:text>⚔️ Weapon: {{ $equipped['weapon']['name'] }} ({{ $equipped['weapon']['damage'] ?? 0 }} dmg)</flux:text>
                @endif
            </flux:card>

            <!-- Equipment Display -->
            <flux:card size="sm">
                <flux:heading class="font-semibold">Equipment</flux:heading>
                
                <div class="grid grid-cols-2 gap-2 text-sm">
                    @foreach(['helmet', 'gauntlets', 'chest', 'legs', 'boots'] as $slot)
                        <flux:text class="capitalize">
                            {{ $slot }}: 
                            @if($equipped['armor'][$slot])
                                <span class="text-green-600">{{ $equipped['armor'][$slot]['name'] }}</span>
                                <span class="text-blue-600">(+{{ $equipped['armor'][$slot]['defense'] }})</span>
                            @else
                                <span class="text-gray-400">None</span>
                            @endif
                        </flux:text>
                    @endforeach
                </div>
            </flux:card>

            <!-- Inventory -->
            <flux:card size="sm">
                <flux:heading class="font-semibold">Inventory</flux:heading>

                @forelse ($this->groupedInventory as $group)
                    @php
                        $item = $group['item'];
                        $count = $group['count'];
                        $firstIndex = $group['indexes'][0];
                        
                        // Check if item is equipped and skip if it is
                        $isEquipped = false;
                        
                        if ($item['type'] === 'Armor') {
                            $isEquipped = isset($equipped['armor'][$item['slot']]) && 
                                        $equipped['armor'][$item['slot']]['name'] === $item['name'];
                        } elseif ($item['type'] === 'Weapon') {
                            $isEquipped = isset($equipped['weapon']) && 
                                        $equipped['weapon']['name'] === $item['name'];
                        }
                    @endphp

                    @if (!$isEquipped)
                        @if ($item['type'] === 'Consumable')
                            <flux:text
                                class="cursor-pointer hover:underline text-green-700 flex justify-between items-center"
                                wire:click="useItem({{ $firstIndex }})"
                            >
                                <span>{{ $item['name'] }} @if($count > 1) (x{{ $count }}) @endif</span>
                                @if(isset($item['heals']))
                                    <span class="text-xs text-green-600">+{{ $item['heals'] }} HP</span>
                                @endif
                            </flux:text>
                        @elseif($item['type'] === 'Armor')
                            <flux:text
                                class="cursor-pointer hover:underline flex justify-between items-center"
                                wire:click="equipItem({{ $firstIndex }})"
                            >
                                <span>
                                    {{ ucfirst($item['slot']) }}: {{ $item['name'] }} @if($count > 1) (x{{ $count }}) @endif
                                </span>
                                <span class="text-xs text-blue-600">+{{ $item['defense'] ?? 0 }} DEF</span>
                            </flux:text>
                        @elseif($item['type'] === 'Weapon')
                            <flux:text
                                class="cursor-pointer hover:underline flex justify-between items-center"
                                wire:click="equipItem({{ $firstIndex }})"
                            >
                                <span>
                                    {{ $item['name'] }} @if($count > 1) (x{{ $count }}) @endif
                                </span>
                                <span class="text-xs text-red-600">{{ $item['damage'] ?? 0 }} DMG</span>
                            </flux:text>
                        @else
                            <flux:text>
                                {{ $item['name'] }} @if($count > 1) (x{{ $count }}) @endif
                            </flux:text>
                        @endif
                    @endif
                @empty
                    <flux:text class="text-gray-500 italic">No items yet...</flux:text>
                @endforelse
            </flux:card>

            <!-- Engrams -->
            @if(count($engrams) > 0)
                <flux:card size="sm">
                    <flux:heading class="font-semibold">Engrams Found:</flux:heading>
                    @foreach ($this->groupedEngrams as $group)
                        @php
                            $rarity = $group['rarity'];
                            $count = $group['count'];
                            $firstIndex = $group['indexes'][0];
                            $engramId = $engrams[$firstIndex]['id'];
                            
                            // Color coding for rarity
                            $rarityColor = match($rarity) {
                                'Mythic' => 'text-purple-600 font-bold',
                                'Legendary' => 'text-yellow-600 font-semibold',
                                'Rare' => 'text-blue-600',
                                'Common' => 'text-gray-600',
                                default => 'text-gray-600'
                            };
                        @endphp

                        <flux:text
                            class="cursor-pointer hover:underline {{ $rarityColor }}"
                            wire:click="openEngram('{{ $engramId }}')"
                        >
                            🎁 {{ $rarity }} Engram @if($count > 1) (x{{ $count }}) @endif
                        </flux:text>
                    @endforeach
                </flux:card>
            @endif
        </div>

        <!-- Game -->
        <div class="w-3/4 flex flex-col gap-2">
            <!-- Dynamic Enemies -->
            <div class="flex flex-wrap gap-2">
                @forelse ($enemies as $enemy)
                    @php
                        $enemyType = collect([
                            'Dreg' => ['emoji' => '👹', 'rarity' => 'common'],
                            'Vandal' => ['emoji' => '🗡️', 'rarity' => 'common'],
                            'Goblin Scout' => ['emoji' => '🏃', 'rarity' => 'common'],
                            'Captain' => ['emoji' => '⚔️', 'rarity' => 'uncommon'],
                            'Orc Berserker' => ['emoji' => '🪓', 'rarity' => 'uncommon'],
                            'Shadow Assassin' => ['emoji' => '🥷', 'rarity' => 'uncommon'],
                            'Necromancer' => ['emoji' => '🧙‍♂️', 'rarity' => 'uncommon'],
                            'Troll Warlord' => ['emoji' => '👹', 'rarity' => 'rare'],
                            'Dragon Wyrmling' => ['emoji' => '🐉', 'rarity' => 'rare'],
                            'Lich King' => ['emoji' => '💀', 'rarity' => 'rare'],
                            'Ancient Demon' => ['emoji' => '😈', 'rarity' => 'legendary'],
                            'Void Stalker' => ['emoji' => '👁️', 'rarity' => 'legendary'],
                        ])[$enemy['name']] ?? ['emoji' => '👾', 'rarity' => 'common'];
                        
                        $rarityBorderColor = match($enemyType['rarity']) {
                            'legendary' => 'border-purple-500 bg-purple-50',
                            'rare' => 'border-yellow-500 bg-yellow-50',
                            'uncommon' => 'border-blue-500 bg-blue-50',
                            'common' => 'border-gray-300 bg-white',
                            default => 'border-gray-300 bg-white'
                        };
                    @endphp
                    
                    <flux:card size="sm" wire:key="enemy-{{ $enemy['id'] }}" class="{{ $rarityBorderColor }} border-2">
                        <flux:heading class="flex items-center gap-2">
                            <span>{{ $enemyType['emoji'] }}</span>
                            <span>{{ $enemy['name'] }}</span>
                            <flux:badge size="sm" class="capitalize">{{ $enemyType['rarity'] }}</flux:badge>
                        </flux:heading>
                        <flux:subheading class="flex justify-between">
                            <span>HP: {{ $enemy['current_hp'] }}/{{ $enemy['max_hp'] }}</span>
                            @php
                                $hpPercent = ($enemy['current_hp'] / $enemy['max_hp']) * 100;
                                $hpColor = $hpPercent > 60 ? 'bg-green-500' : ($hpPercent > 30 ? 'bg-yellow-500' : 'bg-red-500');
                            @endphp
                        </flux:subheading>
                        
                        <!-- HP Bar -->
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="{{ $hpColor }} h-2 rounded-full transition-all duration-300" style="width: {{ $hpPercent }}%"></div>
                        </div>

                        <div class="flex gap-2 mt-2">
                            <flux:button variant="danger" size="sm" wire:click="attack('{{ $enemy['id'] }}')">
                                ⚔️ Attack
                            </flux:button>
                            <flux:button variant="outline" size="sm" wire:click="enemyAttack('{{ $enemy['id'] }}')">
                                💥 Enemy Turn
                            </flux:button>
                        </div>
                    </flux:card>
                @empty
                    <flux:card size="sm" class="border-green-500 bg-green-50">
                        <flux:text class="text-green-600 font-semibold">🎉 All enemies defeated! New enemies incoming...</flux:text>
                    </flux:card>
                @endforelse
            </div>

            <!-- Game Actions -->
            <flux:card size="sm">
                <div class="flex gap-2">
                    <flux:button wire:click="spawnEnemies(1)" variant="outline" size="sm">
                        🎲 Spawn Enemy
                    </flux:button>
                    <flux:button wire:click="findRandomItem" variant="outline" size="sm">
                        🔍 Search for Items
                    </flux:button>
                </div>
            </flux:card>

            <!-- Battle Log -->
            @if(count($log) > 0)
            <flux:card size="sm" class="max-h-96 overflow-y-auto">
                <flux:heading class="font-semibold sticky top-0 bg-white pb-2 border-b">
                    Battle Log (Kills: {{ $kills }})
                </flux:heading>

                <div class="space-y-1 mt-2">
                    @foreach(array_slice(array_reverse($log), 0, 20) as $entry)
                        <flux:text class="text-sm leading-relaxed">
                            {!! $entry !!}
                        </flux:text>
                    @endforeach
                </div>
                
                @if(count($log) > 20)
                    <flux:text class="text-xs text-gray-500 mt-2 italic">
                        ... showing last 20 entries of {{ count($log) }} total
                    </flux:text>
                @endif
            </flux:card>
            @endif
        </div>
    </div>

    <!-- Game Over Modal -->
    <flux:modal name="gameover" :closable="false" :dismissible="false" class="min-w-[22rem] flex flex-col gap-6">
        <div class="text-center">
            <flux:heading size="lg" class="text-red-600">Game Over</flux:heading>
            <flux:text class="text-gray-600 mt-2">
                You have been defeated! Your journey ends here... or does it?
            </flux:text>
            
            @if($kills > 0)
                <flux:text class="mt-4 font-semibold text-blue-600">
                    Final Stats: {{ $kills }} enemies defeated
                </flux:text>
            @endif
        </div>
        
        <div class="flex gap-2">
            <flux:spacer />
            <flux:button type="submit" variant="primary" wire:click="respawnHero" class="px-6">
                ⚡ Respawn Hero
            </flux:button>
        </div>
    </flux:modal>
</section>