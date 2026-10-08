@extends('layouts.app')
@section('title', __('Polaris Cooperation Group | Servicios'))

@section('content')

<style>
    /* ── PAGE HERO ───────────────────────────────── */
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
    .clip-down { clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%); margin-bottom: -4px; }
    .clip-up { clip-path: polygon(0 6%, 100% 0, 100% 100%, 0 100%); margin-top: -4px; }

    /* ── SERVICE LIST (editorial, not cards) ─────── */
    .service-list { margin-top: 64px; }
    .service-item {
        display: grid;
        grid-template-columns: 56px 1fr auto;
        gap: 40px;
        padding: 48px 0;
        border-bottom: 1px solid var(--border);
        align-items: start;
        cursor: default;
        transition: all 0.3s;
    }
    .service-item:first-child { border-top: 1px solid var(--border); }
    .service-item:hover .service-num { color: var(--blue); }
    .service-item:hover .service-name { color: var(--blue); }
    .service-num {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.68rem; font-weight: 800;
        letter-spacing: 0.15em; color: var(--muted);
        transition: color 0.3s; padding-top: 6px;
    }
    .service-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; font-size: 1.25rem;
        color: var(--navy); line-height: 1.25;
        margin-bottom: 12px;
        transition: color 0.3s;
    }
    .service-desc {
        font-size: 0.9rem; font-weight: 300;
        color: var(--muted); line-height: 1.7;
        max-width: 600px;
    }
    .service-tag {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.58rem; font-weight: 700;
        letter-spacing: 0.15em; text-transform: uppercase;
        color: var(--blue); padding: 6px 14px;
        border: 1.5px solid rgba(48,87,190,0.2);
        border-radius: 50px;
        white-space: nowrap; margin-top: 4px;
        transition: all 0.3s;
    }
    .service-item:hover .service-tag {
        background: var(--blue); color: white;
    }

    /* ── PRODUCTS ROW (dark section) ─────────────── */
    .products-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: rgba(255,255,255,0.08);
        border-radius: 20px;
        overflow: hidden;
        margin-top: 56px;
    }
    .product-cell {
        background: rgba(0,4,18,0.9);
        padding: 50px 40px;
        text-decoration: none;
        transition: background 0.3s;
        position: relative; overflow: hidden;
    }
    .product-cell::after {
        content: '';
        position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, var(--blue), var(--sky));
        transform: scaleX(0); transform-origin: left;
        transition: transform 0.4s ease;
    }
    .product-cell:hover { background: rgba(48,87,190,0.08); }
    .product-cell:hover::after { transform: scaleX(1); }
    .product-soon {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.58rem; font-weight: 700;
        letter-spacing: 0.2em; text-transform: uppercase;
        color: var(--sky); margin-bottom: 20px; display: block;
    }
    .product-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.5rem; font-weight: 900;
        color: white; margin-bottom: 14px;
        letter-spacing: -0.02em;
    }
    .product-desc {
        font-size: 0.875rem; font-weight: 300;
        color: rgba(255,255,255,0.45); line-height: 1.65;
    }

    @media (max-width: 900px) {
        .page-hero { padding: 140px 24px 60px; }
        .service-item { grid-template-columns: 40px 1fr; }
        .service-tag { display: none; }
        .products-row { grid-template-columns: 1fr; }
    }
</style>

<!-- ── HERO ──────────────────────────────────────────────────── -->
<div class="page-hero clip-down">
    <div class="page-hero-inner">
        <div class="page-kicker fade-up">{{ __('Áreas de Práctica') }}</div>
        <h1 class="page-title fade-up">
            {!! __('Soluciones para<br>cada <span>actor global.</span>') !!}
        </h1>
        <p class="page-subtitle fade-up">
            {{ __('Diseñamos estrategias de internacionalización a medida para gobiernos, empresas y organizaciones. Del análisis a la ejecución.') }}
        </p>
    </div>
</div>

