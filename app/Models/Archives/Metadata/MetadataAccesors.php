<?php

namespace App\Models\Archives\Metadata;

/**
 * @property \Carbon\Carbon $fecha_emision
 * @property \Carbon\Carbon $fecha_certificacion_sat
 */

trait MetadataAccesors 
{
    public function getFechaEmisionToNameDate()
    {
        return $this->fecha_emision
            ? $this->fecha_emision->translatedFormat('d \d\e F \d\e Y')
            : null;
    }

    public function getFechaCertificationSATToNAmeDate()
    {
        return $this->fecha_certificacion_sat
            ? $this->fecha_certificacion_sat->translatedFormat('d \d\e F \d\e Y')
            : null;
    }
}