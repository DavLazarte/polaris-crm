@extends('layouts.app')

@section('title', 'Radar de Convocatorias | Polaris Cooperation Group')

@push('styles')
<style>
    /* ═════════════════════════════════════════════════════════════════
       RADAR DE CONVOCATORIAS (FINANCIAMIENTO INTERNACIONAL)
       ═════════════════════════════════════════════════════════════════ */
    :root {
        --radar-tinta:      #0b1626;
        --radar-azul:       #3057be;
        --radar-sky:        #74acdf;
        --radar-azul-claro: #ebf2fa;
        --radar-borde:      #e2e8f0;
        --radar-gris:       #4a5568;
        --radar-gris-tenue: #718096;
        /* Urgencia del plazo */
        --urge-bg:    #fee2e2;  --urge-tx: #991b1b;
        --pronto-bg:  #fef3c7;  --pronto-tx: #92400e;
        --amplio-bg:  #dcfce7;  --amplio-tx: #166534;
        --abierta-bg: #e0f2fe;  --abierta-tx: #075985;
    }

    .radar-hero {
        background: linear-gradient(135deg, #000412 0%, #050d2a 50%, #0a1d48 100%);
        padding: 150px 30px 70px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .radar-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(116,172,223,0.18) 1px, transparent 1px);
        background-size: 36px 36px;
        pointer-events: none;
    }
    .radar-hero-inner {
        max-width: 960px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .radar-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--radar-sky);
        margin-bottom: 14px;
    }
    .radar-title {
        font-family: 'Montserrat', sans-serif;
        font-size: clamp(2.2rem, 4.5vw, 3.4rem);
        font-weight: 900;
        line-height: 1.1;
        letter-spacing: -0.02em;
        margin-bottom: 16px;
    }
    .radar-title span { color: var(--radar-sky); }
    .radar-subtitle {
        font-size: 1.05rem;
        font-weight: 300;
        color: rgba(255, 255, 255, 0.78);
        max-width: 680px;
        line-height: 1.7;
    }

    /* Barra de estado API */
    .api-badge-bar {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(116, 172, 223, 0.25);
        padding: 8px 16px;
        border-radius: 50px;
        margin-top: 24px;
        font-size: 0.75rem;
        color: #e2e8f0;
        backdrop-filter: blur(8px);
    }
    .api-pulse {
        width: 8px; height: 8px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.3); }
    }

    /* Contenedor principal */
    .radar-wrap {
        background: #f8fafc;
        padding: 40px 20px 90px;
        min-height: 70vh;
    }
    .radar-container {
        max-width: 960px;
        margin: 0 auto;
    }

    /* Barra de filtros */
    .radar-filters-bar {
        background: white;
        border: 1px solid var(--radar-borde);
        border-radius: 18px;
        padding: 16px 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        margin-bottom: 28px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .radar-search-row {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .radar-search-input {
        flex: 1;
        padding: 11px 18px;
        border: 1.5px solid var(--radar-borde);
        border-radius: 12px;
        font-size: 0.88rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .radar-search-input:focus {
        border-color: var(--radar-azul);
        box-shadow: 0 0 0 3px rgba(48, 87, 190, 0.12);
    }

    .radar-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }
    .radar-chips-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--radar-gris-tenue);
        margin-right: 4px;
    }
    .chip-btn {
        font-size: 0.8rem;
        padding: 7px 15px;
        border-radius: 100px;
        border: 1.5px solid var(--radar-borde);
        background: white;
        color: var(--radar-gris);
        cursor: pointer;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .chip-btn:hover {
        border-color: var(--radar-azul);
        color: var(--radar-azul);
    }
    .chip-btn.active {
        background: #000412;
        border-color: #000412;
        color: white;
    }

    /* Lista de Convocatorias */
    .convocatorias-lista {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .tarjeta-convocatoria {
        background: white;
        border: 1.5px solid var(--radar-borde);
        border-radius: 16px;
        padding: 24px 26px;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        cursor: pointer;
        position: relative;
    }
    .tarjeta-convocatoria:hover {
        box-shadow: 0 10px 30px rgba(11, 22, 38, 0.07);
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .tarjeta-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 8px;
    }
    .tarjeta-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--radar-tinta);
        line-height: 1.35;
    }
    .badge-argentina {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 6px;
        background: #000412;
        color: #74acdf;
        margin-left: 8px;
        vertical-align: middle;
        white-space: nowrap;
    }

    /* Plazo / Urgencia */
    .badge-plazo {
        flex-shrink: 0;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        padding: 5px 12px;
        border-radius: 100px;
        white-space: nowrap;
    }
    .badge-plazo.urge    { background: var(--urge-bg);    color: var(--urge-tx); }
    .badge-plazo.pronto  { background: var(--pronto-bg);  color: var(--pronto-tx); }
    .badge-plazo.amplio  { background: var(--amplio-bg);  color: var(--amplio-tx); }
    .badge-plazo.abierta { background: var(--abierta-bg); color: var(--abierta-tx); }

    .tarjeta-org {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem;
        color: var(--radar-azul);
        font-weight: 700;
        letter-spacing: 0.03em;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .tarjeta-resumen {
        font-size: 0.92rem;
        color: var(--radar-gris);
        margin-bottom: 18px;
        line-height: 1.65;
        font-weight: 300;
    }

    .tarjeta-pie {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }
    .tag-pill {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 6px;
        background: var(--radar-azul-claro);
        color: #1e3a8a;
    }
    .tag-pill.sector { background: #f1f5f9; color: #334155; }
    .tag-pill.modo   { background: #ecfdf5; color: #065f46; }
    .tag-pill.monto  { background: #fef3c7; color: #92400e; font-weight: 700; }

    .ver-btn {
        margin-left: auto;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--radar-azul);
        text-decoration: none;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.2s;
    }
    .tarjeta-convocatoria:hover .ver-btn { gap: 8px; }

    /* Modal de Detalle (Vanilla JS) */
    .radar-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0, 4, 18, 0.78);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 10000;
        display: flex; align-items: center; justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.25s ease, visibility 0.25s ease;
    }
    .radar-modal-overlay.open {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }
    .radar-modal-card {
        background: white;
        border-radius: 20px;
        max-width: 680px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 60px rgba(0,0,0,0.35);
        padding: 32px 36px;
        position: relative;
        transform: translateY(20px) scale(0.98);
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .radar-modal-overlay.open .radar-modal-card {
        transform: translateY(0) scale(1);
    }
    .radar-modal-close {
        position: absolute; top: 20px; right: 24px;
        background: none; border: none; font-size: 1.4rem;
        color: #94a3b8; cursor: pointer; transition: color 0.2s;
        line-height: 1;
        padding: 4px;
    }
    .radar-modal-close:hover { color: #0f172a; }

    @media (max-width: 680px) {
        .radar-hero { padding: 120px 20px 50px; }
        .tarjeta-top { flex-direction: column; gap: 8px; }
        .badge-plazo { align-self: flex-start; }
        .radar-modal-card { padding: 24px 20px; }
    }
</style>
@endpush

@php
$convocatorias = [
    [
        'id' => 1,
        'titulo' => 'Adaptación climática en América Latina y el Caribe (AFCIA)',
        'argentina' => false,
        'plazoTexto' => 'Cierra en 6 días',
        'plazoClase' => 'urge',
        'organismo' => 'UN CTCN · Fondo de Adaptación',
        'resumen' => 'Asistencia técnica para soluciones innovadoras de adaptación climática. Todos los países de la región son elegibles, con énfasis en soluciones transformadoras y de liderazgo local.',
        'tags' => ['ODS 13'],
        'sector' => 'Universidades / I+D',
        'modo' => 'Asistencia técnica',
        'monto' => 'Hasta USD 250.000',
        'filtroTema' => 'clima',
        'urlOriginal' => 'https://www.ctc-n.org',
        'requisitos' => 'Postulación en consorcio con aval de la entidad nacional designada (NDA). Enfoque en resiliencia hídrica y bioeconomía.'
    ],
    [
        'id' => 2,
        'titulo' => 'I+D+i agroalimentaria — Convocatoria regional 2026',
        'argentina' => false,
        'plazoTexto' => 'Cierra en 22 días',
        'plazoClase' => 'pronto',
        'organismo' => 'FONTAGRO',
        'resumen' => 'Consorcios regionales de investigación, desarrollo e innovación para aumentar la productividad y competitividad con menor huella ambiental en los sistemas agroalimentarios de la región.',
        'tags' => ['ODS 2', 'ODS 9'],
        'sector' => 'Universidades / I+D',
        'modo' => 'Fondo Concursable',
        'monto' => 'Hasta USD 400.000',
        'filtroTema' => 'ciencia',
        'urlOriginal' => 'https://www.fontagro.org',
        'requisitos' => 'Participación mínima de 2 países miembros de FONTAGRO. Co-financiamiento en especies aceptado.'
    ],
    [
        'id' => 3,
        'titulo' => 'Cooperación científica Argentina–Francia (ECOS-Sud)',
        'argentina' => true,
        'plazoTexto' => 'Cierra en 60 días',
        'plazoClase' => 'amplio',
        'organismo' => 'Secretaría de Ciencia y Tecnología · Embajada de Francia',
        'resumen' => 'Proyectos de investigación conjunta entre grupos argentinos y franceses, por dos años. Financia la movilidad de investigadores en formación doctoral y posdoctoral, en todas las áreas del conocimiento.',
        'tags' => ['ODS 9', 'ODS 17'],
        'sector' => 'Universidades / I+D',
        'modo' => 'Cooperación Bilateral',
        'monto' => 'Movilidad & Estadías',
        'filtroTema' => 'ciencia',
        'urlOriginal' => 'https://www.ecos-sud.univ-paris13.fr',
        'requisitos' => 'Equipo de investigación binacional constituido. Presentación simultánea en Argentina y Francia.'
    ],
    [
        'id' => 4,
        'titulo' => 'Pequeñas subvenciones sobre género y ambiente',
        'argentina' => false,
        'plazoTexto' => 'Cierra en 18 días',
        'plazoClase' => 'pronto',
        'organismo' => 'ONU Mujeres',
        'resumen' => 'Organizaciones de la sociedad civil lideradas por o al servicio de mujeres con discapacidad o comunidades vulnerables en territorio. Hasta USD 15.000 por organización, proyectos de hasta siete meses.',
        'tags' => ['ODS 5', 'ODS 13'],
        'sector' => 'ONG / Tercer sector',
        'modo' => 'No reembolsable',
        'monto' => 'USD 15.000',
        'filtroTema' => 'genero',
        'urlOriginal' => 'https://www.unwomen.org',
        'requisitos' => 'Personería jurídica al día y mínimo 2 años de experiencia territorial comprobable.'
    ],
    [
        'id' => 5,
        'titulo' => 'Infraestructura climática y transición ecológica subnacional',
        'argentina' => true,
        'plazoTexto' => 'Convocatoria abierta',
        'plazoClase' => 'abierta',
        'organismo' => 'Programa de cooperación descentralizada UE-América Latina',
        'resumen' => 'Proyectos medianos de energía sostenible, gestión de residuos, saneamiento y agricultura regenerativa. Fondos de US$ 5.000 a 75.000, dirigidos específicamente a gobiernos locales.',
        'tags' => ['ODS 7', 'ODS 11'],
        'sector' => 'Gobierno subnacional',
        'modo' => 'No reembolsable',
        'monto' => 'USD 5.000 a 75.000',
        'filtroTema' => 'clima',
        'urlOriginal' => 'https://ec.europa.eu',
        'requisitos' => 'Municipios o consorcios de municipios con ordenanza de adhesión a metas climáticas.'
    ],
    [
        'id' => 6,
        'titulo' => 'Horizonte Europa: Alianzas Bioeconomía y Economía Circular',
        'argentina' => false,
        'plazoTexto' => 'Cierra en 45 días',
        'plazoClase' => 'amplio',
        'organismo' => 'Comisión Europea (Horizon Europe Cluster 6)',
        'resumen' => 'Financiamiento directo para instituciones de investigación y empresas de Latinoamérica que se integren a consorcios europeos para el desarrollo de biotecnología y valorización de biomasa.',
        'tags' => ['ODS 9', 'ODS 12'],
        'sector' => 'Consorcios Mixtos',
        'modo' => 'No reembolsable',
        'monto' => 'Hasta EUR 1.500.000',
        'filtroTema' => 'ciencia',
        'urlOriginal' => 'https://ec.europa.eu/info/funding-tenders',
        'requisitos' => 'Consorcio internacional con al menos 3 países europeos y socios de terceros países asociados.'
    ]
];
@endphp

@section('content')

<!-- ═════════════════════════════════════════════════════════════════
     HERO DEL RADAR
     ═════════════════════════════════════════════════════════════════ -->
<section class="radar-hero">
    <div class="radar-hero-inner">
        <div class="radar-kicker">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            <span>{{ __('Financiamiento Internacional') }}</span>
        </div>
        <h1 class="radar-title">
            {{ __('Radar de') }} <span>{{ __('Convocatorias.') }}</span>
        </h1>
        <p class="radar-subtitle">
            {{ __('Oportunidades de cooperación, fondos no reembolsables y subsidios multilaterales detectados y actualizados de forma automática por el sistema de inteligencia de Polaris. Filtrá por temática, alcance territorial o modalidad.') }}
        </p>

        <div class="api-badge-bar">
            <span class="api-pulse"></span>
            <span><strong>{{ __('Radar Inteligente Activo') }}</strong> · {{ __('Sincronizado vía API con organismos internacionales') }} · {{ __('Actualización continua') }}</span>
        </div>
    </div>
</section>

<!-- ═════════════════════════════════════════════════════════════════
     CUERPO DEL RADAR & INTERACTIVIDAD
     ═════════════════════════════════════════════════════════════════ -->
<section class="radar-wrap">
    <div class="radar-container">

        <!-- Barra de Búsqueda y Chips de Filtros -->
        <div class="radar-filters-bar">
            <div class="radar-search-row">
                <input type="text" id="radarSearch" placeholder="{{ __('Buscar por organismo, palabra clave o temática...') }}" class="radar-search-input">
            </div>

            <div class="radar-chips">
                <span class="radar-chips-label">{{ __('Filtrar:') }}</span>
                <button type="button" class="chip-btn active" data-filter="todas">{{ __('Todas') }}</button>
                <button type="button" class="chip-btn" data-filter="clima">{{ __('Clima y Ambiente') }}</button>
                <button type="button" class="chip-btn" data-filter="ciencia">{{ __('Ciencia e Innovación') }}</button>
                <button type="button" class="chip-btn" data-filter="genero">{{ __('Género y Sociedad Civil') }}</button>
                <button type="button" class="chip-btn" data-filter="no_reembolsable">{{ __('No Reembolsable') }}</button>
                <button type="button" class="chip-btn" data-filter="argentina">{{ __('Solo Argentina 🇦🇷') }}</button>
            </div>
        </div>

        <!-- Lista de Tarjetas Convocatorias (Renderizadas en Servidor) -->
        <div class="convocatorias-lista" id="convocatoriasLista">
            @foreach($convocatorias as $c)
                @php
                    $isNoReembolsable = str_contains(mb_strtolower($c['modo']), 'no reembolsable');
                    $searchIndex = mb_strtolower($c['titulo'] . ' ' . $c['organismo'] . ' ' . $c['resumen'] . ' ' . implode(' ', $c['tags']) . ' ' . $c['sector']);
                @endphp
                <article class="tarjeta-convocatoria" 
                         data-id="{{ $c['id'] }}" 
                         data-tema="{{ $c['filtroTema'] }}" 
                         data-modo="{{ $isNoReembolsable ? 'no_reembolsable' : 'otro' }}" 
                         data-argentina="{{ $c['argentina'] ? 'true' : 'false' }}"
                         data-search="{{ $searchIndex }}">
                    <div class="tarjeta-top">
                        <h2 class="tarjeta-title">
                            <span>{{ $c['titulo'] }}</span>
                            @if($c['argentina'])
                                <span class="badge-argentina">Argentina</span>
                            @endif
                        </h2>
                        <span class="badge-plazo {{ $c['plazoClase'] }}">{{ $c['plazoTexto'] }}</span>
                    </div>

                    <div class="tarjeta-org">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v4M12 14v4M16 14v4"/></svg>
                        <span>{{ $c['organismo'] }}</span>
                    </div>

                    <p class="tarjeta-resumen">{{ $c['resumen'] }}</p>

                    <div class="tarjeta-pie">
                        @foreach($c['tags'] as $tag)
                            <span class="tag-pill">{{ $tag }}</span>
                        @endforeach
                        <span class="tag-pill sector">{{ $c['sector'] }}</span>
                        <span class="tag-pill modo">{{ $c['modo'] }}</span>
                        @if(!empty($c['monto']))
                            <span class="tag-pill monto">{{ $c['monto'] }}</span>
                        @endif
                        <a href="javascript:void(0)" class="ver-btn">{{ __('Ver detalle →') }}</a>
                    </div>
                </article>
            @endforeach

            <!-- Estado Vacío -->
            <div id="radarEmptyState" style="display: none; text-align: center; padding: 60px 20px; color: var(--radar-gris-tenue);">
                <p style="font-size: 1.1rem; font-weight: 600;">{{ __('No se encontraron convocatorias para el filtro seleccionado.') }}</p>
                <button type="button" id="resetFiltersBtn" class="chip-btn active" style="margin-top: 14px;">{{ __('Restablecer filtros') }}</button>
            </div>
        </div>

    </div>

    <!-- ═════════════════════════════════════════════════════════════
         MODAL DETALLE DE CONVOCATORIA (Nativo Vanilla JS)
         ═════════════════════════════════════════════════════════════ -->
    <div class="radar-modal-overlay" id="radarModal" role="dialog" aria-modal="true">
        <div class="radar-modal-card">
            <button type="button" class="radar-modal-close" id="radarModalClose" aria-label="Cerrar">✕</button>

            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span class="badge-plazo" id="modalPlazo"></span>
                <span class="badge-argentina" id="modalBadgeArg" style="display: none;">Elegible Argentina</span>
            </div>

            <h3 id="modalTitulo" style="font-family:'Montserrat',sans-serif; font-size:1.35rem; font-weight:800; color:var(--radar-tinta); line-height:1.25; margin-bottom:8px;"></h3>
            
            <div id="modalOrganismo" style="font-family:'Montserrat',sans-serif; font-size:0.85rem; font-weight:700; color:var(--radar-azul); margin-bottom:18px;"></div>

            <div id="modalResumen" style="font-size:0.95rem; line-height:1.7; color:#334155; margin-bottom:24px;"></div>

            <!-- Ficha Técnica -->
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:18px 20px; margin-bottom:24px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <div style="font-size:0.7rem; text-transform:uppercase; font-weight:700; color:#64748b;">{{ __('Monto Estimado') }}</div>
                    <div id="modalMonto" style="font-size:0.95rem; font-weight:800; color:#0f172a; margin-top:3px;"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem; text-transform:uppercase; font-weight:700; color:#64748b;">{{ __('Modalidad') }}</div>
                    <div id="modalModo" style="font-size:0.95rem; font-weight:700; color:#0f172a; margin-top:3px;"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem; text-transform:uppercase; font-weight:700; color:#64748b;">{{ __('Público Objetivo') }}</div>
                    <div id="modalSector" style="font-size:0.88rem; font-weight:600; color:#0f172a; margin-top:3px;"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem; text-transform:uppercase; font-weight:700; color:#64748b;">{{ __('Alineación ODS') }}</div>
                    <div id="modalTags" style="font-size:0.88rem; font-weight:600; color:#3057be; margin-top:3px;"></div>
                </div>
            </div>

            <!-- Criterios / Requisitos -->
            <div style="margin-bottom:24px;">
                <h4 style="font-family:'Montserrat',sans-serif; font-size:0.8rem; font-weight:800; text-transform:uppercase; color:#0f172a; margin-bottom:6px;">{{ __('Criterios de Elegibilidad') }}</h4>
                <p id="modalRequisitos" style="font-size:0.88rem; color:#475569; line-height:1.6;"></p>
            </div>

            <!-- Botones de Acción -->
            <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between; padding-top:20px; border-top:1px solid #e2e8f0;">
                <a id="modalUrl" href="#" target="_blank" rel="noopener noreferrer" style="padding:10px 20px; border-radius:50px; background:#f1f5f9; color:#0f172a; font-family:'Montserrat',sans-serif; font-size:0.75rem; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <span>{{ __('Ir a la Fuente Oficial') }}</span>
                    <span>↗</span>
                </a>

                <a href="{{ route('contacto') }}" style="padding:12px 24px; border-radius:50px; background:linear-gradient(135deg, #3057be 0%, #1e3a8a 100%); color:white; font-family:'Montserrat',sans-serif; font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.08em; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 8px 20px rgba(48,87,190,0.3);">
                    <span>{{ __('Estructurar proyecto con Polaris') }}</span>
                    <span>→</span>
                </a>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
    // ── DATOS DE CONVOCATORIAS ────────────────────────────────────
    const convocatoriasData = @json($convocatorias);

    // ── ELEMENTOS DEL MODAL ───────────────────────────────────────
    const modalOverlay    = document.getElementById('radarModal');
    const modalCloseBtn   = document.getElementById('radarModalClose');
    const modalPlazo      = document.getElementById('modalPlazo');
    const modalBadgeArg   = document.getElementById('modalBadgeArg');
    const modalTitulo     = document.getElementById('modalTitulo');
    const modalOrg        = document.getElementById('modalOrganismo');
    const modalResumen    = document.getElementById('modalResumen');
    const modalMonto      = document.getElementById('modalMonto');
    const modalModo       = document.getElementById('modalModo');
    const modalSector     = document.getElementById('modalSector');
    const modalTags       = document.getElementById('modalTags');
    const modalRequisitos = document.getElementById('modalRequisitos');
    const modalUrl        = document.getElementById('modalUrl');

    function openRadarModal(id) {
        const item = convocatoriasData.find(c => c.id === Number(id));
        if (!item) return;

        modalPlazo.textContent = item.plazoTexto;
        modalPlazo.className = 'badge-plazo ' + item.plazoClase;

        if (item.argentina) {
            modalBadgeArg.style.display = 'inline-block';
        } else {
            modalBadgeArg.style.display = 'none';
        }

        modalTitulo.textContent     = item.titulo;
        modalOrg.textContent        = item.organismo;
        modalResumen.textContent    = item.resumen;
        modalMonto.textContent      = item.monto || 'A definir';
        modalModo.textContent       = item.modo;
        modalSector.textContent     = item.sector;
        modalTags.textContent       = item.tags.join(', ');
        modalRequisitos.textContent = item.requisitos;
        modalUrl.href               = item.urlOriginal;

        modalOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeRadarModal() {
        modalOverlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', closeRadarModal);
    }
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) closeRadarModal();
        });
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalOverlay && modalOverlay.classList.contains('open')) {
            closeRadarModal();
        }
    });

    // ── CLICK EN TARJETAS ─────────────────────────────────────────
    document.querySelectorAll('.tarjeta-convocatoria').forEach(card => {
        card.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            openRadarModal(id);
        });
    });

    // ── BUSCADOR Y CHIPS DE FILTRO ────────────────────────────────
    const searchInput = document.getElementById('radarSearch');
    const chipButtons = document.querySelectorAll('.chip-btn');
    const emptyState  = document.getElementById('radarEmptyState');
    const resetBtn    = document.getElementById('resetFiltersBtn');
    let currentFilter = 'todas';

    function filterCards() {
        const term = (searchInput ? searchInput.value : '').trim().toLowerCase();
        const cards = document.querySelectorAll('.tarjeta-convocatoria');
        let visibleCount = 0;

        cards.forEach(card => {
            const tema = card.getAttribute('data-tema');
            const modo = card.getAttribute('data-modo');
            const isArg = card.getAttribute('data-argentina') === 'true';
            const searchIndex = card.getAttribute('data-search') || '';

            // Validación de búsqueda de texto
            const matchesSearch = !term || searchIndex.includes(term);

            // Validación de chip de categoría
            let matchesCategory = false;
            if (currentFilter === 'todas') matchesCategory = true;
            else if (currentFilter === 'clima' && tema === 'clima') matchesCategory = true;
            else if (currentFilter === 'ciencia' && tema === 'ciencia') matchesCategory = true;
            else if (currentFilter === 'genero' && tema === 'genero') matchesCategory = true;
            else if (currentFilter === 'no_reembolsable' && modo === 'no_reembolsable') matchesCategory = true;
            else if (currentFilter === 'argentina' && isArg) matchesCategory = true;

            if (matchesSearch && matchesCategory) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    chipButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            chipButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            filterCards();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', filterCards);
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            currentFilter = 'todas';
            chipButtons.forEach(b => {
                if (b.getAttribute('data-filter') === 'todas') b.classList.add('active');
                else b.classList.remove('active');
            });
            filterCards();
        });
    }
</script>
@endpush

@endsection
