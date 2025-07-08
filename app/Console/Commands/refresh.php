<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class Refresh extends Command
{
    protected $signature = 'app:refresh-db {--seed : Run database seeding}';
    protected $description = 'Optimize cache and refresh database, optionally with seeding';

    public function handle()
    {
        $this->call('optimize:clear');

        $options = ['--force' => true];

        if ($this->option('seed')) {
            $options['--seed'] = true;
        }

        $this->call('migrate:refresh', $options);

        $this->info('Database and cache refreshed successfully!');

        Process::run('npm run build');
    }
}