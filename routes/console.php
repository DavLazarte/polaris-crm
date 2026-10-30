<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('radar:test-ingesta', function () {
    $payload = [
        'titulo' => 'Fondo Regional de Innovación Climática 2026',
        'resumen' => 'Subvenciones para proyectos de adaptación y transición energética en América Latina.',
        'fecha_limite' => '2026-12-15',
        'fecha_public' => '2026-10-25',
        'presupuesto_min' => 50000,
        'presupuesto_max' => 250000,
        'moneda' => 'USD',
        'presup_texto' => 'Hasta USD 250.000',
        'sector_elegible' => ['Gobierno subnacional', 'ONG/Tercer sector'],
        'tipo_benef' => ['ONG/Tercer sector'],
        'ods' => ['ODS 13 - Acción por el clima', 'ODS 7 - Energía asequible y no contaminante'],
        'modalidad' => 'No reembolsable',
        'ambito_geo' => 'Regional',
        'alcance_region' => 'Argentina',
        'alcance_arg' => true,
        'requiere_revision_vigencia' => false,
        'score_conf' => 0.94,
    ];

    $req = Request::create(
        '/api/radar/ingesta',
        'POST',
        [],
        [],
        [],
        [
            'HTTP_X_RADAR_TOKEN' => config('services.radar.token', 'polaris-radar-2026'),
            'CONTENT_TYPE' => 'application/json',
        ],
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );

    $res = app()->handle($req);
    $this->info('Status HTTP: ' . $res->getStatusCode());
    $this->line('Respuesta: ' . $res->getContent());
})->purpose('Simula un envío POST de n8n al endpoint /api/radar/ingesta');
