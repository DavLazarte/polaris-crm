<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RadarIngestaController extends Controller
{
    /**
     * Recibe convocatorias procesadas desde n8n (POST /api/radar/ingesta).
     */
    public function store(Request $request): JsonResponse
    {
        // 1. Validar Token de Seguridad
        $expectedToken = config('services.radar.token', 'polaris-radar-2026');
        $providedToken = $request->header('X-Radar-Token')
            ?: $request->bearerToken()
            ?: $request->input('token');

        if (!$providedToken || !hash_equals((string) $expectedToken, (string) $providedToken)) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado. Token de ingesta inválido o ausente.',
            ], 401);
        }

        $payload = $request->json()->all() ?: $request->all();

        if (empty($payload)) {
            return response()->json([
                'success' => false,
                'message' => 'El cuerpo de la petición (JSON) está vacío.',
            ], 422);
        }

        // Soportar tanto 1 objeto JSON individual (como envía n8n hoy) como un array de objetos
        $items = array_is_list($payload) ? $payload : [$payload];

        $created = 0;
        $updated = 0;
        $errorsParseo = 0;
        $savedIds = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            // Caso A: El nodo JS de n8n reportó fallo de parseo de Gemini
            if (!empty($item['error_parseo'])) {
                $conv = Convocatoria::create([
                    'titulo' => '[Error de parseo IA] Revisar texto crudo (' . now()->format('d/m/Y H:i') . ')',
                    'error_parseo' => true,
                    'texto_crudo' => $item['texto_crudo'] ?? json_encode($item, JSON_UNESCAPED_UNICODE),
                    'requiere_revision_vigencia' => true,
                    'is_published' => false,
                ]);
                $errorsParseo++;
                $savedIds[] = $conv->id;
                continue;
            }

            // Caso B: Objeto estructurado de convocatoria
            $titulo = isset($item['titulo']) ? trim((string) $item['titulo']) : null;
            if (empty($titulo)) {
                // Si no tiene título ni marca de error, lo guardamos como pendiente con texto crudo
                $conv = Convocatoria::create([
                    'titulo' => '[Sin título] Revisar registro (' . now()->format('d/m/Y H:i') . ')',
                    'error_parseo' => true,
                    'texto_crudo' => json_encode($item, JSON_UNESCAPED_UNICODE),
                    'requiere_revision_vigencia' => true,
                    'is_published' => false,
                ]);
                $errorsParseo++;
                $savedIds[] = $conv->id;
                continue;
            }

            $fechaLimite = $this->parseDateOrNull($item['fecha_limite'] ?? null);
            $fechaPublic = $this->parseDateOrNull($item['fecha_public'] ?? null);
            $link = isset($item['link']) ? trim((string) $item['link']) : ($item['url'] ?? $item['urlOriginal'] ?? null);
            $requiereRevision = (bool) ($item['requiere_revision_vigencia'] ?? false);

            $data = [
                'titulo' => $titulo,
                'resumen' => $item['resumen'] ?? null,
                'fecha_limite' => $fechaLimite,
                'fecha_public' => $fechaPublic,
                'presupuesto_min' => is_numeric($item['presupuesto_min'] ?? null) ? $item['presupuesto_min'] : null,
                'presupuesto_max' => is_numeric($item['presupuesto_max'] ?? null) ? $item['presupuesto_max'] : null,
                'moneda' => $item['moneda'] ?? null,
                'presup_texto' => $item['presup_texto'] ?? null,
                'sector_elegible' => $this->ensureArray($item['sector_elegible'] ?? []),
                'tipo_benef' => $this->ensureArray($item['tipo_benef'] ?? []),
                'ods' => $this->ensureArray($item['ods'] ?? []),
                'modalidad' => $item['modalidad'] ?? null,
                'ambito_geo' => $item['ambito_geo'] ?? null,
                'alcance_region' => $item['alcance_region'] ?? null,
                'alcance_arg' => (bool) ($item['alcance_arg'] ?? false),
                'requiere_revision_vigencia' => $requiereRevision,
                'score_conf' => is_numeric($item['score_conf'] ?? null) ? $item['score_conf'] : null,
                'error_parseo' => false,
                'organismo' => $item['organismo'] ?? null,
                'link' => $link,
                'fuente' => $item['fuente'] ?? null,
                'requisitos' => $item['requisitos'] ?? null,
            ];

            // Búsqueda de duplicados (primero por link si existe, si no por título + fecha_limite)
            $existing = null;
            if (!empty($link)) {
                $existing = Convocatoria::where('link', $link)->first();
            }
            if (!$existing) {
                $query = Convocatoria::where('titulo', $titulo);
                if ($fechaLimite) {
                    $query->whereDate('fecha_limite', $fechaLimite);
                } else {
                    $query->whereNull('fecha_limite');
                }
                $existing = $query->first();
            }

            if ($existing) {
                $existing->update($data);
                $updated++;
                $savedIds[] = $existing->id;
            } else {
                // Se publica automáticamente salvo que requiera revisión de vigencia
                $data['is_published'] = !$requiereRevision;
                $conv = Convocatoria::create($data);
                $created++;
                $savedIds[] = $conv->id;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Ingesta procesada correctamente.',
            'stats' => [
                'creadas' => $created,
                'actualizadas' => $updated,
                'errores_parseo' => $errorsParseo,
                'ids' => $savedIds,
            ],
        ], 200);
    }

    private function parseDateOrNull(mixed $value): ?string
    {
        if (empty($value) || !is_string($value)) {
            return null;
        }
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    private function ensureArray(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_filter($value, fn ($v) => $v !== null && $v !== ''));
        }
        if (is_string($value) && trim($value) !== '') {
            return [trim($value)];
        }
        return [];
    }
}
