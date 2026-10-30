<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Convocatoria extends Model
{
    protected $table = 'convocatorias';

    protected $fillable = [
        'titulo',
        'resumen',
        'fecha_limite',
        'fecha_public',
        'presupuesto_min',
        'presupuesto_max',
        'moneda',
        'presup_texto',
        'sector_elegible',
        'tipo_benef',
        'ods',
        'modalidad',
        'ambito_geo',
        'alcance_region',
        'alcance_arg',
        'requiere_revision_vigencia',
        'score_conf',
        'error_parseo',
        'texto_crudo',
        'organismo',
        'link',
        'fuente',
        'requisitos',
        'is_published',
    ];

    protected $casts = [
        'fecha_limite' => 'date',
        'fecha_public' => 'date',
        'presupuesto_min' => 'decimal:2',
        'presupuesto_max' => 'decimal:2',
        'sector_elegible' => 'array',
        'tipo_benef' => 'array',
        'ods' => 'array',
        'alcance_arg' => 'boolean',
        'requiere_revision_vigencia' => 'boolean',
        'score_conf' => 'decimal:2',
        'error_parseo' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * Calcula el texto y la clase CSS del plazo según fecha_limite.
     */
    public function getPlazoInfoAttribute(): array
    {
        if (!$this->fecha_limite) {
            return [
                'texto' => 'Convocatoria abierta',
                'clase' => 'abierta',
            ];
        }

        $hoy = Carbon::today();
        $limite = Carbon::parse($this->fecha_limite)->startOfDay();
        $dias = (int) $hoy->diffInDays($limite, false);

        if ($dias < 0) {
            return [
                'texto' => 'Cerró el ' . $limite->format('d/m/Y'),
                'clase' => 'urge',
            ];
        }

        if ($dias === 0) {
            return [
                'texto' => 'Cierra hoy',
                'clase' => 'urge',
            ];
        }

        if ($dias <= 10) {
            return [
                'texto' => "Cierra en {$dias} " . ($dias === 1 ? 'día' : 'días'),
                'clase' => 'urge',
            ];
        }

        if ($dias <= 30) {
            return [
                'texto' => "Cierra en {$dias} días",
                'clase' => 'pronto',
            ];
        }

        return [
            'texto' => "Cierra en {$dias} días",
            'clase' => 'amplio',
        ];
    }

    /**
     * Devuelve el monto legible priorizando presup_texto o combinando moneda y rangos.
     */
    public function getMontoFormateadoAttribute(): ?string
    {
        if (!empty($this->presup_texto)) {
            return $this->presup_texto;
        }

        $moneda = $this->moneda ?: 'USD';

        if ($this->presupuesto_min && $this->presupuesto_max) {
            return $moneda . ' ' . number_format((float) $this->presupuesto_min, 0, ',', '.')
                . ' a ' . number_format((float) $this->presupuesto_max, 0, ',', '.');
        }

        if ($this->presupuesto_max) {
            return 'Hasta ' . $moneda . ' ' . number_format((float) $this->presupuesto_max, 0, ',', '.');
        }

        if ($this->presupuesto_min) {
            return 'Desde ' . $moneda . ' ' . number_format((float) $this->presupuesto_min, 0, ',', '.');
        }

        return null;
    }

    /**
     * Clasifica automáticamente el tema principal (clima, ciencia, genero) para los filtros del Radar.
     */
    public function getFiltroTemaAttribute(): string
    {
        $odsText = mb_strtolower(implode(' ', $this->ods ?? []));
        $sectoresText = mb_strtolower(implode(' ', $this->sector_elegible ?? []));
        $fullText = mb_strtolower(($this->titulo ?? '') . ' ' . ($this->resumen ?? '') . ' ' . $odsText);

        if (
            str_contains($odsText, 'ods 5') ||
            str_contains($odsText, 'ods 10') ||
            str_contains($fullText, 'género') ||
            str_contains($fullText, 'genero') ||
            str_contains($fullText, 'mujeres') ||
            str_contains($fullText, 'inclusión')
        ) {
            return 'genero';
        }

        if (
            str_contains($odsText, 'ods 13') ||
            str_contains($odsText, 'ods 7') ||
            str_contains($odsText, 'ods 14') ||
            str_contains($odsText, 'ods 15') ||
            str_contains($fullText, 'clima') ||
            str_contains($fullText, 'climátic') ||
            str_contains($fullText, 'ambient') ||
            str_contains($fullText, 'biodiversidad') ||
            str_contains($fullText, 'energía')
        ) {
            return 'clima';
        }

        if (
            str_contains($odsText, 'ods 9') ||
            str_contains($sectoresText, 'universidades') ||
            str_contains($sectoresText, 'i+d') ||
            str_contains($fullText, 'ciencia') ||
            str_contains($fullText, 'investigación') ||
            str_contains($fullText, 'innovación') ||
            str_contains($fullText, 'tecnolog')
        ) {
            return 'ciencia';
        }

        return 'general';
    }
}
