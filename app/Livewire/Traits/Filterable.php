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

    public function UpdatedFilters()
    {
        $this->resetPage();
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
        $overrides = method_exists($this, 'filterOverrides') ? $this->filterOverrides() : [];

        // Early exit: Skip filtering entirely if all filters are empty/null/blank
        $nonEmpty = collect($this->filters ?? [])->filter(function ($value) {
            if (is_array($value)) {
                return collect($value)->filter(fn($v) => $v !== '' && $v !== null)->isNotEmpty();
            }
            return $value !== '' && $value !== null;
        });

        if ($nonEmpty->isEmpty()) {
            return $query;
        }

        foreach ($config as $key => $meta) {
            if (!isset($this->filters[$key])) {
                continue;
            }

            $value = $this->filters[$key];

            // Skip completely empty values
            if ($value === '' || $value === null || (is_array($value) && count(array_filter($value, fn ($v) => $v !== '' && $v !== null)) === 0)) {
                continue;
            }

            // Use override if defined
            if (array_key_exists($key, $overrides) && is_callable($overrides[$key])) {
                $overrides[$key]($query, $value);
                continue;
            }

            $column = $meta['column'] ?? $key;
            $type = $meta['type'] ?? 'text';

            // Determine if this is a multiple select/radio
            $isMulti = $meta['multiple'] ?? false;
            if (!$isMulti && is_array($value) && in_array($type, ['select', 'radio-group'])) {
                $isMulti = true;
            }

            switch ($type) {
                case 'select':
                case 'radio-group':
                    if ($isMulti && is_array($value) && count($value)) {
                        $query->whereIn($column, $value);
                    } elseif (!$isMulti) {
                        $query->where($column, $value);
                    }
                    break;

                case 'checkbox':
                    if (is_array($value) && count($value)) {
                        $query->whereIn($column, $value);
                    } elseif (!is_array($value)) {
                        $query->where($column, $value);
                    }
                    break;

                case 'input-group':
                    $groupColumn = $meta['column'] ?? null;
                    if (isset($meta['inputs'], $value) && is_array($meta['inputs']) && is_array($value)) {
                        foreach ($meta['inputs'] as $inputKey => $inputMeta) {
                            $inputVal = $value[$inputKey] ?? null;
                            if ($inputVal === '' || $inputVal === null) {
                                continue;
                            }

                            $inputType = $inputMeta['type'] ?? 'text';
                            $subColumn = $inputMeta['column'] ?? $groupColumn ?? $inputKey;

                            if ($inputType === 'date') {
                                if (Str::contains($inputKey, ['start', 'from'])) {
                                    $query->whereDate($subColumn, '>=', $inputVal);
                                } elseif (Str::contains($inputKey, ['end', 'to'])) {
                                    $query->whereDate($subColumn, '<=', $inputVal);
                                } else {
                                    $query->whereDate($subColumn, $inputVal);
                                }
                            } else {
                                $query->where($subColumn, $inputVal);
                            }
                        }
                    }
                    break;

                case 'switch':
                    $query->where($column, $value ? 1 : 0);
                    break;

                case 'date':
                    $query->whereDate($column, $value);
                    break;

                default:
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

    protected function ageRangeFilter(string $label = 'Age Range', string $column = 'date_of_birth'): array
    {
        return [
            'label' => $label,
            'type' => 'input-group',
            'column' => $column,
            'inputs' => [
                'min_age' => [
                    'placeholder' => 'Min',
                    'type' => 'number',
                ],
                'max_age' => [
                    'placeholder' => 'Max',
                    'type' => 'number',
                ],
            ],
        ];
    }

    public function removeFilterItem(string $key, $item)
    {
        if (!isset($this->filters[$key]) || !is_array($this->filters[$key])) {
            return;
        }

        $this->filters[$key] = array_values(array_filter($this->filters[$key], fn($v) => $v != $item));
    }

    public function clearAllFilters()
    {
        $this->filters = [];
        $this->resetPage(); // If using pagination
    }

    public function clearInputGroup($groupKey)
    {
        $filterConfig = $this->filterConfig();
        $config = $filterConfig[$groupKey] ?? [];
        
        if (isset($config['inputs'])) {
            // Clear individual input keys
            foreach (array_keys($config['inputs']) as $inputKey) {
                unset($this->filters[$inputKey]);
            }
            
            // Also clear the nested array if it exists
            unset($this->filters[$groupKey]);
        }
    }
}
