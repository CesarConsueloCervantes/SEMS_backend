<?php

namespace App\Models\Archives\ArchivesProssesed;

use Illuminate\Database\Eloquent\Builder;

trait ArchivesProssesedScopes
{
    /**
     * Scope to search processed archives by their original file name.
     *
     * @param Builder $query
     * @param string|null $term
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where('archive_name', 'like', "%{$term}%");
    }

    /**
     * Scope to filter archives uploaded within a specific date range.
     *
     * @param Builder $query
     * @param mixed $startDate
     * @param mixed $endDate
     * @return Builder
     */
    public function scopeCreatedBetween(Builder $query, $startDate, $endDate): Builder
    {
        if (empty($startDate) || empty($endDate)) {
            return $query;
        }

        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Check if a specific hash exists in the database.
     *
     * @param Builder $query
     * @param string|null $hash
     * @return bool
     */
    public function scopeHashExists(Builder $query, ?string $hash): bool
    {
        if (empty($hash)) {
            return false;
        }

        return $query->where('archive_hash', $hash)->exists();
    }

    public function scopeNameExists(Builder $query, ?string $name): bool
    {
        if (empty($name)){
            return false;
        }

        return $query->where('archive_name', $name)->exists();
    }
}