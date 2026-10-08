@extends('layouts.app')
@section('title', __('Polaris Cooperation Group | Consultoría Estratégica Global'))

@push('styles')
<style>
    /* ── MODAL ARTÍCULO EN HOME ──────────────────────────────────── */
    .article-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0, 4, 18, 0.78);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 99999;
        display: flex; align-items: center; justify-content: center;
        padding: 24px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .article-modal-overlay.open {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }
    .article-modal {
        background: white;
        color: #0b1626;
        border-radius: 20px;
        max-width: 780px; width: 100%;
        max-height: 88vh;
        overflow-y: auto;
        padding: 44px 50px;
        position: relative;
        transform: translateY(20px) scale(0.98);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 30px 80px rgba(0,0,0,0.35);
    }
    .article-modal-overlay.open .article-modal {
        transform: translateY(0) scale(1);
    }
    .modal-close {
        position: absolute; top: 24px; right: 24px;
        background: #f1f5f9; border: 1.5px solid #e2e8f0;
        width: 38px; height: 38px; border-radius: 50%;
        cursor: pointer; font-size: 1.1rem; line-height: 1;
        display: flex; align-items: center; justify-content: center;
        color: #0b1626; transition: all 0.25s;
    }
    .modal-close:hover { background: #000412; color: white; border-color: #000412; }
    .modal-cat {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem; font-weight: 800;
        letter-spacing: 0.2em; text-transform: uppercase;
        color: var(--blue); margin-bottom: 12px;
    }
    .modal-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900; font-size: clamp(1.4rem, 2.5vw, 2rem);
        color: #000412; line-height: 1.25;
        margin-bottom: 14px;
    }
    .modal-date {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem; font-weight: 600;
        letter-spacing: 0.1em; color: #94a3b8;
        margin-bottom: 28px; padding-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
    }
    .modal-body {
        font-size: 0.95rem; font-weight: 300;
        color: #334155; line-height: 1.85;
    }
    .modal-body p { margin-bottom: 20px; }
    .modal-body a { color: var(--blue); font-weight: 600; text-decoration: underline; }
    @media (max-width: 680px) {
        .article-modal { padding: 30px 22px; }
    }
</style>
@endpush

@section('content')

<!-- ════════════════════════════════════════════════════════════════
     MAPA DEL CONO SUR — FIJO, FONDO TOTAL DEL SITIO
     Visible en todas las secciones (secciones tienen background rgba)
