<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait GeneratesUniqueSlug
{
    /**
     * Generate a unique slug based on the given title and scope.
     *
     * @param string $title The title to generate slug from
     * @param Model|null $model The model to check uniqueness against
     * @param string $slugField The field name for the slug (default: 'slug')
     * @param array $scope Additional scope conditions for uniqueness check
     * @param int|null $excludeId ID to exclude from uniqueness check (for updates)
     * @return string The unique slug
     */
    public function generateUniqueSlug(string $title, ?Model $model = null, string $slugField = 'slug', array $scope = [], ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        // If no model is provided, we can't check uniqueness
        if (!$model) {
            return $slug;
        }

        // Build the query to check for existing slugs
        $query = $model->newQuery()->where($slugField, $slug);
        
        // Exclude current record if updating
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        // Add scope conditions
        foreach ($scope as $field => $value) {
            $query->where($field, $value);
        }

        // Keep incrementing until we find a unique slug
        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter++;
            $query = $model->newQuery()->where($slugField, $slug);
            
            // Exclude current record if updating
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            // Re-apply scope conditions
            foreach ($scope as $field => $value) {
                $query->where($field, $value);
            }
        }

        return $slug;
    }
}