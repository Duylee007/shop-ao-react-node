/* ===================================================
   PREMIUM EFFECTS JS - DUY STUDIO
   Level: Luxury Motion Interactions
   =================================================== */

(function() {
    'use strict';

    // ─── PAGE LOADER ──────────────────────────────────
    window.addEventListener('load', function() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            setTimeout(() => loader.classList.add('loaded'), 400);
        }
        // Trigger initial reveals
        checkReveals();
    });

    // ─── CUSTOM CURSOR ────────────────────────────────
    const cursor   = document.getElementById('custom-cursor');
    const follower = document.getElementById('cursor-follower');
    let mouseX = 0, mouseY = 0, followerX = 0, followerY = 0;

    if (cursor && follower && window.matchMedia('(hover: hover)').matches) {
        document.addEventListener('mousemove', function(e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            cursor.style.left = mouseX + 'px';
            cursor.style.top  = mouseY + 'px';
        });

        document.addEventListener('mousedown', () => document.body.classList.add('cursor-click'));
        document.addEventListener('mouseup',   () => document.body.classList.remove('cursor-click'));

        const hoverTargets = 'a, button, [role="button"], .yame-product-card, .category-pill-item, input, textarea, select';
        document.querySelectorAll(hoverTargets).forEach(el => {
            el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
            el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
        });

        // Smooth follower with RAF
        function animateFollower() {
            followerX += (mouseX - followerX) * 0.12;
            followerY += (mouseY - followerY) * 0.12;
            follower.style.left = followerX + 'px';
            follower.style.top  = followerY + 'px';
            requestAnimationFrame(animateFollower);
        }
        animateFollower();
    }

    // ─── SCROLL PROGRESS BAR ──────────────────────────
    const progressBar = document.getElementById('scroll-progress');
    const backToTop   = document.getElementById('back-to-top');

    window.addEventListener('scroll', function() {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        if (progressBar) progressBar.style.width = pct + '%';

        // Navbar shrink
        const navbar = document.querySelector('.yame-navbar');
        if (navbar) navbar.classList.toggle('scrolled', scrollTop > 40);

        // Back to top button
        if (backToTop) backToTop.classList.toggle('show', scrollTop > 400);

        // Scroll reveals
        checkReveals();
    }, { passive: true });

    if (backToTop) {
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    // ─── SCROLL REVEAL ────────────────────────────────
    function checkReveals() {
        const reveals = document.querySelectorAll('.reveal, .stagger-children');
        reveals.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight * 0.88) {
                el.classList.add('visible');
            }
        });
    }
    // Initial check
    setTimeout(checkReveals, 100);

    // ─── RIPPLE EFFECT ON BUTTONS ─────────────────────
    function addRipple(e) {
        const btn  = e.currentTarget;
        const rect = btn.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height) * 2;
        const x    = e.clientX - rect.left - size / 2;
        const y    = e.clientY - rect.top  - size / 2;
        const ripple = document.createElement('span');
        ripple.className = 'btn-ripple';
        ripple.style.cssText = 'width:' + size + 'px;height:' + size + 'px;left:' + x + 'px;top:' + y + 'px;';
        btn.appendChild(ripple);
        ripple.addEventListener('animationend', () => ripple.remove());
    }
    document.querySelectorAll('.btn-yame-red,.btn-yame-dark,.btn-yame-outline,.btn-yame-white,.btn-yame-admin').forEach(btn => {
        btn.addEventListener('click', addRipple);
    });

    // ─── HERO PARTICLE CANVAS ─────────────────────────
    const canvas = document.getElementById('heroParticles');
    if (canvas) {
        const ctx    = canvas.getContext('2d');
        let particles = [];

        function resizeCanvas() {
            canvas.width  = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas, { passive: true });

        function Particle() {
            this.reset = function() {
                this.x    = Math.random() * canvas.width;
                this.y    = canvas.height + 10;
                this.size = Math.random() * 2 + 0.5;
                this.speedY = -(Math.random() * 0.8 + 0.3);
                this.speedX = (Math.random() - 0.5) * 0.4;
                this.alpha  = 0;
                this.targetAlpha = Math.random() * 0.6 + 0.1;
                this.color = Math.random() > 0.6 ? '225,29,72' : '255,255,255';
            };
            this.reset();
            this.y = Math.random() * canvas.height;
            this.alpha = Math.random() * 0.4;
        }

        for (let i = 0; i < 55; i++) particles.push(new Particle());

        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.x += p.speedX;
                p.y += p.speedY;
                if (p.alpha < p.targetAlpha) p.alpha += 0.008;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(' + p.color + ',' + p.alpha + ')';
                ctx.fill();
                if (p.y < -10) p.reset();
            });
            requestAnimationFrame(drawParticles);
        }
        drawParticles();
    }

    // ─── MAGNETIC BUTTONS ─────────────────────────────
    document.querySelectorAll('.btn-yame-red, .btn-yame-dark').forEach(btn => {
        btn.addEventListener('mousemove', function(e) {
            const rect = btn.getBoundingClientRect();
            const cx = rect.left + rect.width  / 2;
            const cy = rect.top  + rect.height / 2;
            const dx = (e.clientX - cx) * 0.25;
            const dy = (e.clientY - cy) * 0.25;
            btn.style.transform = 'translate(' + dx + 'px,' + dy + 'px) translateY(-2px)';
        });
        btn.addEventListener('mouseleave', function() {
            btn.style.transform = '';
        });
    });

    // ─── 3D CARD TILT ─────────────────────────────────
    document.querySelectorAll('.yame-product-card').forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const cx   = rect.left + rect.width  / 2;
            const cy   = rect.top  + rect.height / 2;
            const rx   = ((e.clientY - cy) / (rect.height / 2)) * -6;
            const ry   = ((e.clientX - cx) / (rect.width  / 2)) *  6;
            card.style.transform = 'translateY(-10px) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg)';
            card.style.transition = 'transform 0.1s ease';
        });
        card.addEventListener('mouseleave', function() {
            card.style.transform = '';
            card.style.transition = '';
        });
    });

    // ─── ANIMATED NUMBER COUNTERS ─────────────────────
    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-count') || el.innerText.replace(/\D/g,''), 10);
        if (isNaN(target)) return;
        const duration = 1800;
        const start    = performance.now();
        const suffix   = el.getAttribute('data-suffix') || '';
        const prefix   = el.getAttribute('data-prefix') || '';

        function step(now) {
            const elapsed  = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased    = 1 - Math.pow(1 - progress, 3);
            el.textContent = prefix + Math.floor(eased * target).toLocaleString('vi-VN') + suffix;
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    const counterObserver = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting && !e.target.dataset.counted) {
                e.target.dataset.counted = '1';
                animateCounter(e.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count], .hero-stat-number').forEach(el => {
        counterObserver.observe(el);
    });

    // ─── TOPBAR MARQUEE CLONE ─────────────────────────
    const track = document.querySelector('.topbar-marquee-track');
    if (track && !track.dataset.cloned) {
        track.dataset.cloned = '1';
        track.innerHTML += track.innerHTML;
    }

    // ─── GLITCH TEXT SETUP ────────────────────────────
    document.querySelectorAll('.glitch-text').forEach(el => {
        if (!el.dataset.text) el.dataset.text = el.textContent;
    });

    // ─── STAGGER REVEAL SETUP ─────────────────────────
    // Auto-add reveal classes to key sections
    document.querySelectorAll('.yame-commitments .row').forEach(el => el.classList.add('stagger-children'));
    document.querySelectorAll('section > .container > .yame-section-header').forEach(el => el.classList.add('reveal'));
    document.querySelectorAll('.lookbook-banner').forEach(el => el.classList.add('reveal', 'reveal-scale'));
    document.querySelectorAll('.yame-product-card').forEach((el, i) => {
        el.classList.add('reveal');
        el.style.transitionDelay = (i % 4) * 0.08 + 's';
    });
    document.querySelectorAll('.category-pill-item').forEach((el, i) => {
        el.classList.add('reveal');
        el.style.transitionDelay = i * 0.07 + 's';
    });

    // Re-check reveals after adding classes
    setTimeout(checkReveals, 150);

    // ─── IMAGE PARALLAX ON HERO ───────────────────────
    window.addEventListener('scroll', function() {
        const heroImg = document.querySelector('.yame-hero-img');
        if (heroImg && window.scrollY < window.innerHeight) {
            heroImg.style.transform = 'scale(1) translateY(' + (window.scrollY * 0.12) + 'px)';
        }
    }, { passive: true });

    // ─── LUXURY TOAST REDESIGN ────────────────────────
    window.showToast = function(message, type) {
        type = type || 'success';
        const colors = {
            success: { bg: '#111111', accent: '#10b981', icon: '✓' },
            error:   { bg: '#111111', accent: '#e11d48', icon: '✕' },
            info:    { bg: '#111111', accent: '#0ea5e9', icon: 'i' }
        };
        const c = colors[type] || colors.success;
        const toast = document.createElement('div');
        toast.style.cssText = [
            'position:fixed;bottom:32px;right:32px;z-index:99999',
            'display:flex;align-items:center;gap:14px',
            'background:' + c.bg,
            'color:#fff',
            'border:1px solid rgba(255,255,255,0.08)',
            'border-radius:14px',
            'padding:16px 22px',
            'font-family:Plus Jakarta Sans,sans-serif',
            'font-size:0.88rem;font-weight:600',
            'box-shadow:0 20px 50px rgba(0,0,0,0.4)',
            'transform:translateY(80px) scale(0.9);opacity:0',
            'transition:all 0.4s cubic-bezier(0.34,1.56,0.64,1)',
            'min-width:280px;max-width:380px',
        ].join(';');
        toast.innerHTML = [
            '<div style="width:36px;height:36px;border-radius:50%;background:' + c.accent + ';display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;flex-shrink:0;">' + c.icon + '</div>',
            '<div style="flex:1;">' + message + '</div>',
            '<button onclick="this.parentElement.remove()" style="background:none;border:none;color:#52525b;font-size:1.2rem;cursor:pointer;padding:0;line-height:1;">&times;</button>'
        ].join('');
        document.body.appendChild(toast);
        requestAnimationFrame(() => {
            toast.style.transform = 'translateY(0) scale(1)';
            toast.style.opacity   = '1';
        });
        setTimeout(() => {
            toast.style.transform = 'translateY(20px) scale(0.95)';
            toast.style.opacity   = '0';
            setTimeout(() => toast.remove(), 400);
        }, 3500);
    };

    // ─── NAVBAR ACTIVE LINK INDICATOR ────────────────
    const navLinks = document.querySelectorAll('.yame-nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ─── QUANTITY INPUT LIVE FEEDBACK ────────────────
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            if (!input) return;
            const isMinus = this.classList.contains('minus');
            let val = parseInt(input.value) || 1;
            const max = parseInt(input.max) || 999;
            if (isMinus && val > 1) val--;
            else if (!isMinus && val < max) val++;
            input.value = val;
            // Animate
            input.style.transform = 'scale(1.2)';
            setTimeout(() => input.style.transform = '', 200);
        });
    });

})();
