<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class Refresh extends Command
{
    protected $signature = 'app:refresh-db';
    protected $description = 'Optimize cache and refresh database with seeds';

    public function handle()
    {
        $this->call('optimize:clear');

        $this->call('migrate:refresh', ['--seed' => true, '--force' => true]);

        $this->info('Database and cache refreshed successfully!');

        Process::run('npm run build');
    }
}