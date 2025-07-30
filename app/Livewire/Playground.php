<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use App\Livewire\BaseComponent;
use App\Livewire\Traits\WithModal;

class Playground extends BaseComponent
{
    use WithModal;

    public array $hero = [
        'max_hp' => 100,
        'current_hp' => 100,
        'armor' => 0,
    ];

    public array $inventory = [];
    public array $enemies = [];
    public array $engrams = [];
    public int $kills = 0;
    public array $log = [];

    // Enhanced enemy types with different categories and abilities
    protected array $enemyTypes = [
        // Basic Enemies (Common spawns)
        'Dreg' => [
            'hp' => 15,
            'min_damage' => 3,
            'max_damage' => 8,
            'armor' => 0,
            'abilities' => [],
            'rarity' => 'common',
            'emoji' => '👹',
        ],
        'Vandal' => [
            'hp' => 25,
            'min_damage' => 5,
            'max_damage' => 12,
            'armor' => 2,
            'abilities' => [],
            'rarity' => 'common',
            'emoji' => '🗡️',
        ],
        'Goblin Scout' => [
            'hp' => 18,
            'min_damage' => 4,
            'max_damage' => 10,
            'armor' => 1,
            'abilities' => ['dodge'],
            'rarity' => 'common',
            'emoji' => '🏃',
        ],

        // Elite Enemies (Uncommon spawns)
        'Captain' => [
            'hp' => 45,
            'min_damage' => 8,
            'max_damage' => 18,
            'armor' => 5,
            'abilities' => ['rally'],
            'rarity' => 'uncommon',
            'emoji' => '⚔️',
        ],
        'Orc Berserker' => [
            'hp' => 60,
            'min_damage' => 12,
            'max_damage' => 25,
            'armor' => 3,
            'abilities' => ['rage', 'cleave'],
            'rarity' => 'uncommon',
            'emoji' => '🪓',
        ],
        'Shadow Assassin' => [
            'hp' => 35,
            'min_damage' => 15,
            'max_damage' => 30,
            'armor' => 1,
            'abilities' => ['stealth', 'critical'],
            'rarity' => 'uncommon',
            'emoji' => '🥷',
        ],
        'Necromancer' => [
            'hp' => 40,
            'min_damage' => 6,
            'max_damage' => 15,
            'armor' => 2,
            'abilities' => ['summon', 'curse'],
            'rarity' => 'uncommon',
            'emoji' => '🧙‍♂️',
        ],

        // Boss Enemies (Rare spawns)
        'Troll Warlord' => [
            'hp' => 120,
            'min_damage' => 20,
            'max_damage' => 35,
            'armor' => 10,
            'abilities' => ['regenerate', 'slam'],
            'rarity' => 'rare',
            'emoji' => '👹',
        ],
        'Dragon Wyrmling' => [
            'hp' => 100,
            'min_damage' => 25,
            'max_damage' => 40,
            'armor' => 8,
            'abilities' => ['fire_breath', 'fly'],
            'rarity' => 'rare',
            'emoji' => '🐉',
        ],
        'Lich King' => [
            'hp' => 150,
            'min_damage' => 18,
            'max_damage' => 30,
            'armor' => 15,
            'abilities' => ['death_magic', 'summon_undead', 'soul_drain'],
            'rarity' => 'rare',
            'emoji' => '💀',
        ],

        // Legendary Enemies (Very rare spawns)
        'Ancient Demon' => [
            'hp' => 200,
            'min_damage' => 30,
            'max_damage' => 50,
            'armor' => 20,
            'abilities' => ['inferno', 'teleport', 'corruption'],
            'rarity' => 'legendary',
            'emoji' => '😈',
        ],
        'Void Stalker' => [
            'hp' => 180,
            'min_damage' => 35,
            'max_damage' => 45,
            'armor' => 12,
            'abilities' => ['void_strike', 'phase', 'mind_control'],
            'rarity' => 'legendary',
            'emoji' => '👁️',
        ],
    ];

    protected array $possibleItems = [
        ['type' => 'Consumable', 'name' => 'Small Health Potion', 'heals' => 20],
        ['type' => 'Consumable', 'name' => 'Large Health Potion', 'heals' => 50],
    ];

    public array $equipped = [
        'armor' => [
            'helmet'    => null,
            'gauntlets' => null,
            'chest'     => null,
            'legs'      => null,
            'boots'     => null,
        ],
        'weapon' => ['name' => 'Sword'], 
    ];

    public function mount(): void
    {
        $this->spawnEnemies();
        $this->inventory[] = [
            'name' => 'Sword',
            'type' => 'Weapon',
            'damage' => 10,
        ];
        $this->updateArmor();
    }

