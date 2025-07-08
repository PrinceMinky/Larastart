<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // allow super admin to have free reign
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Export table contents.
        Builder::macro('toCsv', function ($name = null) {
            $query = $this;

            // Get dynamic values
            $websiteName = Str::slug(config('app.name'), '_'); // Convert website name to safe format
            $modelName = Str::plural(Str::snake(class_basename($query->getModel()))); // Convert model name to plural + snake_case
            $timestamp = now()->format('Y_m_d_His'); // Format timestamp like Laravel migrations

            // Generate dynamic filename
            $fileName = "{$timestamp}_{$websiteName}_{$modelName}_table.csv";

            return response()->streamDownload(function () use ($query) {
                $results = $query->get();

                if ($results->isEmpty()) {
                    echo "No data available";
                    return;
                }

                $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

                $values = $results->map(fn($result) =>
                    implode(',', collect($result->getAttributes())->map(fn($thing) => '"'.str_replace('"', '""', $thing).'"')->toArray())
                );

                $values->prepend($titles);

                echo $values->implode("\n");
            }, $name ?? $fileName, ['Content-Type' => 'text/csv']);
        });
    }
}
