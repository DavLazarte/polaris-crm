@extends('layouts.app')
@section('title', __('Polaris Cooperation Group | Perspectivas'))

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

    /* ── FEATURED ARTICLE ────────────────────────── */
    .article-featured {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        border: 1.5px solid var(--border);
        border-radius: 24px;
        overflow: hidden;
        margin-top: 60px;
        transition: box-shadow 0.3s;
        text-decoration: none;
        cursor: pointer;
    }
    .article-featured:hover { box-shadow: 0 20px 60px rgba(48,87,190,0.12); }
    .article-featured-img {
        background: linear-gradient(135deg, #eaeff9 0%, #c5d5ef 100%);
        min-height: 360px;
        display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden;
    }
    .article-featured-img::after {
        content: '{{ __("DESTACADO") }}';
        position: absolute; top: 24px; left: 24px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.55rem; font-weight: 800;
        letter-spacing: 0.25em;
        color: var(--blue); background: white;
        padding: 6px 14px; border-radius: 50px;
        z-index: 2;
    }
    .article-featured-img svg { opacity: 0.15; }
    .article-featured-img img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .article-featured-body {
        padding: 52px;
        display: flex; flex-direction: column;
        justify-content: center; background: white;
    }
    .article-cat {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem; font-weight: 800;
        letter-spacing: 0.22em; text-transform: uppercase;
        color: var(--blue); margin-bottom: 18px;
    }
    .article-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800; font-size: 1.4rem;
        color: var(--navy); line-height: 1.25;
        margin-bottom: 18px;
    }
    .article-excerpt {
        font-size: 0.9rem; font-weight: 300;
        color: var(--muted); line-height: 1.75;
        margin-bottom: 32px;
    }
    .article-meta {
        display: flex; align-items: center; gap: 16px;
    }
    .article-date {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem; font-weight: 600;
        letter-spacing: 0.1em; color: #94a3b8;
    }
    .read-more {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem; font-weight: 700;
        letter-spacing: 0.14em; text-transform: uppercase;
        color: var(--blue); text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px;
        margin-left: auto;
        transition: gap 0.3s;
    }
    .article-featured:hover .read-more { gap: 12px; }

    /* ── ARTICLE GRID LIST ───────────────────────── */
    .articles-list { margin-top: 28px; display: flex; flex-direction: column; gap: 0; }
    .article-row {
        display: grid;
        grid-template-columns: 200px 1fr auto;
        gap: 36px;
        padding: 36px 0;
        border-bottom: 1px solid var(--border);
        align-items: center;
        text-decoration: none;
        transition: background 0.2s;
    }
    .article-row:first-child { border-top: 1px solid var(--border); }
    .article-row-thumb {
        height: 120px;
        background: linear-gradient(135deg, #eaeff9, #d0ddf4);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .article-row-thumb svg { opacity: 0.2; }
    .article-row-thumb img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .article-row:hover .article-title-sm { color: var(--blue); }
    .article-title-sm {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; font-size: 1rem;
        color: var(--navy); line-height: 1.3;
        margin-bottom: 10px;
        transition: color 0.3s;
    }
    .article-excerpt-sm {
        font-size: 0.85rem; font-weight: 300;
        color: var(--muted); line-height: 1.6;
    }
    .article-row-meta {
        display: flex; flex-direction: column;
        align-items: flex-end; gap: 10px; flex-shrink: 0;
    }

    /* ── NEWSLETTER DARK ─────────────────────────── */
    .newsletter-inner {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 80px; align-items: center;
    }
    .newsletter-form { display: flex; gap: 0; }
    .newsletter-input {
        flex: 1; padding: 18px 24px;
        border: 1.5px solid rgba(255,255,255,0.12);
        border-right: none;
        border-radius: 50px 0 0 50px;
        background: rgba(255,255,255,0.05);
        color: white; font-family: 'Lato', sans-serif;
        font-size: 0.9rem; outline: none;
        transition: border-color 0.3s;
    }
    .newsletter-input::placeholder { color: rgba(255,255,255,0.3); }
    .newsletter-input:focus { border-color: var(--sky); }
    .newsletter-btn {
        padding: 18px 32px;
        background: var(--blue); color: white;
        border: none; cursor: pointer;
        border-radius: 0 50px 50px 0;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem; font-weight: 800;
        letter-spacing: 0.14em; text-transform: uppercase;
        transition: background 0.3s;
        white-space: nowrap;
    }
    .newsletter-btn:hover { background: var(--sky); }

    @media (max-width: 900px) {
        .page-hero { padding: 140px 24px 60px; }
        .article-featured { grid-template-columns: 1fr; }
        .article-featured-img { min-height: 220px; }
        .article-row { grid-template-columns: 1fr; }
        .article-row-thumb { display: none; }
        .article-row-meta { flex-direction: row; align-items: center; }
        .newsletter-inner { grid-template-columns: 1fr; gap: 40px; }
        .newsletter-form { flex-direction: column; }
        .newsletter-input, .newsletter-btn { border-radius: 12px; border-right: 1.5px solid rgba(255,255,255,0.12); }
        .newsletter-input { border-right: 1.5px solid rgba(255,255,255,0.12); }
    }

    /* ── FILTROS ─────────────────────────────────── */
    .filter-btn {
        padding: 8px 18px; border: 1.5px solid var(--border); border-radius: 50px;
        background: transparent; color: var(--muted);
        font-family: 'Montserrat', sans-serif; font-size: 0.6rem; font-weight: 700;
        letter-spacing: 0.12em; text-transform: uppercase; cursor: pointer;
        transition: all 0.3s;
    }
    .filter-btn:hover { border-color: var(--blue); color: var(--blue); }
    .filter-btn.active { background: var(--blue); color: white; border-color: var(--blue); }

    /* ── MODAL ARTÍCULO COMPLETO ─────────────────── */
    .article-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,4,18,0.78);
        backdrop-filter: blur(7px);
        -webkit-backdrop-filter: blur(7px);
        z-index: 10000;
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
        border-radius: 20px;
        max-width: 780px; width: 100%;
        max-height: 88vh;
        overflow-y: auto;
        padding: 52px;
        position: relative;
        transform: translateY(20px);
        transition: transform 0.3s ease;
        box-shadow: 0 30px 80px rgba(0,0,0,0.35);
    }
    .article-modal-overlay.open .article-modal {
        transform: translateY(0);
    }
    .modal-close {
        position: absolute; top: 28px; right: 28px;
        background: var(--off); border: 1.5px solid var(--border);
        width: 38px; height: 38px; border-radius: 50%;
        cursor: pointer; font-size: 1.1rem; line-height: 1;
        display: flex; align-items: center; justify-content: center;
        color: var(--navy); transition: all 0.25s;
    }
    .modal-close:hover { background: var(--navy); color: white; border-color: var(--navy); }
    .modal-cat {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem; font-weight: 800;
        letter-spacing: 0.22em; text-transform: uppercase;
        color: var(--blue); margin-bottom: 12px;
    }
    .modal-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900; font-size: clamp(1.4rem, 2.5vw, 2rem);
        color: var(--navy); line-height: 1.2;
        margin-bottom: 14px;
    }
    .modal-date {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.65rem; font-weight: 600;
        letter-spacing: 0.1em; color: #94a3b8;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border);
    }
    .modal-body {
        font-size: 0.95rem; font-weight: 300;
        color: #334155; line-height: 1.85;
    }
    .modal-body p { margin-bottom: 20px; }
    .modal-body p:last-child { margin-bottom: 0; }
    .modal-cta {
        margin-top: 36px;
        padding: 28px 32px;
        background: #f0f5ff;
        border-radius: 14px;
        border-left: 3px solid var(--blue);
        font-size: 0.88rem; font-weight: 400;
        color: var(--muted); line-height: 1.7;
    }
    .modal-cta a {
        color: var(--blue); font-weight: 600;
        text-decoration: none;
    }
    .modal-cta a:hover { text-decoration: underline; }
    @media (max-width: 600px) {
        .article-modal { padding: 32px 24px; border-radius: 16px; max-height: 92vh; }
        .modal-title { font-size: 1.2rem; }
    }
