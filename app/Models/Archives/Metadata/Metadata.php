<?php

namespace App\Models\Archives\Metadata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use MetadataAccesors, MetadataRelationships, MetadataScopes;
    use HasFactory;

    protected $table = 'metadata';

    protected $fillable = [
        'uuid',
        'rfc_emisor',
        'nombre_emisor',
        'rfc_receptor',
        'nombre_receptor',
        'pac_certifico',
        'fecha_emision',
        'fecha_certificacion_sat',
        'monto',
        'iva',
        'sub_total',
        'efecto_comprobante',
        'estatus',
        'fecha_cancelacion',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
 