════════════════════════════════════════════════════════════════ -->
<div id="bg-map" aria-hidden="true">
    <svg id="map-svg" viewBox="0 0 560 1500" fill="none" xmlns="http://www.w3.org/2000/svg">

        <!-- Grid cartográfico -->
        <g stroke="rgba(48,87,190,0.08)" stroke-width="1">
            <line x1="0"   y1="0" x2="0"   y2="1500"/>
            <line x1="70"  y1="0" x2="70"  y2="1500"/>
            <line x1="140" y1="0" x2="140" y2="1500"/>
            <line x1="210" y1="0" x2="210" y2="1500"/>
            <line x1="280" y1="0" x2="280" y2="1500"/>
            <line x1="350" y1="0" x2="350" y2="1500"/>
            <line x1="420" y1="0" x2="420" y2="1500"/>
            <line x1="490" y1="0" x2="490" y2="1500"/>
            <line x1="0" y1="80"  x2="560" y2="80"/>
            <line x1="0" y1="160" x2="560" y2="160"/>
            <line x1="0" y1="240" x2="560" y2="240"/>
            <line x1="0" y1="320" x2="560" y2="320"/>
            <line x1="0" y1="400" x2="560" y2="400"/>
            <line x1="0" y1="480" x2="560" y2="480"/>
            <line x1="0" y1="560" x2="560" y2="560"/>
            <line x1="0" y1="640" x2="560" y2="640"/>
            <line x1="0" y1="720" x2="560" y2="720"/>
            <line x1="0" y1="800" x2="560" y2="800"/>
            <line x1="0" y1="880" x2="560" y2="880"/>
        </g>

        <!-- Etiquetas de latitud -->
        <g font-family="Montserrat" font-size="9" fill="rgba(48,87,190,0.2)" font-weight="700" letter-spacing="1">
            <text x="6" y="76">25°S</text>
            <text x="6" y="156">30°S</text>
            <text x="6" y="236">35°S</text>
            <text x="6" y="316">40°S</text>
            <text x="6" y="396">45°S</text>
            <text x="6" y="476">50°S</text>
            <text x="6" y="556">55°S</text>
        </g>

        <!-- ══ PERFIL CONTINENTAL ══ -->
        <!-- Relleno del cono sur (muy sutil) -->
        <path d="
            M 230,10 C 260,12 310,20 350,30
            L 390,42 C 415,50 430,65 425,85
            L 418,105 C 412,122 415,138 428,150
            L 442,162 C 454,172 460,188 456,205
            L 448,224 C 440,240 438,257 444,273
            L 452,290 C 458,306 458,322 448,336
            L 434,350 C 420,362 412,378 408,396
            L 402,416 C 396,436 386,454 372,466
            L 354,478 C 338,488 326,501 318,517
            L 308,536 C 298,554 284,570 266,580
            L 247,590 C 228,600 212,614 200,632
            L 188,652 C 176,672 164,692 152,710
            L 140,730 C 128,750 115,768 102,784
            L 89,800 C 76,816 63,832 52,849
            L 42,868 C 33,885 25,902 20,920
            L 17,940 C 14,958 13,976 16,993
            L 22,1008 C 30,1022 42,1033 56,1040
            L 72,1047 C 88,1053 104,1056 116,1062
            L 126,1068 C 134,1074 138,1082 136,1092
            L 132,1104 C 127,1115 120,1124 112,1130
            L 103,1135 C 94,1140 86,1142 80,1144
        "
        stroke="rgba(116,172,223,0.45)"
        stroke-width="2.2"
        stroke-linecap="round"
        stroke-linejoin="round"
        fill="rgba(116,172,223,0.04)"
        />

        <!-- Costa OESTE (Andes/Chile) -->
        <path d="
            M 230,10 C 218,20 206,35 195,52
            L 182,74 C 170,96 160,118 150,140
            L 140,164 C 130,188 120,212 112,236
            L 104,262 C 96,288 89,314 82,340
            L 75,368 C 69,394 63,420 57,446
            L 52,472 C 47,496 42,520 38,544
            L 34,568 C 30,592 26,616 23,640
            L 20,664 C 18,686 17,708 18,728
            L 20,748 C 23,766 28,782 36,796
            L 46,808 C 56,818 68,824 80,826
            L 93,826 C 105,824 116,818 122,808
            L 126,796 C 130,784 128,772 124,762
            L 118,750 C 113,740 110,730 110,720
        "
        stroke="rgba(116,172,223,0.35)"
        stroke-width="1.8"
        stroke-linecap="round"
        fill="none"
        />

        <!-- Tierra del Fuego / punta sur -->
        <path d="
            M 20,920 C 24,932 30,944 40,954
            L 52,964 C 64,972 78,978 92,978
            L 106,976 C 118,972 126,964 128,952
            L 130,940 C 131,928 128,918 122,910
        "
        stroke="rgba(116,172,223,0.4)"
        stroke-width="1.8"
        stroke-linecap="round"
        fill="rgba(116,172,223,0.03)"
        />

        <!-- ══ ISLAS MALVINAS ══ -->
        <g opacity="0.75">
            <ellipse cx="340" cy="870" rx="32" ry="19"
                fill="rgba(116,172,223,0.07)"
                stroke="rgba(116,172,223,0.55)"
                stroke-width="1.6"/>
            <ellipse cx="302" cy="880" rx="20" ry="13"
                fill="rgba(116,172,223,0.06)"
                stroke="rgba(116,172,223,0.45)"
                stroke-width="1.4"/>
            <text x="320" y="908"
                font-family="Montserrat" font-size="7.5"
                fill="rgba(116,172,223,0.45)"
                font-weight="700" letter-spacing="1.8"
                text-anchor="middle">{{ __('ISLAS MALVINAS') }}</text>
        </g>

        <!-- ══ ANTÁRTIDA ARGENTINA ══ -->
        <g opacity="0.55">
            <path d="M 0,1260 C 50,1238 115,1224 185,1218 L 270,1214 C 340,1211 415,1213 485,1220 L 555,1228 L 560,1230"
                stroke="rgba(116,172,223,0.45)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
            <path d="M 0,1295 C 65,1272 145,1256 225,1249 L 330,1244 C 410,1241 490,1245 560,1254"
                stroke="rgba(116,172,223,0.28)" stroke-width="2" stroke-linecap="round" fill="none"/>
            <path d="M 0,1326 C 80,1302 175,1286 270,1278 L 390,1274 C 460,1272 520,1277 560,1286"
                stroke="rgba(116,172,223,0.16)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
            <text x="280" y="1310"
                font-family="Montserrat" font-size="9"
                fill="rgba(116,172,223,0.28)"
                font-weight="700" letter-spacing="3.5"
                text-anchor="middle">{{ __('ANTÁRTIDA ARGENTINA') }}</text>
        </g>

        <!-- ══ NODOS DE CIUDADES ══ -->
        <circle cx="390" cy="235" r="5" class="city-dot" fill="#74ACDF"/>
        <circle cx="390" cy="235" r="18" fill="rgba(116,172,223,0.12)" stroke="rgba(116,172,223,0.35)" stroke-width="1"/>
        <text x="412" y="233" font-family="Montserrat" font-size="9" fill="rgba(116,172,223,0.65)" font-weight="700" letter-spacing="0.5">Buenos Aires</text>

        <circle cx="418" cy="242" r="3.5" class="city-dot-sm" fill="rgba(116,172,223,0.8)"/>
        <text x="424" y="240" font-family="Montserrat" font-size="7.5" fill="rgba(116,172,223,0.45)" font-weight="600">Montevideo</text>

        <circle cx="310" cy="196" r="3.5" class="city-dot-sm" fill="rgba(116,172,223,0.7)"/>
        <text x="316" y="194" font-family="Montserrat" font-size="7.5" fill="rgba(116,172,223,0.4)" font-weight="600">Córdoba</text>

        <circle cx="356" cy="216" r="3" class="city-dot-sm" fill="rgba(116,172,223,0.6)"/>

        <circle cx="200" cy="225" r="3" class="city-dot-sm" fill="rgba(116,172,223,0.6)"/>
        <text x="208" y="223" font-family="Montserrat" font-size="7.5" fill="rgba(116,172,223,0.35)" font-weight="600">Mendoza</text>

        <circle cx="198" cy="318" r="2.5" class="city-dot-sm" fill="rgba(116,172,223,0.5)"/>

        <circle cx="163" cy="345" r="2.5" class="city-dot-sm" fill="rgba(116,172,223,0.45)"/>

        <circle cx="148" cy="618" r="2.5" class="city-dot-sm" fill="rgba(116,172,223,0.4)"/>
        <text x="157" y="616" font-family="Montserrat" font-size="7" fill="rgba(116,172,223,0.3)" font-weight="600">Río Gallegos</text>

        <circle cx="158" cy="680" r="2.5" class="city-dot-sm" fill="rgba(116,172,223,0.4)"/>
        <text x="166" y="678" font-family="Montserrat" font-size="7" fill="rgba(116,172,223,0.3)" font-weight="600">Ushuaia</text>

        <g stroke="rgba(116,172,223,0.18)" stroke-width="1.3" stroke-dasharray="5 6">
            <line class="draw-line" x1="390" y1="235" x2="555" y2="60"/>
            <line class="draw-line" x1="390" y1="235" x2="530" y2="130" style="animation-delay:.7s"/>
            <line class="draw-line" x1="390" y1="235" x2="556" y2="210" style="animation-delay:1.4s"/>
        </g>
        <line x1="390" y1="235" x2="418" y2="242" stroke="rgba(116,172,223,0.4)" stroke-width="1" stroke-dasharray="3 4"/>

    </svg>
