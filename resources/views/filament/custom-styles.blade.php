<style>
    /* ═════════════════════════════════════════════════════════════
       POLARIS THEME FOR FILAMENT ADMIN & LOGIN
       ═════════════════════════════════════════════════════════════ */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap');

    :root {
        --polaris-navy: #000412;
        --polaris-navy-mid: #050d2a;
        --polaris-navy-card: #081438;
        --polaris-blue: #3057be;
        --polaris-sky: #74acdf;
    }

    /* ─── LOGIN PAGE BACKGROUND & CARDS ─────────────────────── */
    .fi-simple-layout {
        background: linear-gradient(135deg, #000412 0%, #050d2a 55%, #0a1d48 100%) !important;
        position: relative;
        min-height: 100vh;
    }

    /* Dot grid sutil como en el front */
    .fi-simple-layout::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(116, 172, 223, 0.16) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }

    .fi-simple-main-ctn {
        position: relative;
        z-index: 10;
    }

    /* Card de Login */
    .fi-simple-layout .fi-simple-card {
        background: rgba(5, 13, 42, 0.85) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border: 1px solid rgba(116, 172, 223, 0.22) !important;
        border-radius: 20px !important;
        box-shadow: 0 24px 60px rgba(0, 4, 18, 0.7), 0 0 40px rgba(48, 87, 190, 0.15) !important;
        padding: 2.25rem !important;
    }

    /* Logo en el Login */
    .fi-simple-layout .fi-logo {
        height: 3.5rem !important;
        filter: drop-shadow(0 4px 12px rgba(116, 172, 223, 0.35));
        transition: transform 0.3s ease;
    }
    .fi-simple-layout .fi-logo:hover {
        transform: scale(1.03);
    }

    /* Títulos y textos del Login */
    .fi-simple-layout h1, 
    .fi-simple-layout .fi-simple-header-heading {
        color: #ffffff !important;
        font-family: 'Montserrat', sans-serif !important;
        font-weight: 800 !important;
        letter-spacing: -0.02em !important;
    }

    .fi-simple-layout p, 
    .fi-simple-layout .fi-simple-header-subheading,
    .fi-simple-layout label {
        color: rgba(255, 255, 255, 0.75) !important;
        font-family: 'Montserrat', sans-serif !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
    }

    /* Inputs en el Login */
    .fi-simple-layout .fi-input-wrp {
        background: rgba(0, 4, 18, 0.6) !important;
        border: 1px solid rgba(116, 172, 223, 0.25) !important;
        border-radius: 12px !important;
        transition: border-color 0.25s, box-shadow 0.25s !important;
    }
    .fi-simple-layout .fi-input-wrp:focus-within {
        border-color: var(--polaris-sky) !important;
        box-shadow: 0 0 0 3px rgba(116, 172, 223, 0.25) !important;
    }
    .fi-simple-layout input {
        color: #ffffff !important;
    }

    /* Botón Principal (Polaris Blue con bordes redondeados y sombra) */
    .fi-btn-primary, 
    .fi-simple-layout button[type="submit"] {
        background: linear-gradient(135deg, #3057be 0%, #1e3a8a 100%) !important;
        border: none !important;
        border-radius: 50px !important;
        font-family: 'Montserrat', sans-serif !important;
        font-weight: 800 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        font-size: 0.78rem !important;
        padding: 0.75rem 1.75rem !important;
        box-shadow: 0 8px 24px rgba(48, 87, 190, 0.35) !important;
        transition: all 0.25s ease !important;
    }
    .fi-btn-primary:hover, 
    .fi-simple-layout button[type="submit"]:hover {
        background: linear-gradient(135deg, #416be0 0%, #2544a5 100%) !important;
        box-shadow: 0 10px 28px rgba(48, 87, 190, 0.5) !important;
        transform: translateY(-1.5px);
    }

    /* ─── ADMIN PANEL (INTERIOR) ────────────────────────────── */
    /* Sidebar */
    .fi-sidebar {
        background: #02071a !important;
        border-right: 1px solid rgba(255, 255, 255, 0.07) !important;
    }
    .fi-sidebar-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.07) !important;
        padding-top: 1.25rem !important;
        padding-bottom: 1.25rem !important;
    }
    .fi-sidebar-header .fi-logo {
        height: 2.5rem !important;
        filter: drop-shadow(0 2px 8px rgba(116, 172, 223, 0.25));
    }

    /* Items activos en Sidebar */
    .fi-sidebar-item-active .fi-sidebar-item-btn {
        background: rgba(48, 87, 190, 0.18) !important;
        border-left: 3px solid var(--polaris-sky) !important;
    }

    /* Topbar */
    .fi-topbar {
        background: #050d2a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07) !important;
    }
    .fi-topbar .fi-logo {
        height: 2.2rem !important;
    }

    /* Global Typography */
    body, .fi-body {
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
    }
</style>
