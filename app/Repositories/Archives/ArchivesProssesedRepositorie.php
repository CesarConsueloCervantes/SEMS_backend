<?php

namespace App\Repositories\Archives;

use App\Models\Archives\ArchivesProssesed\ArchivesProssesed;
use App\Repositories\IndexRepositorie;

/**
 * class ArchivesProssesedRepositorie
 * 
 * @author Cesar Sergio <cesar.consuelo.cervantes@gmail.com>
 */
class ArchivesProssesedRepositorie extends IndexRepositorie
{
    public function __construct(ArchivesProssesed $archivesProssesed) {
        $this->model = $archivesProssesed;
    }
}