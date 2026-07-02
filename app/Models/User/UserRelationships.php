<?php

namespace App\Models\User;

use App\Models\Archives\ArchivesProssesed\ArchivesProssesed;
use App\Models\Archives\Metadata\Metadata;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait UserRelationships
{
    /**
     * archives prossesed by this user.
     */
    public function archivesProcessed(): HasMany
    {
        return $this->hasMany(ArchivesProssesed::class, 'user_id');
    }

    /**
     * get metadata for the user.
     */
    public function metadata(): HasManyThrough
    {
        return $this->hasManyThrough(
            Metadata::class,
            ArchivesProssesed::class,
            'user_id',               // Foreign key in archives_processed table
            'archive_prossesed_id',  // Foreign key in metadata table
            'id',                    // Local key in users table
            'id'                     // Local key in archives_processed table
        );
    }
}