</style>

<!-- ── HERO ──────────────────────────────────────────────────── -->
<div class="page-hero clip-down">
    <div class="page-hero-inner">
        <div class="page-kicker fade-up">{{ __('Perspectivas Polaris') }}</div>
        <h1 class="page-title fade-up">
            {!! __('Análisis e<br><span>inteligencia global.</span>') !!}
        </h1>
        <p class="page-subtitle fade-up">
            {{ __('Geopolítica, comercio exterior, cooperación internacional y oportunidades de financiamiento: el pulso del sistema internacional desde Buenos Aires.') }}
        </p>
    </div>
</div>

<!-- ── SECCIÓN BLANCA: ARTÍCULO DESTACADO + LISTA ────────────── -->
@php
$allArticles = collect([$featured])->filter()->concat($articles)->map(function($a) {
    return [
        'id' => $a->id,
        'slug' => $a->slug,
        'cat' => (string) $a->category,
        'title' => (string) $a->title,
        'date' => \Carbon\Carbon::parse($a->published_at)->translatedFormat("j F Y"),
        'excerpt' => (string) $a->excerpt,
        'body' => (string) $a->body,
    ];
})->values();
@endphp
<section class="section-white">
    <div class="inner">
        <div class="sec-label fade-up">{{ __('Destacado') }}</div>

        @if($featured)
            @php
                $featuredFilter = in_array($featured->category, ['Comercio Exterior', 'Casos de Éxito']) ? 'comercio' : 'geopolitica';
            @endphp
            <div class="article-featured fade-up" onclick="openArticleModal('{{ $featured->slug }}')" data-article="{{ $featured->slug }}" data-category="{{ $featuredFilter }}" style="cursor: pointer;">
                <div class="article-featured-img">
                    @if($featured->img)
                        <img src="{{ Storage::url($featured->img) }}" alt="{{ $featured->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#3057be" stroke-width="1">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    @endif
                </div>
                <div class="article-featured-body">
                    <div class="article-cat">{{ $featured->category }}</div>
                    <div class="article-title">{{ $featured->title }}</div>
                    <div class="article-excerpt">{{ $featured->excerpt }}</div>
                    <div class="article-meta">
                        <span class="article-date">{{ \Carbon\Carbon::parse($featured->published_at)->translatedFormat('j F Y') }}</span>
                        <span class="read-more">{!! __('Leer análisis →') !!}</span>
                    </div>
                </div>
            </div>
        @endif

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 72px; margin-bottom: 4px;">
            <div class="sec-label" style="margin-bottom: 0;">{{ __('Últimas Publicaciones') }}</div>
            <div style="display: flex; gap: 10px;">
                <button class="filter-btn active" data-filter="all">{{ __('Todos') }}</button>
                <button class="filter-btn" data-filter="geopolitica">{{ __('Geopolítica') }}</button>
                <button class="filter-btn" data-filter="comercio">{{ __('Comercio') }}</button>
            </div>
        </div>

        <div class="articles-list">
            @foreach($articles as $article)
                @php
                    $filterCat = in_array($article->category, ['Comercio Exterior', 'Casos de Éxito']) ? 'comercio' : 'geopolitica';
                @endphp
                <div class="article-row fade-up" onclick="openArticleModal('{{ $article->slug }}')" data-article="{{ $article->slug }}" data-category="{{ $filterCat }}" style="cursor: pointer;">
                    <div class="article-row-thumb">
                        @if($article->img)
                            <img src="{{ Storage::url($article->img) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        @else
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3057be" stroke-width="1.2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <div class="article-cat">{{ $article->category }}</div>
                        <div class="article-title-sm">{{ $article->title }}</div>
                        <div class="article-excerpt-sm">{{ $article->excerpt }}</div>
                    </div>
                    <div class="article-row-meta">
                        <span class="article-date">{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('j F Y') }}</span>
                        <span class="read-more">{!! __('Leer →') !!}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── SECCIÓN OSCURA: NEWSLETTER ─────────────────────────────── -->
