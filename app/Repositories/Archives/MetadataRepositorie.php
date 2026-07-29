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

    public function getFiltersoptions($metadata){
        
        $fields = [
            'rfc_emisor',
            'nombre_emisor',
            'rfc_receptor',
            'nombre_receptor',
            'pac_certifico',
            'efecto_comprobante',
        ];

        $options = [];

        foreach ($fields as $field) {
            $options[$field] = collect($metadata)
                ->pluck($field)
                ->filter()
                ->unique()
                ->sort()
                ->values();
        }

        return [
            'options' => $options,
        ];
    }
}