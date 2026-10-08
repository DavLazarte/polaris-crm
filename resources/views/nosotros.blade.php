@extends('layouts.app')
@section('title', __('Polaris Cooperation Group | Quiénes Somos'))

@section('content')

<style>
    /* ── PAGE-SPECIFIC ───────────────────────────── */
    .page-hero {
        background: linear-gradient(128deg, #000412 0%, #050d2a 55%, #0a1d48 100%);
        min-height: 52vh;
        display: flex; flex-direction: column;
        justify-content: flex-end;
        padding: 160px 60px 80px;
        position: relative; overflow: hidden;
    }
    .page-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(116,172,223,0.15) 1px, transparent 1px);
        background-size: 34px 34px;
        pointer-events: none;
    }
    .page-hero-inner { max-width: 1240px; margin: 0 auto; width: 100%; position: relative; z-index: 2; }
    .page-kicker {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.62rem; font-weight: 800;
        letter-spacing: 0.3em; text-transform: uppercase;
        color: var(--sky); margin-bottom: 28px;
        display: flex; align-items: center; gap: 14px;
    }
    .page-kicker::before { content: ''; width: 36px; height: 1.5px; background: var(--sky); border-radius: 2px; }
    .page-title {
        font-family: 'Montserrat', sans-serif;
        font-size: clamp(2.8rem, 5vw, 5rem);
        font-weight: 900; color: white;
        letter-spacing: -0.04em; line-height: 0.95;
        margin-bottom: 28px; max-width: 700px;
    }
    .page-title span { color: var(--sky); font-style: italic; font-weight: 300; }
    .page-subtitle {
        font-size: 1rem; font-weight: 300; color: rgba(255,255,255,0.5);
        max-width: 540px; line-height: 1.8;
    }

    /* ── DIAGONAL CLIP TRANSITIONS ───────────────── */
    .clip-down {
        clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
        margin-bottom: -4px;
    }
    .clip-up {
        clip-path: polygon(0 6%, 100% 0, 100% 100%, 0 100%);
        margin-top: -4px;
    }

    /* ── BOLD STAT ROW (light section) ───────────── */
    .stat-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2px;
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        margin-top: 60px;
    }
    .stat-block {
        padding: 48px 40px;
        background: white;
        text-align: center;
        border-right: 1px solid var(--border);
        transition: background 0.3s;
    }
    .stat-block:last-child { border-right: none; }
    .stat-block:hover { background: var(--off); }
    .stat-num {
        font-family: 'Montserrat', sans-serif;
        font-size: 3.8rem; font-weight: 900;
        color: var(--navy); letter-spacing: -0.04em;
        line-height: 1;
    }
    .stat-num span { color: var(--blue); }
    .stat-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.68rem; font-weight: 700;
        letter-spacing: 0.18em; text-transform: uppercase;
        color: var(--muted); margin-top: 12px;
    }

    /* ── METHOD STEPS (dark section) ─────────────── */
    .steps-list { margin-top: 64px; display: flex; flex-direction: column; gap: 0; }
    .step-row {
        display: grid;
        grid-template-columns: 80px 1fr;
        gap: 40px;
        padding: 44px 0;
        border-bottom: 1px solid rgba(255,255,255,0.07);
        align-items: start;
        transition: background 0.3s;
        position: relative;
    }
    .step-row::before {
        content: '';
        position: absolute; left: -60px; top: 0; bottom: 0; width: 3px;
        background: linear-gradient(180deg, var(--blue), var(--sky));
        transform: scaleY(0); transform-origin: top;
        transition: transform 0.5s ease;
    }
    .step-row:hover::before { transform: scaleY(1); }
    .step-num {
        font-family: 'Montserrat', sans-serif;
        font-size: 4rem; font-weight: 900;
        color: rgba(48,87,190,0.12);
        line-height: 1; letter-spacing: -0.05em;
        padding-top: 4px;
    }
    .step-content h4 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; font-size: 1.15rem;
        color: white; margin-bottom: 12px; line-height: 1.3;
    }
    .step-content p {
        font-size: 0.95rem; font-weight: 300;
        color: rgba(255,255,255,0.5); line-height: 1.75;
        max-width: 560px;
    }

    /* ── WHY US (light) ───────────────────────────── */
    .why-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: start;
    }
    .why-heading {
        font-family: 'Montserrat', sans-serif;
        font-size: clamp(2.2rem, 3.5vw, 3.2rem);
        font-weight: 900; color: var(--navy);
        letter-spacing: -0.03em; line-height: 1.05;
    }
    .why-heading em { color: var(--blue); font-style: normal; }
    .why-list { display: flex; flex-direction: column; gap: 28px; margin-top: 20px; }
    .why-item {
        display: flex; gap: 20px; align-items: flex-start;
        padding-bottom: 28px;
        border-bottom: 1px solid var(--border);
    }
    .why-item:last-child { border-bottom: none; padding-bottom: 0; }
    .why-icon {
        width: 44px; height: 44px; flex-shrink: 0;
        border-radius: 12px; background: var(--off);
        border: 1.5px solid var(--border);
        display: flex; align-items: center; justify-content: center;
    }
    .why-icon svg { width: 18px; height: 18px; stroke: var(--blue); }
    .why-item h5 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; font-size: 0.9rem;
        color: var(--navy); margin-bottom: 6px;
    }
    .why-item p { font-size: 0.875rem; color: var(--muted); font-weight: 300; line-height: 1.65; }

    .sector-pills { display: flex; flex-direction: column; gap: 16px; }
    .sector-pill {
        padding: 32px 36px;
        border-radius: 16px;
        border: 1.5px solid var(--border);
        background: var(--off);
        transition: all 0.35s;
        cursor: default;
    }
    .sector-pill:hover {
        border-color: var(--blue);
        background: white;
        transform: translateX(8px);
    }
    .sector-pill h4 {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.1em;
        color: var(--navy); margin-bottom: 8px;
    }
    .sector-pill p { font-size: 0.875rem; color: var(--muted); font-weight: 300; line-height: 1.6; }

    @media (max-width: 900px) {
        .page-hero { padding: 140px 24px 60px; }
        .stat-row { grid-template-columns: 1fr; }
        .stat-block { border-right: none; border-bottom: 1px solid var(--border); }
        .steps-list { gap: 0; }
        .why-grid { grid-template-columns: 1fr; gap: 50px; }
    }