<section class="section-navy clip-up" style="padding-top: 110px;">
    <div class="inner">
        <div class="newsletter-inner">
            <div>
                <div class="sec-label light fade-up">{{ __('Suscribirse') }}</div>
                <h2 class="sec-h2 white fade-up">{!! __('El pulso del sistema<br>internacional, en tu inbox.') !!}</h2>
                <p class="sec-p light fade-up" style="margin-top: 20px;">
                    {{ __('Análisis semanales, alertas de oportunidades y reportes de mercados emergentes. Sin ruido: solo lo que importa para expandirse globalmente.') }}
                </p>
            </div>
            <div class="fade-up">
                <div class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="{{ __('su@correo.com') }}">
                    <button class="newsletter-btn">{{ __('Suscribirse') }}</button>
                </div>
                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.25); margin-top: 14px; font-weight: 300;">{{ __('Sin spam. Cancelá cuando quieras.') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- ── MODAL ARTÍCULO COMPLETO ──────────────────────────────── -->
<div class="article-modal-overlay" id="articleModal" onclick="if(event.target === this) closeArticleModal()" role="dialog" aria-modal="true">
    <div class="article-modal">
        <button class="modal-close" onclick="closeArticleModal()" aria-label="Cerrar">✕</button>
        <div class="modal-cat" id="modalCat"></div>
        <div class="modal-title" id="modalTitle"></div>
        <div class="modal-date" id="modalDate"></div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-cta" id="modalCta" style="display: none;"></div>
    </div>
