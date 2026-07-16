<?php

namespace App\Repositories\Archives;

use App\Models\Archives\Metadata\Metadata;
use App\Repositories\IndexRepositorie;

/**
 * class MetadataRepositorie
 * 
 * @author Cesar Sergio <cesar.consuelo.cervantes@gmail.com>
 */
class MetadataRepositorie extends IndexRepositorie
{
    public function __construct(Metadata $metadata) {
        $this->model = $metadata;
    }
}