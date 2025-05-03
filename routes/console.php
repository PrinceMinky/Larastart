<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:refresh', function () {
    $this->call('optimize:clear');
    $this->call('migrate:refresh', ['--seed' => true, '--force' => true]);

    $this->info('Database and cache refreshed successfully!');
})->describe('Optimize cache and refresh database with seed data');