    /**
     * Update hero armor based on inventory armor items.
     */
    protected function updateArmor(): void
    {
        $totalDefense = 0;

        foreach ($this->equipped['armor'] as $slot => $item) {
            if ($item && isset($item['defense'])) {
                $totalDefense += $item['defense'];
            }
        }

        $this->hero['armor'] = $totalDefense;
    }

    public function equipItem(int $index): void
    {
        if (!isset($this->inventory[$index])) {
            return;
        }

        $item = $this->inventory[$index];

        if ($item['type'] === 'Armor' && isset($item['slot'])) {
            $this->equipped['armor'][$item['slot']] = $item;
            $this->log[] = "🛡️ Equipped {$item['name']} on {$item['slot']}.";
            $this->updateArmor();
        } elseif ($item['type'] === 'Weapon') {
            $this->equipped['weapon'] = $item;
            $this->log[] = "🔫 Equipped weapon {$item['name']}.";
            $this->updateWeaponDamage();
        }
    }

    protected function updateWeaponDamage(): void
    {
        if ($this->equipped['weapon']) {
            $this->hero['damage'] = $this->equipped['weapon']['damage'];
        } else {
            $this->hero['damage'] = 0; // or base unarmed damage
        }
    }

    public function getGroupedInventoryProperty(): array
    {
        $grouped = [];

        foreach ($this->inventory as $index => $item) {
            // Generate a unique key for grouping based on relevant properties
            // For example, type + name + slot (for armor)
            $key = $item['type'] . '|' . $item['name'];
            if ($item['type'] === 'Armor' && isset($item['slot'])) {
                $key .= '|' . $item['slot'];
            }

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'item' => $item,
                    'indexes' => [$index], // store all indexes of identical items
                    'count' => 1,
                ];
            } else {
                $grouped[$key]['count']++;
                $grouped[$key]['indexes'][] = $index;
            }
        }

        return $grouped;
    }

    public function getGroupedEngramsProperty(): array
    {
        $grouped = [];

        foreach ($this->engrams as $index => $engram) {
            $key = $engram['rarity'];

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'rarity' => $engram['rarity'],
                    'indexes' => [$index],
                    'count' => 1,
                ];
            } else {
                $grouped[$key]['count']++;
                $grouped[$key]['indexes'][] = $index;
            }
        }

        return $grouped;
    }

    protected function generateReward(string $rarity): array
    {
        $rewards = [
            'Common' => [
                ['name' => 'Rusty Helmet',    'type' => 'Armor', 'defense' => 1,  'slot' => 'helmet'],
                ['name' => 'Worn Gauntlets',  'type' => 'Armor', 'defense' => 1,  'slot' => 'gauntlets'],
                ['name' => 'Torn Chestplate', 'type' => 'Armor', 'defense' => 2,  'slot' => 'chest'],
                ['name' => 'Frayed Leggings', 'type' => 'Armor', 'defense' => 1,  'slot' => 'legs'],
                ['name' => 'Scuffed Boots',   'type' => 'Armor', 'defense' => 1,  'slot' => 'boots'],
                ['name' => 'Broken Blade',    'type' => 'Weapon', 'damage' => 5],
            ],
            'Rare' => [
                ['name' => 'Iron Helmet',      'type' => 'Armor', 'defense' => 3,  'slot' => 'helmet'],
                ['name' => 'Steel Gauntlets',  'type' => 'Armor', 'defense' => 3,  'slot' => 'gauntlets'],
                ['name' => 'Chainmail Chest',  'type' => 'Armor', 'defense' => 5,  'slot' => 'chest'],
                ['name' => 'Reinforced Legs',  'type' => 'Armor', 'defense' => 3,  'slot' => 'legs'],
                ['name' => 'Hardened Boots',   'type' => 'Armor', 'defense' => 3,  'slot' => 'boots'],
                ['name' => 'Pulse Rifle',      'type' => 'Weapon', 'damage' => 15],
            ],
            'Legendary' => [
                ['name' => 'Golden Helmet',     'type' => 'Armor', 'defense' => 7,  'slot' => 'helmet'],
                ['name' => 'Titanium Gauntlets','type' => 'Armor', 'defense' => 7,  'slot' => 'gauntlets'],
                ['name' => 'Dragonhide Chest',  'type' => 'Armor', 'defense' => 10, 'slot' => 'chest'],
                ['name' => 'Phoenix Legs',      'type' => 'Armor', 'defense' => 7,  'slot' => 'legs'],
                ['name' => 'Storm Boots',       'type' => 'Armor', 'defense' => 7,  'slot' => 'boots'],
                ['name' => 'Void Rocket Launcher', 'type' => 'Weapon', 'damage' => 30],
            ],
            'Mythic' => [
                ['name' => 'Starlight Crown',       'type' => 'Armor', 'defense' => 15, 'slot' => 'helmet'],
                ['name' => 'Mythic Gauntlets',      'type' => 'Armor', 'defense' => 15, 'slot' => 'gauntlets'],
                ['name' => 'Celestial Chestplate',  'type' => 'Armor', 'defense' => 20, 'slot' => 'chest'],
                ['name' => 'Astral Leggings',       'type' => 'Armor', 'defense' => 15, 'slot' => 'legs'],
                ['name' => 'Ethereal Boots',        'type' => 'Armor', 'defense' => 15, 'slot' => 'boots'],
                ['name' => 'Mythic Relic Blade',    'type' => 'Weapon', 'damage' => 50],
            ],
        ];

        return collect($rewards[$rarity] ?? [])->random();
    }

    /**
     * 50% chance to find a random item and add to inventory.
     */
    public function findRandomItem(): void
    {
        if (rand(1, 100) <= 50) {
            $item = $this->possibleItems[array_rand($this->possibleItems)];
            $this->inventory[] = $item;
            $this->updateArmor();
            $this->log[] = "Found a {$item['name']}!";
        } else {
            $this->log[] = "Found nothing this time.";
        }
    }

    /**
     * Apply damage to hero factoring in armor.
     */
    public function takeDamage(int $amount): void
    {
        $damage = max(0, $amount - $this->hero['armor']);
        $this->hero['current_hp'] = max(0, $this->hero['current_hp'] - $damage);

        if ($this->hero['current_hp'] <= 0) {
            $this->log[] = "☠️ You have been defeated!";
            $this->showModal('gameover');
        }
    }

    /**
     * Restore hero health to max.
     */
    public function respawnHero(): void
    {
        $this->hero['current_hp'] = $this->hero['max_hp'];
        $this->log[] = "❤️ You respawned with full health.";
        $this->closeModal('gameover');
    }

    /**
     * Enhanced enemy attack with abilities.
     */
    public function enemyAttack(string $enemyId): void
    {
        if (!isset($this->enemies[$enemyId])) {
            return;
        }

        $attacker = $this->enemies[$enemyId];
        $enemyType = $this->enemyTypes[$attacker['name']];
        
        // Check for special ability usage (30% chance)
        $useAbility = rand(1, 100) <= 30 && !empty($enemyType['abilities']);
        
        if ($useAbility) {
            $ability = $enemyType['abilities'][array_rand($enemyType['abilities'])];
            $this->executeEnemyAbility($enemyId, $ability);
        } else {
            // Normal attack
            $damage = rand($enemyType['min_damage'], $enemyType['max_damage']);
            $this->log[] = "{$enemyType['emoji']} {$attacker['name']} attacks you!";

            // 🔢 Total armor from equipped gear
            $totalArmor = collect($this->equipped['armor'])
                ->filter() // remove nulls
                ->sum(fn($item) => $item['defense'] ?? 0);

            // 🎯 10% chance to bypass armor entirely
            $armorBypassed = rand(1, 100) <= 10;

            if ($armorBypassed) {
                $finalDamage = $damage;
                $this->log[] = "💥 You took {$finalDamage} damage (armor bypassed)";
            } else {
                // 📉 Diminishing returns on armor
                $absorptionRatio = 1 - exp(-$totalArmor / 40); // adjust divisor to control curve
                $absorptionRatio = min($absorptionRatio, 0.85); // max 85% absorption
                $damageBlocked = floor($damage * $absorptionRatio);

                $finalDamage = max(0, $damage - $damageBlocked);

                $this->log[] = "💥 You took {$finalDamage} damage (after armor: {$totalArmor})";
            }

            $this->takeDamage($finalDamage);
        }
    }

    /**
     * Execute enemy special abilities.
     */
    protected function executeEnemyAbility(string $enemyId, string $ability): void
    {
        $attacker = $this->enemies[$enemyId];
        $enemyType = $this->enemyTypes[$attacker['name']];

        switch ($ability) {
            case 'dodge':
                $this->log[] = "🏃 {$attacker['name']} dodges and becomes harder to hit!";
                // Could implement dodge chance for next attack
                break;

            case 'rally':
                $this->log[] = "📯 {$attacker['name']} rallies nearby enemies!";
                // Heal all enemies for 10 HP
                foreach ($this->enemies as &$enemy) {
                    $enemy['current_hp'] = min($enemy['max_hp'], $enemy['current_hp'] + 10);
                }
                break;

            case 'rage':
                $damage = rand($enemyType['min_damage'] + 10, $enemyType['max_damage'] + 15);
                $this->log[] = "😡 {$attacker['name']} enters a rage and deals massive damage!";
                $this->takeDamage($damage);
                break;

            case 'cleave':
                $damage = rand($enemyType['min_damage'], $enemyType['max_damage']);
                $this->log[] = "🪓 {$attacker['name']} performs a cleaving attack!";
                $this->takeDamage($damage);
                break;

            case 'stealth':
                $this->log[] = "🥷 {$attacker['name']} vanishes into the shadows...";
                break;

            case 'critical':
                $damage = rand($enemyType['min_damage'], $enemyType['max_damage']) * 2;
                $this->log[] = "🎯 {$attacker['name']} lands a critical strike!";
                $this->takeDamage($damage);
                break;

            case 'summon':
                $this->log[] = "🧙‍♂️ {$attacker['name']} summons a minion!";
                $this->addSpecificEnemy('Dreg');
                break;

            case 'curse':
                $this->log[] = "🌑 {$attacker['name']} curses you! Your next attack will be weaker.";
                // Could implement curse effect
                break;

            case 'regenerate':
                $healAmount = 20;
                $this->enemies[$enemyId]['current_hp'] = min(
                    $this->enemies[$enemyId]['max_hp'], 
                    $this->enemies[$enemyId]['current_hp'] + $healAmount
                );
                $this->log[] = "💚 {$attacker['name']} regenerates {$healAmount} HP!";
                break;

            case 'slam':
                $damage = rand($enemyType['min_damage'] + 5, $enemyType['max_damage'] + 10);
                $this->log[] = "💥 {$attacker['name']} slams the ground, dealing area damage!";
                $this->takeDamage($damage);
                break;

            case 'fire_breath':
                $damage = rand(20, 35);
                $this->log[] = "🔥 {$attacker['name']} breathes fire!";
                $this->takeDamage($damage);
                break;

            case 'fly':
                $this->log[] = "🪶 {$attacker['name']} takes to the air, avoiding your next attack!";
                break;

            case 'death_magic':
                $damage = rand(15, 25);
                $this->log[] = "💀 {$attacker['name']} casts death magic!";
                $this->takeDamage($damage);
                break;

            case 'summon_undead':
                $this->log[] = "☠️ {$attacker['name']} raises the dead!";
                $this->addSpecificEnemy('Vandal');
                break;

            case 'soul_drain':
                $damage = rand(10, 20);
                $healAmount = $damage;
                $this->enemies[$enemyId]['current_hp'] = min(
                    $this->enemies[$enemyId]['max_hp'], 
                    $this->enemies[$enemyId]['current_hp'] + $healAmount
                );
                $this->log[] = "👻 {$attacker['name']} drains your soul for {$damage} damage and heals!";
                $this->takeDamage($damage);
                break;

            case 'inferno':
                $damage = rand(25, 40);
                $this->log[] = "🔥 {$attacker['name']} unleashes an inferno!";
                $this->takeDamage($damage);
                break;

            case 'teleport':
                $this->log[] = "✨ {$attacker['name']} teleports behind you!";
                break;

            case 'corruption':
                $damage = rand(15, 25);
                $this->log[] = "🌑 {$attacker['name']} corrupts your equipment!";
                $this->takeDamage($damage);
                break;

            case 'void_strike':
                $damage = rand(30, 45);
                $this->log[] = "🌌 {$attacker['name']} strikes from the void!";
                $this->takeDamage($damage);
                break;

            case 'phase':
                $this->log[] = "👁️ {$attacker['name']} phases out of reality!";
                break;

            case 'mind_control':
                $this->log[] = "🧠 {$attacker['name']} attempts to control your mind!";
                break;
        }
    }

    /**
     * Use a consumable item by index.
     */
    public function useItem(int $index): void
    {
        $item = $this->inventory[$index] ?? null;
        if (!$item) {
            return;
        }

        if ($item['type'] === 'Consumable') {
            $this->hero['current_hp'] = min(
                $this->hero['max_hp'],
                $this->hero['current_hp'] + $item['heals']
            );

            array_splice($this->inventory, $index, 1);
            $this->updateArmor();

            $this->log[] = "Used {$item['name']} and healed {$item['heals']} HP.";
        }
    }

    /**
     * Spawn a given number of enemies with rarity-based selection.
     */
    public function spawnEnemies(int $count = 3): void
    {
        foreach (range(1, $count) as $_) {
            $this->addRandomEnemy();
        }
    }

    /**
     * Add a random enemy based on rarity weights.
     */
    public function addRandomEnemy(): void
    {
        $roll = rand(1, 100);
        
        // Determine rarity based on roll
        $targetRarity = match (true) {
            $roll <= 1   => 'legendary',  // 1%
            $roll <= 8   => 'rare',       // 7%
            $roll <= 35  => 'uncommon',   // 27%
            default      => 'common',     // 65%
        };

        // Filter enemies by rarity
        $availableEnemies = array_filter($this->enemyTypes, 
            fn($enemy) => $enemy['rarity'] === $targetRarity
        );

        if (empty($availableEnemies)) {
            $availableEnemies = array_filter($this->enemyTypes, 
                fn($enemy) => $enemy['rarity'] === 'common'
            );
        }

        $enemyName = array_rand($availableEnemies);
        $this->addSpecificEnemy($enemyName);
    }

    /**
     * Add a specific enemy type.
     */
    protected function addSpecificEnemy(string $enemyName): void
    {
        if (!isset($this->enemyTypes[$enemyName])) {
            return;
        }

        $enemyType = $this->enemyTypes[$enemyName];
        $id = (string) Str::uuid();

        $this->enemies[$id] = [
            'id' => $id,
            'name' => $enemyName,
            'max_hp' => $enemyType['hp'],
            'current_hp' => $enemyType['hp'],
        ];

        $this->log[] = "⚔️ {$enemyType['emoji']} A wild {$enemyName} has entered the fight!";
    }

    /**
     * Attack an enemy by ID.
     */
    public function attack(string $id): void
    {
        if (!isset($this->enemies[$id])) {
            return;
        }

        $bestWeapon = collect($this->inventory)
            ->where('type', 'Weapon')
            ->sortByDesc('damage')
            ->first();

        $damage = $bestWeapon['damage'] ?? rand(5, 10);
        $enemy = &$this->enemies[$id];
        $enemyType = $this->enemyTypes[$enemy['name']];
        
        // Apply enemy armor if any
        $finalDamage = max(1, $damage - $enemyType['armor']);
        $enemy['current_hp'] -= $finalDamage;

        if ($enemy['current_hp'] <= 0) {
            $this->kills++;
            $drop = $this->maybeDropEngram($enemyType['rarity']);
            $msg = "You defeated a {$enemyType['emoji']} {$enemy['name']} with {$finalDamage} damage!";
            if ($drop) {
                $msg .= " 🎁 You found a {$drop} Engram!";
                $this->engrams[] = [
                    'id' => (string) Str::uuid(),
                    'rarity' => $drop,
                ];
            }
            $this->findRandomItem();
            $this->log[] = $msg;

            unset($this->enemies[$id]);
            $this->addRandomEnemy();
        } else {
            $this->log[] = "You hit a {$enemyType['emoji']} {$enemy['name']} for {$finalDamage} damage. ({$enemy['current_hp']} HP left)";
        }
    }

    /**
     * Enhanced engram drop system based on enemy rarity.
     */
    public function maybeDropEngram(string $enemyRarity = 'common'): ?string
    {
        $baseRoll = rand(1, 100);
        
        // Adjust drop rates based on enemy rarity
        $rarityMultiplier = match ($enemyRarity) {
            'legendary' => 3.0,
            'rare' => 2.0,
            'uncommon' => 1.5,
            'common' => 1.0,
        };

        $adjustedRoll = $baseRoll / $rarityMultiplier;

        return match (true) {
            $adjustedRoll <= 2   => 'Mythic',
            $adjustedRoll <= 8   => 'Legendary',
            $adjustedRoll <= 25  => 'Rare',
            $adjustedRoll <= 60  => 'Common',
            default              => null,
        };
    }

    /**
     * Open an engram by ID, add reward to inventory.
     */
    public function openEngram(string $id): void
    {
        $index = collect($this->engrams)->search(fn($e) => $e['id'] === $id);

        if ($index === false) {
            return;
        }

        $engram = $this->engrams[$index];
        unset($this->engrams[$index]);
        $this->engrams = array_values($this->engrams);

        $reward = $this->generateReward($engram['rarity']);
        $this->inventory[] = $reward;
        $this->updateArmor();

        $this->log[] = "🪄 You opened a {$engram['rarity']} Engram and received: {$reward['name']}";
    }

    public function render()
    {
        return view('livewire.playground');
    }
}