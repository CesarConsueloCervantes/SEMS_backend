<?php

namespace App\Models\Archives\ArchivesProssesed;
use \Illuminate\Support\Facades\Storage;

/**
 * @property string|null $archive_name
 * @property string|null $archive_hash
 * @property string|null $archive_path
 * @property int|null $archive_size_bytes
 * @property \Carbon\Carbon|null $created_at
 */
trait ArchivesProssesedAccessors
{
    /**
     * Calculate the SHA-256 hash of the physical archive file.
     *
     * @return string|null
     */
    public function calculateArchiveHash(): ?string
    {
        $path = $this->archive_path ?? null;

        if (!$path || !Storage::exists($path)) {
            return null;
        }

        return hash_file('sha256', Storage::path($path));
    }

    /**
     * Get the file extension of the archive name.
     *
     * @return string|null
     */
    public function getArchiveExtensionAttribute(): ?string
    {
        return $this->archive_name ? pathinfo($this->archive_name, PATHINFO_EXTENSION) : null;
    }

    /**
     * Get the base name of the archive without path or extension.
     *
     * @return string|null
     */
    public function getArchiveBaseNameAttribute(): ?string
    {
        return $this->archive_name ? pathinfo($this->archive_name, PATHINFO_FILENAME) : null;
    }

    /**
     * Get the creation date of the archive record in a human-readable format.
     *
     * @return string|null
     */
    public function getFormattedCreatedAtAttribute(): ?string
    {
        return $this->created_at ? $this->created_at->translatedFormat('d \d\e F \d\e Y, h:i A') : null;
    }

    /**
     * Get the size of the archive in a human-readable format (KB, MB, etc.).
     *
     * @return string|null
     */
    public function getFormattedSizeAttribute(): ?string
    {
        if (!isset($this->archive_size_bytes)) {
            return null;
        }

        $bytes = $this->archive_size_bytes;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}