<!-- ── SECCIÓN BLANCA: LISTA DE SERVICIOS ────────────────────── -->
<section class="section-white">
    <div class="inner">
        <div style="max-width: 660px;">
            <div class="sec-label fade-up">{{ __('Especialidades') }}</div>
            <h2 class="sec-h2 dark fade-up">{!! __('Lo que hacemos,<br>con precisión quirúrgica.') !!}</h2>
        </div>

        <div class="service-list">
            <div class="service-item fade-up">
                <div class="service-num">01</div>
                <div>
                    <div class="service-name">{{ __('Cooperación Internacional y Financiamiento') }}</div>
                    <div class="service-desc">
                        {{ __('Conectamos proyectos con los recursos que los hacen posibles bajo un esquema de éxito compartido.') }}
                        <ul style="margin-top: 10px; margin-left: 20px; list-style-type: disc; color: var(--muted); font-size: 0.85rem;">
                            <li>{{ __('Identificación de fondos, convocatorias internacionales y diseño integral de proyectos.') }}</li>
                            <li>{{ __('Gestión de postulaciones y acompañamiento técnico continuo.') }}</li>
                            <li><strong>{{ __('Financiamiento subnacional:') }}</strong> {{ __('Acceso a crédito para gobiernos provinciales a través de proyectos rentables (bankable projects) que no requieren de garantías soberanas.') }}</li>
                        </ul>
                    </div>
                </div>
                <span class="service-tag">{{ __('Público / ONGs') }}</span>
            </div>

            <div class="service-item fade-up">
                <div class="service-num">02</div>
                <div>
                    <div class="service-name">{{ __('Inteligencia Estratégica Internacional') }}</div>
                    <div class="service-desc">
                        {{ __('Decidir en el escenario global exige leerlo con precisión. Analizamos mercados y riesgos para que cada movimiento se apoye en evidencia.') }}
                        <ul style="margin-top: 10px; margin-left: 20px; list-style-type: disc; color: var(--muted); font-size: 0.85rem;">
                            <li>{{ __('Análisis de mercados de destino e identificación de oportunidades globales.') }}</li>
                            <li>{{ __('Evaluación exhaustiva de riesgos geopolíticos e impacto a nivel local.') }}</li>
                            <li>{{ __('Mapeo de actores clave y desarrollo de ecosistemas estratégicos.') }}</li>
                        </ul>
                    </div>
                </div>
                <span class="service-tag">{{ __('Todos') }}</span>
            </div>

            <div class="service-item fade-up">
                <div class="service-num">03</div>
                <div>
                    <div class="service-name">{{ __('Desarrollo de Negocios y Expansión') }}</div>
                    <div class="service-desc">
                        {{ __('Construimos los vínculos que convierten una oportunidad global en una operación concreta en territorio.') }}
                        <ul style="margin-top: 10px; margin-left: 20px; list-style-type: disc; color: var(--muted); font-size: 0.85rem;">
                            <li>{{ __('Apertura de nuevos mercados y diseño de estrategias de ingreso eficaces.') }}</li>
                            <li>{{ __('Búsqueda, evaluación y vinculación con socios estratégicos clave.') }}</li>
                            <li>{{ __('Establecimiento internacional (soft landing) integral y recíproco.') }}</li>
                        </ul>
                    </div>
                </div>
                <span class="service-tag">{{ __('Sector Privado') }}</span>
            </div>

            <div class="service-item fade-up">
                <div class="service-num">04</div>
                <div>
                    <div class="service-name">{{ __('Implementación y Gestión de Proyectos') }}</div>
                    <div class="service-desc">
                        {{ __('El valor de un proyecto se define en su ejecución. Coordinamos la operación para cumplir en tiempo, forma y territorio.') }}
                        <ul style="margin-top: 10px; margin-left: 20px; list-style-type: disc; color: var(--muted); font-size: 0.85rem;">
                            <li>{{ __('Coordinación operativa de todas las etapas y procesos del proyecto.') }}</li>
                            <li>{{ __('Gestión estratégica de stakeholders y articulación de intereses en el terreno.') }}</li>
                            <li>{{ __('Seguimiento de resultados, medición de impacto y elaboración de informes.') }}</li>
                        </ul>
                    </div>
                </div>
                <span class="service-tag">{{ __('Todos') }}</span>
            </div>

            <div class="service-item fade-up">
                <div class="service-num">05</div>
                <div>
                    <div class="service-name">{{ __('Capacitación, Formación y Articulación') }}</div>
                    <div class="service-desc">
                        {{ __('Transferimos la capacidad de operar de forma autónoma y facilitamos el despliegue de iniciativas globales en territorio.') }}
                        <ul style="margin-top: 10px; margin-left: 20px; list-style-type: disc; color: var(--muted); font-size: 0.85rem;">
                            <li>{{ __('Comercio internacional aplicado, desarrollo de exportaciones y diplomacia económica.') }}</li>
                            <li>{{ __('Internacionalización de territorios (posicionamiento de ciudades y provincias).') }}</li>
                            <li><strong>{{ __('Logística internacional:') }}</strong> {{ __('Organización de actividades conjuntas con bloques regionales y soporte operativo e institucional.') }}</li>
                        </ul>
                    </div>
                </div>
                <span class="service-tag">{{ __('Público / Privado') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- ── SECCIÓN OSCURA: PRODUCTOS PROPIOS ─────────────────────── -->
<section class="section-navy clip-up" style="padding-top: 110px;">
    <div class="inner">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: end; margin-bottom: 56px;">
            <div>
                <div class="sec-label light fade-up">{{ __('Innovación Propia') }}</div>
                <h2 class="sec-h2 white fade-up">{!! __('Plataformas<br>en desarrollo.') !!}</h2>
            </div>
            <p class="sec-p light fade-up">
                {{ __('Construimos herramientas propias para potenciar la internacionalización de nuestros clientes con tecnología y datos.') }}
            </p>
        </div>

        <div class="products-row fade-up">
            <a href="#" class="product-cell">
                <span class="product-soon">{{ __('Próximamente') }}</span>
                <div class="product-name">Polaris Connect</div>
                <div class="product-desc">{{ __('Plataforma de vinculación estratégica y acceso a redes internacionales exclusivas de decisores clave.') }}</div>
            </a>
            <a href="#" class="product-cell">
                <span class="product-soon">{{ __('Próximamente') }}</span>
                <div class="product-name">Polaris Thinking</div>
                <div class="product-desc">{{ __('Centro de inteligencia prospectiva, análisis geopolítico y debate sobre tendencias del sistema internacional.') }}</div>
            </a>
            <a href="#" class="product-cell">
                <span class="product-soon">{{ __('Próximamente') }}</span>
                <div class="product-name">Polaris Comex</div>
                <div class="product-desc">{{ __('Herramienta tecnológica para agilizar, sistematizar y optimizar operaciones de comercio exterior.') }}</div>
            </a>
        </div>
    </div>
</section>

<!-- ── SECCIÓN BLANCA: CTA ────────────────────────────────────── -->
<section class="section-white clip-up" style="padding-top: 110px; text-align: center;">
    <div class="inner">
        <div class="sec-label fade-up" style="justify-content: center;">{{ __('¿Empezamos?') }}</div>
        <h2 class="sec-h2 dark fade-up" style="text-align: center; max-width: 640px; margin: 0 auto 24px;">
            {!! __('Cada proyecto comienza<br>con una conversación.') !!}
        </h2>
        <p class="sec-p fade-up" style="text-align: center; margin: 0 auto 44px;">
            {{ __('Cuéntenos su desafío y diseñamos la solución internacional que su organización necesita.') }}
        </p>
        <a href="{{ route('contacto') }}" class="btn-solid fade-up">{{ __('Iniciar una consulta') }}</a>
    </div>
</section>

@endsection
