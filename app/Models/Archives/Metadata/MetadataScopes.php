<?php

namespace App\Models\Archives\Metadata;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait MetadataScopes
{
    public function scopeSearch(Builder $query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('uuid', 'like', "%{$term}%")
                ->orWhere('rfc_emisor', 'like', "%{$term}%")
                ->orWhere('nombre_emisor', 'like', "%{$term}%")
                ->orWhere('rfc_receptor', 'like', "%{$term}%")
                ->orWhere('nombre_receptor', 'like', "%{$term}%")
                ->orWhere('pac_certifico', 'like', "%{$term}%");
        });
    }

    /**
     * Scope filter by column.
     */
    public function scopeFilterByColumn(Builder $query, string $column, $value, $matchMode)
    {
        if ($value === null || $value === '') {
            return;
        }

        switch ($column) {
            case 'estatus':
                if ($value !== 'all') {
                    $query->where('estatus', (bool) $value);
                }
                break;

            case 'uuid':
            case 'rfc_emisor':
            case 'nombre_emisor':
            case 'rfc_receptor':
            case 'nombre_receptor':
            case 'pac_certifico':
            case 'monto':
            case 'iva':
            case 'sub_total':
            case 'efecto_comprobante':
            case 'state':
                if ($matchMode === 'contains') {
                    $query->where($column, 'LIKE', '%' . $value . '%');
                } else {
                    $query->where($column, $value);
                }
                break;

            case 'fecha_emision':
            case 'fecha_certificacion_sat':
            case 'created_at':
            case 'updated_at':
                break;

            default:
                if ($this->hasGetMutator($column)) {
                    return;
                }
                $query->where($column, 'LIKE', '%' . $value . '%');
                break;
        }
    }

    /**
     * Scope to sort by database column.
     */
    public function scopeOrderByColumn(Builder $query, $orderBy, $order)
    {
        switch ($orderBy) {
            case 'fecha_emision_to_name_date':
                $query->orderBy('fecha_emision', $order);
                break;

            case 'fecha_certification_sat_to_name_date':
                $query->orderBy('fecha_certificacion_sat', $order);
                break;

            case 'formatted_created_at':
            case 'formatted_updated_at':
                $orderBy = $orderBy === 'formatted_created_at' ? 'created_at' : 'updated_at';
                $query->orderBy($orderBy, $order);
                break;

            default:
                if ($this->hasGetMutator($orderBy)) {
                    return;
                }
                $query->orderBy($orderBy, $order);
                break;
        }
    }
}