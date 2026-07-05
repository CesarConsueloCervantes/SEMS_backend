<?php

namespace App\Models\Archives\ArchivesProssesed;

use App\Models\User\User;
use App\Models\Archives\Metadata\Metadata;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait ArchivesProssesedRelationships
{
    /**
     * archives_prossesed belongs to user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación uno a muchos: Cada archivo procesado tiene varios registros de metadata.
     */
    public function metadata(): HasMany
    {
        return $this->hasMany(Metadata::class, 'archive_prossesed_id');
    }
}