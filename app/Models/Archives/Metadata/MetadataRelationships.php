<?php

namespace App\Models\Archives\Metadata;

use App\Models\User\User;
use App\Models\Archives\ArchivesProssesed\ArchivesProssesed;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait MetadataRelationships
{
    /**
     * metadata belongs to user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * metadata belongs to archive prossesed.
     */
    public function archiveProcessed(): BelongsTo
    {
        return $this->belongsTo(ArchivesProssesed::class);
    }
}
