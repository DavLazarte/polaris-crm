@extends('layouts.app')
@section('title', __('Polaris Cooperation Group | Contacto'))

@section('content')

<style>
    /* ═══════════════════════════════════════════
       CONTACT PAGE — FULL SPLIT DARK + LIGHT
    ═══════════════════════════════════════════ */

    /* ── SPLIT LAYOUT ─────────────────────────── */
    .contact-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
    }

    /* ── LEFT: DARK PANEL ─────────────────────── */
    .contact-left {
        background: linear-gradient(160deg, #000412 0%, #050d2a 60%, #081640 100%);
        padding: 160px 72px 80px;
        display: flex; flex-direction: column;
        justify-content: space-between;
        position: relative; overflow: hidden;
    }
    .contact-left::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(116,172,223,0.12) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }
    .contact-left::after {
        content: '';
        position: absolute;
        bottom: -10%; right: -10%;
        width: 500px; height: 500px;
        background: url('{{ asset("assets/vectorpolaris-blanco.png") }}') center/contain no-repeat;
        opacity: 0.04;
        pointer-events: none;
    }

    .contact-left-content { position: relative; z-index: 2; }

    .contact-eyebrow {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem; font-weight: 800;
        letter-spacing: 0.3em; text-transform: uppercase;
        color: var(--sky); margin-bottom: 36px;
        display: flex; align-items: center; gap: 14px;
    }
    .contact-eyebrow::before { content: ''; width: 36px; height: 1.5px; background: var(--sky); border-radius: 2px; }

    .contact-heading {
        font-family: 'Montserrat', sans-serif;
        font-size: clamp(2.6rem, 3.8vw, 4rem);
        font-weight: 900; color: white;
        letter-spacing: -0.04em; line-height: 0.95;
        margin-bottom: 32px;
    }
    .contact-heading em { color: var(--sky); font-style: italic; font-weight: 300; }

    .contact-intro {
        font-size: 1rem; font-weight: 300;
        color: rgba(255,255,255,0.45);
        line-height: 1.85; max-width: 400px;
        margin-bottom: 56px;
    }

    /* ── INFO ITEMS ───────────────────────────── */
    .contact-info-list { display: flex; flex-direction: column; gap: 32px; position: relative; z-index: 2; }
    .contact-info-item { display: flex; gap: 18px; align-items: flex-start; }
    .contact-info-icon {
        width: 42px; height: 42px; flex-shrink: 0;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.08);
        background: rgba(255,255,255,0.04);
        display: flex; align-items: center; justify-content: center;
    }
    .contact-info-icon svg { width: 16px; height: 16px; stroke: var(--sky); }
    .contact-info-label {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.6rem; font-weight: 700;
        letter-spacing: 0.16em; text-transform: uppercase;
        color: rgba(255,255,255,0.3); margin-bottom: 5px;
    }
    .contact-info-value {
        font-size: 0.95rem; font-weight: 400;
        color: white; text-decoration: none;
        transition: color 0.3s;
    }
    a.contact-info-value:hover { color: var(--sky); }

    /* ── RIGHT: LIGHT FORM PANEL ──────────────── */
    .contact-right {
        background: white;
        padding: 120px 72px 80px;
        display: flex; flex-direction: column;
        justify-content: center;
    }

    .form-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.6rem; font-weight: 900;
        color: var(--navy); letter-spacing: -0.03em;
        margin-bottom: 8px;
    }
    .form-subtitle {
        font-size: 0.875rem; font-weight: 300;
        color: var(--muted); margin-bottom: 44px;
        line-height: 1.6;
    }

    /* ── FORM ELEMENTS ───────────────────────── */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .field { margin-bottom: 22px; }
    .field label {
        display: block;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; font-size: 0.65rem;
        letter-spacing: 0.14em; text-transform: uppercase;
        color: var(--navy); margin-bottom: 10px;
    }
    .field input,
    .field select,
    .field textarea {
        width: 100%;
        padding: 16px 20px;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        font-family: 'Lato', sans-serif;
        font-size: 0.9rem; color: var(--text);
        background: var(--off);
        transition: all 0.3s; outline: none;
        appearance: none;
    }
    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        border-color: var(--blue);
        background: white;
        box-shadow: 0 0 0 4px rgba(48,87,190,0.08);
    }
    .field textarea { resize: vertical; min-height: 130px; }
    .field input::placeholder,
    .field textarea::placeholder { color: #b0bdd4; }

    /* ── AREA CHIPS ──────────────────────────── */
    .area-chips { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 6px; }
    .area-chip {
        padding: 10px 18px;
        border: 1.5px solid var(--border);
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.62rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--muted); background: var(--off);
        cursor: pointer; transition: all 0.25s;
        user-select: none;
    }
    .area-chip:hover,
    .area-chip.active {
        background: var(--navy); color: white;
        border-color: var(--navy);
    }

    /* ── SUBMIT ──────────────────────────────── */
    .form-submit {
        width: 100%;
        padding: 20px;
        background: var(--navy);
        color: white;
        border: none; cursor: pointer;
        border-radius: 14px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem; font-weight: 800;
        letter-spacing: 0.18em; text-transform: uppercase;
        transition: background 0.3s, transform 0.2s;
        margin-top: 12px;
        display: flex; align-items: center; justify-content: center; gap: 10px;
    }
    .form-submit:hover { background: var(--blue); transform: translateY(-2px); }
    .form-submit svg { width: 16px; height: 16px; stroke: white; transition: transform 0.3s; }
    .form-submit:hover svg { transform: translateX(4px); }

    .form-note {
        font-size: 0.75rem; color: var(--muted);
        text-align: center; margin-top: 18px;
        font-weight: 300;
    }
    .form-note a { color: var(--blue); text-decoration: none; }

    /* ── MOBILE ──────────────────────────────── */
    @media (max-width: 900px) {
        .contact-layout { grid-template-columns: 1fr; }
        .contact-left { padding: 140px 28px 64px; min-height: auto; }
        .contact-right { padding: 60px 28px 80px; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<!-- ── SPLIT CONTACT LAYOUT ──────────────────────────────────── -->
<div class="contact-layout">

    <!-- LEFT: info oscura -->
    <div class="contact-left">
        <div class="contact-left-content">
            <div class="contact-eyebrow fade-up">{{ __('Iniciemos juntos') }}</div>
            <h1 class="contact-heading fade-up">
                {!! __('Diseñemos<br>su estrategia<br><em>internacional.</em>') !!}
            </h1>
            <p class="contact-intro fade-up">
                {{ __('Cuéntenos su desafío. En 48 horas un especialista de Polaris se pondrá en contacto para entender su proyecto en profundidad.') }}
            </p>
        </div>

        <div class="contact-info-list">
            <div class="contact-info-item fade-up">
                <div class="contact-info-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <div>
                    <div class="contact-info-label">{{ __('Email corporativo') }}</div>
                    <a href="mailto:info@polariscg.com.ar" class="contact-info-value">info@polariscg.com.ar</a>
                </div>
            </div>
            <div class="contact-info-item fade-up">
                <div class="contact-info-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <div>
                    <div class="contact-info-label">{{ __('Sede Central') }}</div>
                    <span class="contact-info-value">{{ __('Buenos Aires, República Argentina') }}</span>
                </div>
            </div>
            <div class="contact-info-item fade-up">
                <div class="contact-info-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                </div>
                <div>
                    <div class="contact-info-label">{{ __('Red de operación') }}</div>
                    <span class="contact-info-value">{{ __('América Latina · Europa · Emergentes') }}</span>
                </div>
            </div>
            <div class="contact-info-item fade-up">
                <div class="contact-info-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>
                    </svg>
                </div>
                <div>
                    <div class="contact-info-label">{{ __('LinkedIn') }}</div>
                    <a href="#" class="contact-info-value">Polaris Cooperation Group</a>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: formulario claro -->
    <div class="contact-right">
        <div class="form-title fade-up">{{ __('Cuéntenos su proyecto') }}</div>
        <div class="form-subtitle fade-up">{{ __('Respondemos en menos de 48 horas hábiles.') }}</div>

        <form id="contactForm">
            <div class="form-row">
                <div class="field fade-up">
                    <label>{{ __('Nombre *') }}</label>
                    <input type="text" name="nombre" placeholder="Juan García" required>
                </div>
                <div class="field fade-up">
                    <label>{{ __('Organización *') }}</label>
                    <input type="text" name="organizacion" placeholder="{{ __('Municipio / Empresa / ONG') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="field fade-up">
                    <label>{{ __('Email *') }}</label>
                    <input type="email" name="email" placeholder="juan@organizacion.com" required>
                </div>
                <div class="field fade-up">
                    <label>{{ __('País') }}</label>
                    <input type="text" name="pais" placeholder="Argentina">
                </div>
            </div>

            <div class="field fade-up">
                <label>{{ __('Área de interés') }}</label>
                <input type="hidden" name="intereses" id="intereses-input" value="Cooperación y Financiamiento">
                <div class="area-chips" id="chips">
                    <div class="area-chip active" onclick="toggleChip(this)">{{ __('Cooperación y Financiamiento') }}</div>
                    <div class="area-chip" onclick="toggleChip(this)">{{ __('Inteligencia Estratégica') }}</div>
                    <div class="area-chip" onclick="toggleChip(this)">{{ __('Desarrollo de Negocios') }}</div>
                    <div class="area-chip" onclick="toggleChip(this)">{{ __('Implementación de Proyectos') }}</div>
                    <div class="area-chip" onclick="toggleChip(this)">{{ __('Capacitación y Formación') }}</div>
                </div>
            </div>

            <div class="field fade-up">
                <label>{{ __('Mensaje *') }}</label>
                <textarea name="mensaje" placeholder="{{ __('Cuéntenos su desafío o proyecto. ¿Cuál es el objetivo? ¿Qué mercados tiene en mente?') }}" required></textarea>
            </div>

            <button type="submit" class="form-submit fade-up" id="submitBtn">
                <span>{{ __('Enviar consulta') }}</span>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>

            <p class="form-note fade-up">
                {{ __('Al enviar acepta nuestra') }} <a href="#">{{ __('política de privacidad') }}</a>.
                {{ __('Su información nunca será compartida con terceros.') }}
            </p>
        </form>
    </div>
</div>

<script>
    function toggleChip(el) {
        el.classList.toggle('active');
        updateInterests();
    }

    function updateInterests() {
        const activeChips = Array.from(document.querySelectorAll('.area-chip.active'))
            .map(chip => chip.textContent.trim());
        document.getElementById('intereses-input').value = activeChips.join(', ');
    }

    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        const submitBtnText = submitBtn.querySelector('span');
        const submitBtnSvg = submitBtn.querySelector('svg');
        
        const formData = new FormData(form);
        
        submitBtn.disabled = true;
        submitBtnText.textContent = '{{ __("Enviando...") }}';
        if (submitBtnSvg) submitBtnSvg.style.display = 'none';
        
        fetch('{{ url("/contacto/enviar") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en el servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const nombre = formData.get('nombre') || '';
                
                const rightPanel = document.querySelector('.contact-right');
                rightPanel.innerHTML = `
                    <div style="text-align: center; padding: 40px 0; opacity: 0; transform: translateY(20px); animation: fadeInUpSuccess 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
                        <div style="width: 80px; height: 80px; background: rgba(48,87,190,0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#3057be" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <h3 style="font-family: 'Montserrat', sans-serif; font-size: 2rem; font-weight: 900; color: var(--navy); margin-bottom: 15px; letter-spacing: -0.02em; line-height: 1.1;">{{ __('¡Muchas gracias,') }} ${nombre}!</h3>
                        <p style="font-size: 1.05rem; color: var(--muted); line-height: 1.8; font-weight: 300; max-width: 420px; margin: 0 auto 35px;">
                            {!! __('Tu consulta ha sido enviada con éxito.<br>Nos pondremos en contacto en menos de 48 horas hábiles.') !!}
                        </p>
                        <a href="{{ route('home') }}" class="btn-solid" style="display: inline-block; box-shadow: 0 6px 20px rgba(48,87,190,0.3); text-decoration: none;">{{ __('Volver al Inicio') }}</a>
                    </div>
                `;
            } else {
                alert(data.message || 'Ocurrió un error al enviar el mensaje. Por favor intente nuevamente.');
                resetBtn();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión o del servidor. Por favor verifique e intente nuevamente.');
            resetBtn();
        });
        
        function resetBtn() {
            submitBtn.disabled = false;
            submitBtnText.textContent = '{{ __("Enviar consulta") }}';
            if (submitBtnSvg) submitBtnSvg.style.display = 'block';
        }
    });

    const styleEl = document.createElement('style');
    styleEl.innerHTML = `
        @keyframes fadeInUpSuccess {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(styleEl);
</script>

@endsection
