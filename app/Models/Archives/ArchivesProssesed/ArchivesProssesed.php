<?php

namespace App\Models\Archives\ArchivesProssesed;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivesProssesed extends Model
{
    use ArchivesProssesedRelationships, ArchivesProssesedAccessors, ArchivesProssesedScopes;
    use HasFactory;

    protected $table = 'archives_processed';

    protected $fillable = [
        'user_id',
        'archive_name',
        'archive_hash',
        'archive_path',
        'archive_size_bytes',
    ];
}
