<?php

namespace Database\Seeders;

use App\Models\Badword;
use Illuminate\Database\Seeder;

class BadwordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badwords = [
            // Variants of "fuck"
            ['word' => 'fuck', 'replacement' => 'duck'],
            ['word' => 'fucks', 'replacement' => 'ducks'],
            ['word' => 'fucked', 'replacement' => 'ducked'],
            ['word' => 'fucker', 'replacement' => 'ducker'],
            ['word' => 'fuckers', 'replacement' => 'duckers'],
            ['word' => 'fucking', 'replacement' => 'ducking'],
            ['word' => 'motherfucker', 'replacement' => 'motherducker'],
            ['word' => 'motherfuckers', 'replacement' => 'motherduckers'],
            ['word' => 'fuckface', 'replacement' => 'duckface'],
            ['word' => 'fuckhead', 'replacement' => 'duckhead'],
            ['word' => 'fuckhole', 'replacement' => 'duckhole'],
            ['word' => 'clusterfuck', 'replacement' => 'mess'],
            ['word' => 'fuckstick', 'replacement' => 'duckstick'],
            ['word' => 'fuckwad', 'replacement' => 'duckwad'],
            ['word' => 'fuckwit', 'replacement' => 'duckwit'],
            ['word' => 'shitfuck', 'replacement' => 'poopduck'],

            // Other badwords (censored or humorous replacements)
            ['word' => 'shit', 'replacement' => 'poop'],
            ['word' => 'asshole', 'replacement' => 'a hole'],
            ['word' => 'bitch', 'replacement' => 'female dog'],
            ['word' => 'bastard', 'replacement' => 'bar steward'],
            ['word' => 'dick', 'replacement' => 'winky'],
            ['word' => 'piss', 'replacement' => 'pee'],
            ['word' => 'cock', 'replacement' => 'aubergine'],
            ['word' => 'pussy', 'replacement' => 'kitty'],
            ['word' => 'slut', 'replacement' => 'cheeky'],
            ['word' => 'whore', 'replacement' => 'lady'],
            ['word' => 'nigger', 'replacement' => 'trigger'],
            ['word' => 'nigga', 'replacement' => 'trigga'],
            ['word' => 'faggot', 'replacement' => 'gay person'],
            ['word' => 'retard', 'replacement' => 'special person'],
            ['word' => 'cunt', 'replacement' => 'see you next tuesday'],
            ['word' => 'twat', 'replacement' => 'pregnant fish'],
        ];

        foreach ($badwords as $badword) {
            Badword::updateOrCreate(
                ['word' => $badword['word']],
                ['replacement' => $badword['replacement']]
            );
        }
    }
}
