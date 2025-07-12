<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;

trait Filterable {
    public $filters = [];

    #[Computed]
    public function getActiveFiltersCountProperty()
    {
        return collect($this->filters)->flatten()->filter()->count();
    }

    public function clearFilters()
    {
        $this->filters = [];
    }

    public function filtersDropdown(): string
    {
        return Blade::render(
            '<x-filters.dropdown :filters="$filters" :config="$config" :activeFiltersCount="$activeFiltersCount" />',
            [
                'filters' => $this->filters,
                'config' => method_exists($this, 'filterConfig') ? $this->filterConfig() : [],
                'activeFiltersCount' => $this->activeFiltersCount,
            ]
        );
    }

    public function activeFilters(): string
    {
        return Blade::render(
            '<x-filters.active :filters="$filters" :config="$config" />',
            [
                'filters' => $this->filters,
                'config' => method_exists($this, 'filterConfig') ? $this->filterConfig() : [],
            ]
        );
    }

    /**
     * Generate the component path based on the class name
     */
    protected function getFilterComponentPath(string $componentName): string
    {
        if (method_exists($this, 'getFilterComponentBasePath')) {
            $basePath = $this->getFilterComponentBasePath();
        } else {
            $fullClassName = static::class;
            $namespaceParts = explode('\\', $fullClassName);
            $relevantParts = array_slice($namespaceParts, 2);
            if (end($relevantParts) === 'Index') {
                array_pop($relevantParts);
            }
            $pathParts = array_map(fn($part) => Str::kebab($part), $relevantParts);
            $basePath = implode('.', $pathParts);
        }
        return "{$basePath}.{$componentName}";
    }

    /**
     * Apply filters to a query builder instance using filterConfig() metadata.
     */
    protected function applyFilters($query)
    {
        $config = method_exists($this, 'filterConfig') ? $this->filterConfig() : [];

        foreach ($config as $key => $meta) {
            if (!isset($this->filters[$key]) || empty($this->filters[$key])) {
                continue;
            }

            $value = $this->filters[$key];
            $column = $meta['column'] ?? $key;

            switch ($meta['type'] ?? 'text') {
                case 'select':
                case 'radio-group':
                    // Exact match filter on specified column
                    $query->where($column, $value);
                    break;

                case 'checkbox':
                    // If multiple values (array), whereIn; else exact match
                    if (is_array($value)) {
                        $query->whereIn($column, $value);
                    } else {
                        $query->where($column, $value);
                    }
                    break;

                case 'input-group':
                    $groupColumn = $meta['column'] ?? null;
                    if (isset($meta['inputs']) && is_array($meta['inputs']) && is_array($value)) {
                        foreach ($meta['inputs'] as $inputKey => $inputMeta) {
                            if (empty($value[$inputKey])) {
                                continue;
                            }

                            $filterValue = $value[$inputKey];
                            $inputType = $inputMeta['type'] ?? 'text';

                            // Use input's own column or fallback to group column or input key
                            $subColumn = $inputMeta['column'] ?? $groupColumn ?? $inputKey;

                            if ($inputType === 'date') {
                                if (Str::contains($inputKey, ['start', 'from'])) {
                                    $query->whereDate($subColumn, '>=', $filterValue);
                                } elseif (Str::contains($inputKey, ['end', 'to'])) {
                                    $query->whereDate($subColumn, '<=', $filterValue);
                                } else {
                                    $query->whereDate($subColumn, $filterValue);
                                }
                            } else {
                                $query->where($subColumn, $filterValue);
                            }
                        }
                    }
                    break;

                case 'switch':
                    // Boolean switch filter
                    $query->where($column, $value ? 1 : 0);
                    break;

                case 'date':
                    // Single date exact match
                    $query->whereDate($column, $value);
                    break;

                default:
                    // Default to "like" search if string
                    if (is_string($value)) {
                        $query->where($column, 'like', "%{$value}%");
                    }
                    break;
            }
        }

        return $query;
    }

    protected function dateRangeFilter(string $label = 'Date Range', string $column = 'created_at'): array
    {
        return [
            'label' => $label,
            'type' => 'input-group',
            'column' => $column,
            'inputs' => [
                'start_date' => [
                    'placeholder' => 'Start Date',
                    'type' => 'date',
                ],
                'end_date' => [
                    'placeholder' => 'End Date',
                    'type' => 'date',
                ],
            ],
        ];
    }
}
