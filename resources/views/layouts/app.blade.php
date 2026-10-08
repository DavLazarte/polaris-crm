<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Polaris Cooperation Group')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,300&family=Lato:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <style>
        /* Selector de idiomas dropdown */
        .lang-dropdown {
            position: relative;
            display: inline-block;
        }
        .lang-drop-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.68rem;
            letter-spacing: 0.08em;
            padding: 7px 12px;
            border-radius: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all 0.3s ease;
        }
        .lang-drop-btn:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: var(--sky);
        }
        #nav.solid .lang-drop-btn {
            background: rgba(0, 4, 18, 0.04);
            border-color: rgba(0, 4, 18, 0.15);
            color: var(--navy);
        }
        #nav.solid .lang-drop-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }
        .lang-drop-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #000412;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 6px;
            min-width: 155px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.5);
            display: none;
            flex-direction: column;
            gap: 2px;
            z-index: 1000;
        }
        #nav.solid .lang-drop-menu {
            background: #ffffff;
            border-color: rgba(0, 4, 18, 0.1);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }
        .lang-dropdown:hover .lang-drop-menu,
        .lang-dropdown.open .lang-drop-menu {
            display: flex;
        }
        .lang-drop-menu a {
            padding: 8px 12px;
            border-radius: 6px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.68rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s, color 0.2s;
            white-space: nowrap;
        }
        #nav.solid .lang-drop-menu a {
            color: var(--navy);
        }
        .lang-drop-menu a:hover {
            background: rgba(48, 87, 190, 0.3);
            color: #ffffff;
        }
        #nav.solid .lang-drop-menu a:hover {
            background: rgba(48, 87, 190, 0.08);
            color: var(--blue);
        }
        .lang-drop-menu a.active {
            color: var(--sky);
            font-weight: 800;
        }
        #nav.solid .lang-drop-menu a.active {
            color: var(--blue);
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- ════════════════════════════════════════════════════════════════
     NAVBAR ORIGINAL DE POLARIS
════════════════════════════════════════════════════════════════ -->
<nav id="nav">
    <a href="{{ route('home') }}" class="nav-brand" id="nav-brand-link">
        <img src="{{ asset('assets/vectorpolaris-blanco.png') }}" alt="Polaris Cooperation Group" id="nav-logo">
    </a>

    <div class="nav-links">
        <a href="{{ route('home') }}">{{ __('Inicio') }}</a>
        <a href="{{ route('nosotros') }}">{{ __('Quiénes Somos') }}</a>
        <a href="{{ route('servicios') }}">{{ __('Servicios') }}</a>
        <a href="{{ route('radar') }}">{{ __('Radar') }}</a>
        <a href="{{ route('news') }}">{{ __('Perspectivas') }}</a>
        <a href="{{ route('contacto') }}">{{ __('Contacto') }}</a>
    </div>

    <div class="nav-right">
        <div class="lang-dropdown" id="langDropdown">
            @php
                $locale = app()->getLocale();
                $flags = ['es' => '🇪🇸', 'en' => '🇬🇧', 'pt' => '🇧🇷', 'fr' => '🇫🇷'];
                $currentFlag = $flags[$locale] ?? '🌐';
            @endphp
            <button class="lang-drop-btn" type="button" onclick="document.getElementById('langDropdown').classList.toggle('open')">
                <span>{{ $currentFlag }} {{ strtoupper($locale) }}</span>
                <svg width="8" height="5" viewBox="0 0 8 5" fill="none"><path d="M1 1L4 4L7 1" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <div class="lang-drop-menu">
                <a href="{{ route('lang.switch', 'es') }}" class="{{ $locale == 'es' ? 'active' : '' }}">
                    <span>🇪🇸</span> Español (ES)
                </a>
                <a href="{{ route('lang.switch', 'en') }}" class="{{ $locale == 'en' ? 'active' : '' }}">
                    <span>🇬🇧</span> English (EN)
                </a>
                <a href="{{ route('lang.switch', 'pt') }}" class="{{ $locale == 'pt' ? 'active' : '' }}">
                    <span>🇧🇷</span> Português (PT)
                </a>
                <a href="{{ route('lang.switch', 'fr') }}" class="{{ $locale == 'fr' ? 'active' : '' }}">
                    <span>🇫🇷</span> Français (FR)
                </a>
            </div>
        </div>
        <a href="{{ route('contacto') }}" class="nav-cta">{{ __('Hablemos') }}</a>
    </div>
</nav>

@yield('content')

<!-- ════════════════════════════════════════════════════════════════
     FOOTER ORIGINAL DE POLARIS
════════════════════════════════════════════════════════════════ -->
<footer>
    <div class="footer-grid">
        <div>
            <img src="{{ asset('assets/vectorpolaris-blanco.png') }}" alt="Polaris" class="footer-logo">
            <p class="footer-tagline">
                {{ __('Firma consultora experta en inserción internacional, cooperación y desarrollo de negocios globales. Buenos Aires, Argentina.') }}
            </p>
        </div>
        <div class="footer-col">
            <h5>{{ __('Navegación') }}</h5>
            <ul>
                <li><a href="{{ route('home') }}">{{ __('Inicio') }}</a></li>
                <li><a href="{{ route('nosotros') }}">{{ __('Quiénes Somos') }}</a></li>
                <li><a href="{{ route('servicios') }}">{{ __('Servicios') }}</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h5>{{ __('Recursos') }}</h5>
            <ul>
                <li><a href="{{ route('radar') }}">{{ __('Radar de Convocatorias') }}</a></li>
                <li><a href="{{ route('news') }}">{{ __('Perspectivas') }}</a></li>
                <li><a href="{{ route('contacto') }}">{{ __('Contacto') }}</a></li>
                <li><a href="{{ asset('manual.html') }}" target="_blank">{{ __('Manual de Marca') }}</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h5>{{ __('Contacto') }}</h5>
            <ul>
                <li><a href="#">{{ __('Buenos Aires, Argentina') }}</a></li>
                <li><a href="mailto:info@polariscg.com.ar">info@polariscg.com.ar</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <span class="footer-copy">{{ __('© 2026 Polaris Cooperation Group. Todos los derechos reservados.') }}</span>
        <div class="footer-legal">
            <a href="#">{{ __('Privacidad') }}</a>
            <a href="#">{{ __('Términos') }}</a>
        </div>
    </div>
</footer>

<!-- ════════════════════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════════════════════ -->
<script src="{{ asset('assets/main.js') }}"></script>
<script>
    document.addEventListener('click', function(e) {
        const drop = document.getElementById('langDropdown');
        if (drop && !drop.contains(e.target)) {
            drop.classList.remove('open');
        }
    });
</script>
@stack('scripts')

</body>
</html>
