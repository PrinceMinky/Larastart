<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class QueryMacrosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->toCsv();
    }

    public function toCsv()
    {
        Builder::macro('toCsv', function (?string $name = null) {
            /** @var \Illuminate\Database\Eloquent\Builder $query */
            $query = $this;

            // Prepare dynamic filename parts
            $websiteName = Str::slug(config('app.name', 'app'), '_');
            $modelName = Str::plural(Str::snake(class_basename($query->getModel())));
            $timestamp = now()->format('Y_m_d_His');

            $fileName = "{$timestamp}_{$websiteName}_{$modelName}_table.csv";

            return response()->streamDownload(function () use ($query) {
                $results = $query->get();

                if ($results->isEmpty()) {
                    // Use CSV headers to keep CSV format consistent with just one row with a message
                    echo "No data available\n";
                    return;
                }

                // Get headers as CSV row
                $headers = array_keys($results->first()->getAttributes());

                $output = fopen('php://output', 'w');

                // Write header row
                fputcsv($output, $headers);

                // Write each data row escaping values properly
                foreach ($results as $item) {
                    fputcsv($output, $item->getAttributes());
                }

                fclose($output);
            }, $name ?? $fileName, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . ($name ?? $fileName) . '"',
            ]);
        });
    }
}
