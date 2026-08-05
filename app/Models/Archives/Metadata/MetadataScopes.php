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
                if ($matchMode === 'contains') {
                    $query->where($column, 'LIKE', '%' . $value . '%');
                } else {
                    $query->where($column, $value);
                }
                break;

            case 'monto':
            case 'iva':
            case 'sub_total':
                if ($matchMode === 'between' && is_array($value)) {
                    $min = $value['min'] ?? null;
                    $max = $value['max'] ?? null;

                    if ($min !== null && $max !== null) {
                        $query->whereBetween($column, [$min, $max]);
                    } elseif ($min !== null) {
                        $query->where($column, '>=', $min);
                    } elseif ($max !== null) {
                        $query->where($column, '<=', $max);
                    }
                }
                break;

            case 'rfc_emisor':
            case 'nombre_emisor':
            case 'rfc_receptor':
            case 'nombre_receptor':
            case 'pac_certifico':
            case 'efecto_comprobante':
                if ($matchMode === 'equals') {
                    if (is_array($value) && count($value) > 0) {
                        $query->whereIn($column, $value);
                    } elseif (!is_array($value)) {
                        $query->where($column, $value);
                    }
                } else {
                    $query->where($column, 'LIKE', "%{$value}%");
                }
                break;

            case 'fecha_emision':
            case 'fecha_certificacion_sat':
            case 'fecha_cancelacion':
            case 'created_at':
            case 'updated_at':
                if (is_array($value)) {

                    $start = $value['start'] ?? null;
                    $end   = $value['end'] ?? null;

                    if ($start && $end) {
                        $query->whereBetween($column, [
                            $start . ' 00:00:00',
                            $end . ' 23:59:59',
                        ]);
                    } elseif ($start) {
                        $query->whereDate($column, '>=', $start.' 00:00:00');
                    } elseif ($end) {
                        $query->whereDate($column, '<=', $end.' 23:59:59');
                    }

                } else {
                    $query->whereDate($column, '=', $value);
                }

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