<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAllCache extends Command
{
    protected $signature = 'app:clear';
    protected $description = 'Clear all Laravel caches (event, config, cache, route, view)';

    public function handle(): int
    {
        $this->info('Clearing all caches...');

        $commands = [
            'event:clear' => 'Events',
            'config:clear' => 'Config',
            'cache:clear' => 'Application cache',
            'route:clear' => 'Routes',
            'view:clear' => 'Views',
        ];

        foreach ($commands as $command => $description) {
            $this->call($command);
            $this->line("✓ {$description} cleared");
        }

        $this->info('All caches cleared successfully!');
        
        return Command::SUCCESS;
    }
}