</div>

<script>
    const newsArticlesList = @json($allArticles);

    function openArticleModal(idOrSlug) {
        if (!idOrSlug) return;
        const a = newsArticlesList.find(item => String(item.slug) === String(idOrSlug) || Number(item.id) === Number(idOrSlug));
        if (!a) return;

        const modalCat   = document.getElementById('modalCat');
        const modalTitle = document.getElementById('modalTitle');
        const modalDate  = document.getElementById('modalDate');
        const modalBody  = document.getElementById('modalBody');
        const overlay    = document.getElementById('articleModal');

        if (modalCat)   modalCat.textContent = a.cat;
        if (modalTitle) modalTitle.textContent = a.title;
        if (modalDate)  modalDate.textContent = a.date;
        if (modalBody)  modalBody.innerHTML = a.body;

        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeArticleModal() {
        const overlay = document.getElementById('articleModal');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeArticleModal();
    });

    // Filtros de categoría
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');

            document.querySelectorAll('.article-row').forEach(row => {
                const cat = row.getAttribute('data-category');
                if (filter === 'all' || cat === filter) {
                    row.style.display = 'grid';
                } else {
                    row.style.display = 'none';
                }
            });

            const featEl = document.querySelector('.article-featured');
            if (featEl) {
                const featCat = featEl.getAttribute('data-category');
                if (filter === 'all' || featCat === filter) {
                    featEl.style.display = 'grid';
                } else {
                    featEl.style.display = 'none';
                }
            }
        });
    });

    // Auto-abrir si viene por parámetro o hash (?article=slug o #slug o ?id=1)
    const urlParams = new URLSearchParams(window.location.search);
    const targetParam = urlParams.get('article') || urlParams.get('id') || window.location.hash.replace('#', '');
    if (targetParam) {
        openArticleModal(targetParam);
    }
</script>

@endsection
