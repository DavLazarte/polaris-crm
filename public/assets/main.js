document.addEventListener("DOMContentLoaded", () => {

    // ═══════════════════════════════════════════════════════
    // 1. MOUSE PARALLAX — canvas de partículas que sigue el mouse
    // ═══════════════════════════════════════════════════════
    const canvas = document.createElement('canvas');
    canvas.id = 'parallax-canvas';
    document.body.prepend(canvas);
    const ctx = canvas.getContext('2d');

    let W = canvas.width  = window.innerWidth;
    let H = canvas.height = window.innerHeight;
    let mouseX = W / 2, mouseY = H / 2;
    let targetX = W / 2, targetY = H / 2;

    window.addEventListener('resize', () => {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    });

    document.addEventListener('mousemove', e => {
        targetX = e.clientX;
        targetY = e.clientY;
    });

    // Partículas de mapa/constelación
    const PARTICLE_COUNT = 60;
    const particles = Array.from({ length: PARTICLE_COUNT }, () => ({
        x: Math.random() * W,
        y: Math.random() * H,
        baseX: 0, baseY: 0,
        r: Math.random() * 1.8 + 0.4,
        alpha: Math.random() * 0.4 + 0.1,
        speed: Math.random() * 0.3 + 0.05,
        parallaxFactor: Math.random() * 0.04 + 0.005,
    }));
    particles.forEach(p => { p.baseX = p.x; p.baseY = p.y; });

    const CONNECTION_DIST = 140;

    function drawParticles() {
        // Lerp suave del mouse
        mouseX += (targetX - mouseX) * 0.06;
        mouseY += (targetY - mouseY) * 0.06;

        const dx = (mouseX - W / 2);
        const dy = (mouseY - H / 2);

        ctx.clearRect(0, 0, W, H);

        // Dibujar conexiones
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const a = particles[i];
                const b = particles[j];
                const dist = Math.hypot(a.x - b.x, a.y - b.y);
                if (dist < CONNECTION_DIST) {
                    const opacity = (1 - dist / CONNECTION_DIST) * 0.12;
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.strokeStyle = `rgba(116,172,223,${opacity})`;
                    ctx.lineWidth = 0.6;
                    ctx.stroke();
                }
            }
        }

        // Dibujar partículas
        particles.forEach(p => {
            // Parallax: se mueve levemente con el mouse
            p.x = p.baseX + dx * p.parallaxFactor;
            p.y = p.baseY + dy * p.parallaxFactor;

            // Drift lento
            p.baseY -= p.speed * 0.15;
            if (p.baseY < -10) { p.baseY = H + 10; p.baseX = Math.random() * W; }

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(116,172,223,${p.alpha})`;
            ctx.fill();
        });

        requestAnimationFrame(drawParticles);
    }
    drawParticles();


    // ═══════════════════════════════════════════════════════
    // 2. SCROLL REVEAL — fade-up, reveal-left, reveal-right
    // ═══════════════════════════════════════════════════════
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -60px 0px',
        threshold: 0.12
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Auto-add fade-up to key elements that don't already have it
    const autoReveal = document.querySelectorAll(
        '.sec-label:not(.fade-up), .sec-h2:not(.fade-up), .sec-p:not(.fade-up), ' +
        '.method-card:not(.fade-up), .svc-card:not(.fade-up), ' +
        '.fp-card:not(.fade-up), .qs-card:not(.fade-up), ' +
        '.news-card:not(.fade-up), .hero-label:not(.fade-up), ' +
        '.hero-h1:not(.fade-up), .hero-p:not(.fade-up), ' +
        '.hero-actions:not(.fade-up), .cta-h2:not(.fade-up), .cta-p:not(.fade-up)'
    );
    autoReveal.forEach(el => el.classList.add('fade-up'));

    // Stagger for card grids
    document.querySelectorAll('.method-card, .svc-card, .fp-card, .qs-card, .news-card').forEach(el => {
        const idx = Array.from(el.parentNode.children).indexOf(el);
        el.style.transitionDelay = `${idx * 0.1}s`;
    });

    // Reveal-left for section text cols, reveal-right for card cols
    document.querySelectorAll('.qs-grid > div:first-child').forEach(el => el.classList.add('reveal-left'));
    document.querySelectorAll('.qs-grid > div:last-child').forEach(el => el.classList.add('reveal-right'));

    document.querySelectorAll('.fade-up, .fade-in, .reveal-left, .reveal-right').forEach(el => {
        observer.observe(el);
    });


    // ═══════════════════════════════════════════════════════
    // 3. NAVBAR — solid on scroll, logo swap
    // ═══════════════════════════════════════════════════════
    const nav = document.getElementById('nav');
    const navLogo = document.getElementById('nav-logo');

    if (nav && navLogo) {
        function onScroll() {
            const solid = window.scrollY > 70;
            nav.classList.toggle('solid', solid);
            if (!nav.classList.contains('logo-always-white')) {
                navLogo.src = solid
                    ? 'assets/vectorpolaris-negro.png'
                    : 'assets/vectorpolaris-blanco.png';
            }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }


    // ═══════════════════════════════════════════════════════
    // 4. PARALLAX SUTIL EN SECCIONES — el mapa del hero se mueve con scroll
    // ═══════════════════════════════════════════════════════
    const mapSvg = document.getElementById('map-svg');
    if (mapSvg) {
        function updateMap() {
            const scrollY  = window.scrollY;
            const totalH   = document.documentElement.scrollHeight - window.innerHeight;
            const progress = Math.min(scrollY / totalH, 1);
            const shift    = progress * -600;
            mapSvg.style.transform = `translateY(${shift}px)`;
        }
        window.addEventListener('scroll', updateMap, { passive: true });
        updateMap();
    }


    // ═══════════════════════════════════════════════════════
    // 5. CURSOR GLOW en secciones oscuras (section-navy)
    // ═══════════════════════════════════════════════════════
    const glow = document.createElement('div');
    glow.style.cssText = `
        position: fixed; width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(circle, rgba(116,172,223,0.08) 0%, transparent 70%);
        pointer-events: none; z-index: 1; transform: translate(-50%,-50%);
        transition: opacity 0.4s; opacity: 0;
    `;
    document.body.appendChild(glow);

    document.addEventListener('mousemove', e => {
        glow.style.left = e.clientX + 'px';
        glow.style.top  = e.clientY + 'px';

        // Solo visible sobre secciones oscuras
        const el = document.elementFromPoint(e.clientX, e.clientY);
        const section = el && el.closest('.section-navy, #hero, footer');
        glow.style.opacity = section ? '1' : '0';
    });

});