</div>

<!-- ════════════════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════════════════ -->
<section id="hero">
    <div class="hero-inner">
        <div>
            <div class="hero-label">{{ __('Proyección Global Estratégica') }}</div>

            <h1 class="hero-h1">
                {!! __('El puente<br>entre <span class="sky">territorios</span><br>y el <em>mundo.</em>') !!}
            </h1>

            <p class="hero-p">
                {{ __('Diseñamos, estructuramos e implementamos estrategias de inserción internacional para gobiernos, empresas y organizaciones. Transformamos la complejidad del escenario global en decisiones claras, oportunidades concretas y resultados medibles.') }}
            </p>

            <div class="hero-actions">
                <a href="{{ route('servicios') }}" class="btn-solid">{{ __('Nuestra Metodología') }}</a>
                <a href="{{ route('contacto') }}" class="btn-ghost">{{ __('Iniciar un Proyecto') }}</a>
            </div>
        </div>

        <div class="hero-logo-col">
            <img
                src="{{ asset('assets/vectorpolaris-blanco.png') }}"
                alt="Polaris Cooperation Group"
                class="hero-logo-giant"
            >
        </div>
    </div>

    <div class="hero-wave">
        <svg viewBox="0 0 1440 70" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,70 L0,38 C240,4 480,70 720,44 C960,18 1200,60 1440,30 L1440,70 Z" fill="#000412"/>
        </svg>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════════
     QUIÉNES SOMOS — Con logo negro de fondo (test)