</style>

<!-- ── HERO ──────────────────────────────────────────────────── -->
<div class="page-hero clip-down">
    <div class="page-hero-inner">
        <div class="page-kicker fade-up">{{ __('Nuestra Firma') }}</div>
        <h1 class="page-title fade-up">
            {!! __('Estrategia con<br><span>poder de ejecución.</span>') !!}
        </h1>
        <p class="page-subtitle fade-up">
            {{ __('Polaris es una consultora boutique que proyecta tu institución al mundo. Diseñamos trayectorias de internacionalización a medida para una inserción inteligente y pragmática en el sistema internacional contemporáneo.') }}
        </p>
    </div>
</div>

<!-- ── SECCIÓN BLANCA: ESTADÍSTICAS + INTRO ──────────────────── -->
<section class="section-white">
    <div class="inner">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;">
            <div>
                <div class="sec-label fade-up">{{ __('Alcance Global') }}</div>
                <h2 class="sec-h2 dark fade-up" style="font-size: clamp(1.8rem, 2.8vw, 2.4rem);">
                    {{ __('Inteligencia relacional en mercados que importan.') }}
                </h2>
                <p class="sec-p fade-up" style="margin-top: 20px;">
                    {{ __('Operamos en América Latina, Europa y mercados estratégicos emergentes. Nuestra red activa de actores públicos, privados y multilaterales nos permite identificar oportunidades antes que el mercado y activar proyectos con rapidez.') }}
                </p>
                <a href="{{ route('contacto') }}" class="btn-link fade-up" style="margin-top: 36px; display: inline-flex;">{!! __('Iniciar un proyecto →') !!}</a>
            </div>
            <div class="fade-up">
                <div class="stat-row">
                    <div class="stat-block">
                        <div class="stat-num">3<span>+</span></div>
                        <div class="stat-label">{{ __('Regiones activas') }}</div>
                    </div>
                    <div class="stat-block">
                        <div class="stat-num">40<span>+</span></div>
                        <div class="stat-label">{{ __('Actores en red') }}</div>
                    </div>
                    <div class="stat-block">
                        <div class="stat-num">100<span>%</span></div>
                        <div class="stat-label">{{ __('Orientados a resultados') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── SECCIÓN OSCURA: METODOLOGÍA ───────────────────────────── -->
<section class="section-navy clip-up" style="padding-top: 110px;">
    <div class="inner" style="position: relative;">
        <div style="max-width: 640px;">
            <div class="sec-label light fade-up">{{ __('Modelo de Trabajo') }}</div>
            <h2 class="sec-h2 white fade-up">
                {!! __('Cuatro pasos.<br>Un resultado concreto.') !!}
            </h2>
            <p class="sec-p light fade-up" style="margin-top: 16px;">
                {{ __('Un proceso diseñado para eliminar incertidumbre y maximizar el impacto en cada etapa de la internacionalización.') }}
            </p>
        </div>

        <div class="steps-list">
            <div class="step-row fade-up">
                <div class="step-num">01</div>
                <div class="step-content">
                    <h4>{{ __('Diagnóstico Estratégico Profundo') }}</h4>
                    <p>{{ __('Evaluamos capacidades, contexto político-económico, oportunidades globales y riesgos. Benchmark internacional y análisis competitivo de posición en el mercado objetivo.') }}</p>
                </div>
            </div>
            <div class="step-row fade-up">
                <div class="step-num">02</div>
                <div class="step-content">
                    <h4>{{ __('Diseño de Arquitectura Internacional') }}</h4>
                    <p>{{ __('Definimos la hoja de ruta: mercados prioritarios, alianzas estratégicas, fuentes de financiamiento, posicionamiento y narrativa global diferencial.') }}</p>
                </div>
            </div>
            <div class="step-row fade-up">
                <div class="step-num">03</div>
                <div class="step-content">
                    <h4>{{ __('Activación Operativa') }}</h4>
                    <p>{{ __('Implementamos: misiones comerciales, agendas de alto nivel, vinculaciones clave, acceso a fondos internacionales y desarrollo de nuevos mercados.') }}</p>
                </div>
            </div>
            <div class="step-row fade-up">
                <div class="step-num">04</div>
                <div class="step-content">
                    <h4>{{ __('Monitoreo y Ajuste Dinámico') }}</h4>
                    <p>{{ __('Monitoreamos resultados en tiempo real y adaptamos la estrategia según las dinámicas cambiantes del entorno geopolítico y comercial global.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── SECCIÓN BLANCA: POR QUÉ ELEGIRNOS ─────────────────────── -->
<section class="section-white clip-up" style="padding-top: 110px;">
    <div class="inner">
        <div class="why-grid">
            <div>
                <div class="sec-label fade-up">{{ __('Diferencial') }}</div>
                <h2 class="why-heading fade-up">
                    {!! __('Un modelo basado en el<br><em>talento humano.</em>') !!}
                </h2>
                <p class="sec-p fade-up" style="margin-top: 24px;">
                    {{ __('Combinamos formación de excelencia con años de experiencia real en la gestión pública y privada para construir capacidades y garantizar resultados.') }}
                </p>

                <div class="why-list" style="margin-top: 44px;">
                    <div class="why-item fade-up">
                        <div class="why-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <div>
                            <h5>{{ __('Formación de excelencia') }}</h5>
                            <p>{{ __('Profesionales capacitados para abordar la inserción inteligente en el sistema internacional contemporáneo.') }}</p>
                        </div>
                    </div>
                    <div class="why-item fade-up">
                        <div class="why-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <div>
                            <h5>{{ __('Experiencia de gestión real') }}</h5>
                            <p>{{ __('Años de trayectoria liderando proyectos estratégicos en los ámbitos público y privado.') }}</p>
                        </div>
                    </div>
                    <div class="why-item fade-up">
                        <div class="why-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div>
                            <h5>{{ __('Construcción de capacidades') }}</h5>
                            <p>{{ __('No solo diseñamos la estrategia, transferimos las competencias necesarias para sostenerla.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="fade-up" style="font-family: 'Montserrat', sans-serif; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.2em; text-transform: uppercase; color: var(--muted); margin-bottom: 28px;">{{ __('¿Qué hacemos?') }}</h3>
                <div class="sector-pills">
                    <div class="sector-pill fade-up">
                        <h4>{{ __('Expansión Global') }}</h4>
                        <p>{{ __('Acompañamos a gobiernos, empresas y organizaciones de la sociedad civil a proyectarse estratégicamente a nivel internacional de manera soberana y pragmática.') }}</p>
                    </div>
                    <div class="sector-pill fade-up">
                        <h4>{{ __('Aterrizaje Regional') }}</h4>
                        <p>{{ __('Ejecutamos y gestionamos en todas sus etapas los proyectos de organismos y actores internacionales en Argentina y Sudamérica de forma eficiente.') }}</p>
                    </div>
                    <div class="sector-pill fade-up">
                        <h4>{{ __('Éxito Compartido') }}</h4>
                        <p>{{ __('Trabajamos bajo esquemas colaborativos orientados a resultados tangibles y el desarrollo institucional duradero.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA OSCURO ─────────────────────────────────────────────── -->
<section class="section-navy clip-up" style="padding-top: 100px;">
    <div class="inner">
        <div class="cta-inner">
            <div class="sec-label light fade-up" style="justify-content: center;">{{ __('Iniciemos juntos') }}</div>
            <h2 class="cta-h2 fade-up">{!! __('¿Listo para expandir<br>sus fronteras?') !!}</h2>
            <p class="cta-p fade-up">{{ __('Contacte a nuestro equipo de especialistas y diseñemos juntos la arquitectura internacional de su organización.') }}</p>
            <div class="cta-btns fade-up">
                <a href="{{ route('contacto') }}" class="btn-white">{{ __('Iniciar una consulta') }}</a>
                <a href="{{ route('servicios') }}" class="btn-ghost">{{ __('Ver nuestros servicios') }}</a>
            </div>
        </div>
    </div>
</section>

@endsection