════════════════════════════════════════════════════════════════ -->
<section class="section-navy logo-bg-section">
    <div class="inner">
        <div class="qs-grid">
            <div>
                <div class="sec-label light">{{ __('Quiénes Somos') }}</div>
                <h2 class="sec-h2 white" style="margin-bottom:24px;">
                    {!! __('Proyectamos tu<br><span style="color:var(--sky);">institución al mundo.</span>') !!}
                </h2>
                <p class="sec-p light" style="margin-bottom:16px;">
                    {{ __('Polaris es una consultora boutique que diseña trayectorias de internacionalización a medida para una inserción inteligente y pragmática en el sistema internacional contemporáneo.') }}
                </p>
                <p class="sec-p light" style="margin-bottom:40px;">
                    <strong>{{ __('Nuestro diferencial:') }}</strong> {{ __('Un modelo basado plenamente en el talento humano. Combinamos formación de excelencia con años de experiencia real en la gestión pública y privada para construir capacidades y garantizar resultados.') }}
                </p>
                <a href="{{ route('nosotros') }}" class="btn-link">{!! __('Conocer a la firma →') !!}</a>
            </div>
            <div class="qs-cards">
                <div class="qs-card" style="border-left: 3px solid var(--blue);">
                    <h4>{{ __('Expansión Global') }}</h4>
                    <p>{{ __('Acompañamos a gobiernos, empresas y organizaciones de la sociedad civil a proyectarse estratégicamente a nivel internacional.') }}</p>
                </div>
                <div class="qs-card" style="border-left: 3px solid var(--sky);">
                    <h4>{{ __('Aterrizaje Regional') }}</h4>
                    <p>{{ __('Ejecutamos y gestionamos en todas sus etapas los proyectos de organismos y actores internacionales en Argentina y Sudamérica.') }}</p>
                </div>
                <div class="qs-card" style="border-left: 3px solid rgba(116,172,223,0.4);">
                    <h4>{{ __('Talento Humano') }}</h4>
                    <p>{{ __('Combinamos formación de excelencia con experiencia real en gestión pública y privada para garantizar el éxito de cada iniciativa.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wave: section-navy -> section-white -->
<div class="wave-wrap" style="background: #000412;">
    <svg viewBox="0 0 1440 70" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,70 L0,32 C240,4 480,70 720,42 C960,14 1200,62 1440,28 L1440,70 Z" fill="#ffffff"/>
    </svg>
</div>

<!-- ════════════════════════════════════════════════════════════════
     METODOLOGÍA — Cómo trabajamos
════════════════════════════════════════════════════════════════ -->
<section class="section-white">
    <div class="inner">
        <div style="max-width:640px;">
            <div class="sec-label">{{ __('Nuestra Metodología') }}</div>
            <h2 class="sec-h2 dark">{!! __('Integral, Aplicada<br>y Orientada a Resultados.') !!}</h2>
            <p class="sec-p" style="margin-top:16px;">
                {{ __('Un modelo propio que combina el rigor analítico de las grandes consultoras con la ejecución territorial real. Operamos en América Latina, Europa y mercados estratégicos emergentes.') }}
            </p>
        </div>

        <div class="method-grid">
            <div class="method-card">
                <div class="method-num">01</div>
                <h4>{{ __('Diagnóstico Estratégico Profundo') }}</h4>
                <p>{{ __('Evaluamos capacidades, contexto, oportunidades globales y riesgos. Benchmark internacional + análisis competitivo.') }}</p>
            </div>
            <div class="method-card">
                <div class="method-num">02</div>
                <h4>{{ __('Diseño de Arquitectura Internacional') }}</h4>
                <p>{{ __('Definimos la hoja de ruta: mercados, alianzas, financiamiento, posicionamiento y narrativa global.') }}</p>
            </div>
            <div class="method-card">
                <div class="method-num">03</div>
                <h4>{{ __('Activación Operativa') }}</h4>
                <p>{{ __('Implementamos misiones, agendas, vinculaciones, acceso a fondos, desarrollo de mercados y proyectos concretos.') }}</p>
            </div>
            <div class="method-card">
                <div class="method-num">04</div>
                <h4>{{ __('Acompañamiento y Ajuste Dinámico') }}</h4>
                <p>{{ __('Monitoreamos resultados y adaptamos la estrategia en tiempo real según cambios del entorno global.') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Wave: section-white -> section-off -->
<div class="wave-wrap" style="background: #ffffff;">
    <svg viewBox="0 0 1440 55" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,0 C720,55 1080,0 1440,36 L1440,55 L0,55 Z" fill="#000412"/>
    </svg>
</div>

<!-- ════════════════════════════════════════════════════════════════
     SERVICIOS
════════════════════════════════════════════════════════════════ -->
<section class="section-off">
    <div class="inner">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:52px; padding-bottom:22px; border-bottom:1px solid var(--border);">
            <div>
                <div class="sec-label">{{ __('Áreas de Práctica') }}</div>
                <h2 class="sec-h2 dark" style="margin-top:10px;">{!! __('Soluciones para cada<br>actor global.') !!}</h2>
            </div>
            <a href="{{ route('servicios') }}" style="font-family:Montserrat; font-weight:700; font-size:0.7rem; letter-spacing:0.14em; text-transform:uppercase; text-decoration:none; color:var(--blue); white-space:nowrap; display:flex; align-items:center; gap:8px; transition:gap 0.3s;" onmouseover="this.style.gap='14px'" onmouseout="this.style.gap='8px'">{!! __('Ver todas →') !!}</a>
        </div>

        <div class="services-grid">
            <a href="{{ route('servicios') }}" class="svc-card">
                <div class="svc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/>
                    </svg>
                </div>
                <div class="svc-title">{{ __('Cooperación y Financiamiento') }}</div>
                <div class="svc-desc">{{ __('Conectamos proyectos con recursos de la cooperación internacional. Especialistas en estructuración de financiamiento subnacional.') }}</div>
                <span class="svc-link">{!! __('Ver detalle →') !!}</span>
            </a>

            <a href="{{ route('servicios') }}" class="svc-card">
                <div class="svc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div class="svc-title">{{ __('Inteligencia Estratégica Internacional') }}</div>
                <div class="svc-desc">{{ __('Análisis de mercados, evaluación de riesgos geopolíticos e impacto local para apoyar cada movimiento en evidencia real.') }}</div>
                <span class="svc-link">{!! __('Ver detalle →') !!}</span>
            </a>

            <a href="{{ route('servicios') }}" class="svc-card">
                <div class="svc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
                <div class="svc-title">{{ __('Desarrollo de Negocios y Expansión') }}</div>
                <div class="svc-desc">{{ __('Construimos vínculos estratégicos para el ingreso a nuevos mercados y acompañamiento integral de soft landing recíproco.') }}</div>
                <span class="svc-link">{!! __('Ver detalle →') !!}</span>
            </a>

            <a href="{{ route('servicios') }}" class="svc-card">
                <div class="svc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                </div>
                <div class="svc-title">{{ __('Implementación y Gestión') }}</div>
                <div class="svc-desc">{{ __('Coordinación operativa integral en terreno, gestión de stakeholders y medición de impacto para garantizar resultados reales.') }}</div>
                <span class="svc-link">{!! __('Ver detalle →') !!}</span>
            </a>

            <a href="{{ route('servicios') }}" class="svc-card">
                <div class="svc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                </div>
                <div class="svc-title">{{ __('Capacitación y Formación Ejecutiva') }}</div>
                <div class="svc-desc">{{ __('Formación aplicada en comercio exterior, diplomacia económica y corporativa, e internacionalización de territorios.') }}</div>
                <span class="svc-link">{!! __('Ver detalle →') !!}</span>
            </a>

            <a href="{{ route('servicios') }}" class="svc-card">
                <div class="svc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                </div>
                <div class="svc-title">{{ __('Articulación y Logística Internacional') }}</div>
                <div class="svc-desc">{{ __('Organización de actividades conjuntas con bloques regionales y soporte operativo e institucional en territorio.') }}</div>
                <span class="svc-link">{!! __('Ver detalle →') !!}</span>
            </a>
        </div>

        <!-- PRODUCTOS DESTACADOS -->
        <div class="featured-products">
            <div class="fp-card">
                <span class="fp-badge">{{ __('Próximamente') }}</span>
                <h4>Polaris Connect</h4>
                <p>{{ __('Plataforma de vinculación estratégica y oportunidades.') }}</p>
            </div>
            <div class="fp-card">
                <span class="fp-badge">{{ __('Próximamente') }}</span>
                <h4>Polaris Thinking</h4>
                <p>{{ __('Centro de inteligencia y análisis prospectivo.') }}</p>
            </div>
            <div class="fp-card">
                <span class="fp-badge">{{ __('Próximamente') }}</span>
                <h4>Polaris Comex</h4>
                <p>{{ __('Soluciones avanzadas para comercio internacional.') }}</p>
            </div>
        </div>

    </div>
</section>

<!-- Wave: section-off -> section-white -->
<div class="wave-wrap" style="background: #f7f9fc;">
    <svg viewBox="0 0 1440 55" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,55 C360,0 1080,55 1440,18 L1440,55 L0,55 Z" fill="#ffffff"/>
    </svg>
</div>

<!-- ════════════════════════════════════════════════════════════════
     NOTICIAS / PERSPECTIVAS
════════════════════════════════════════════════════════════════ -->
<section class="section-white">
    <div class="inner">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:52px; padding-bottom:22px; border-bottom:1px solid var(--border);">
            <div>
                <div class="sec-label">{{ __('Perspectivas') }}</div>
                <h2 class="sec-h2 dark" style="margin-top:10px;">{!! __('Análisis e<br>Inteligencia Global.') !!}</h2>
            </div>
            <a href="{{ route('news') }}" style="font-family:Montserrat; font-weight:700; font-size:0.7rem; letter-spacing:0.14em; text-transform:uppercase; text-decoration:none; color:var(--blue); white-space:nowrap; display:flex; align-items:center; gap:8px; transition:gap 0.3s;" onmouseover="this.style.gap='14px'" onmouseout="this.style.gap='8px'">{!! __('Ver todas →') !!}</a>
        </div>

@php
$homeArticlesData = $latestArticles->map(function($a) {
    return [
        'id' => $a->id,
        'slug' => $a->slug,
        'category' => (string) $a->category,
        'title' => (string) $a->title,
        'date' => \Carbon\Carbon::parse($a->published_at)->translatedFormat("j \d\e F, Y"),
        'excerpt' => (string) $a->excerpt,
        'body' => (string) $a->body,
    ];
})->values();
@endphp

        <div class="news-grid">
            @forelse($latestArticles as $article)
                <article class="news-card" onclick="openHomeArticle({{ $article->id }})" style="cursor: pointer;">
                    <div class="news-thumb">
                        @if($article->img)
                            <img src="{{ Storage::url($article->img) }}" alt="{{ $article->title }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.3" stroke-linecap="round">
                                <circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="news-body">
                        <span class="news-cat">{{ $article->category }}</span>
                        <h3 class="news-title">{{ $article->title }}</h3>
                        <p class="news-expt">{{ $article->excerpt }}</p>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; padding-top:12px; border-top:1px solid #f1f5f9;">
                            <span class="news-date" style="margin:0;">{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('j \d\e F, Y') }}</span>
                            <span class="news-read-more" style="font-family:'Montserrat',sans-serif; font-size:0.68rem; font-weight:700; color:var(--blue); display:inline-flex; align-items:center; gap:4px; text-transform:uppercase; letter-spacing:0.06em;">{{ __('Leer más →') }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: var(--muted); padding: 40px 0;">
                    {{ __('No hay perspectivas publicadas actualmente.') }}
                </p>
            @endforelse
        </div>
    </div>
</section>

<!-- ── MODAL ARTÍCULO EN HOME ────────────────────────────────── -->
<div class="article-modal-overlay" id="homeArticleModal" onclick="if(event.target === this) closeHomeModal()" role="dialog" aria-modal="true">
    <div class="article-modal">
        <button class="modal-close" onclick="closeHomeModal()" aria-label="Cerrar">✕</button>
        <div class="modal-cat" id="homeModalCat"></div>
        <div class="modal-title" id="homeModalTitle"></div>
        <div class="modal-date" id="homeModalDate"></div>
        <div class="modal-body" id="homeModalBody"></div>
    </div>
</div>

<!-- Wave: section-white -> section-navy -->
<div class="wave-wrap" style="background: #ffffff;">
    <svg viewBox="0 0 1440 55" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,0 C480,55 960,0 1440,40 L1440,55 L0,55 Z" fill="#000412"/>
    </svg>
</div>

<!-- ════════════════════════════════════════════════════════════════
     CONTACTO CTA
════════════════════════════════════════════════════════════════ -->
<section class="section-navy logo-bg-section">
    <div class="inner">
        <div class="cta-inner">
            <div class="sec-label light" style="justify-content:center; margin-bottom:24px;">{{ __('Iniciemos juntos') }}</div>
            <h2 class="cta-h2">{!! __('¿Listo para expandir<br>sus fronteras?') !!}</h2>
            <p class="cta-p">
                {{ __('Contacte a nuestro equipo de especialistas y diseñemos juntos la arquitectura internacional de su organización o territorio.') }}
            </p>
            <div class="cta-btns">
                <a href="{{ route('contacto') }}" class="btn-white">{{ __('Iniciar una consulta') }}</a>
                <a href="{{ route('servicios') }}" class="btn-ghost">{{ __('Ver nuestros servicios') }}</a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const homeArticlesList = @json($homeArticlesData);

    function openHomeArticle(idOrSlug) {
        if (!idOrSlug) return;
        const a = homeArticlesList.find(item => Number(item.id) === Number(idOrSlug) || String(item.slug) === String(idOrSlug));
        if (!a) return;

        const cat = document.getElementById('homeModalCat');
        const title = document.getElementById('homeModalTitle');
        const date = document.getElementById('homeModalDate');
        const body = document.getElementById('homeModalBody');
        const overlay = document.getElementById('homeArticleModal');

        if (cat) cat.textContent = a.category;
        if (title) title.textContent = a.title;
        if (date) date.textContent = a.date;
        if (body) body.innerHTML = a.body;

        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeHomeModal() {
        const overlay = document.getElementById('homeArticleModal');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeHomeModal();
    });
</script>
@endpush

@endsection
