/* ====================================================================
   PT COMPANY — PREMIUM INTERACTION ENGINE
   Self-contained (tanpa CDN AOS). Semua efek animasi di sini.
   Target: tampilan web premium tanpa lag (hanya transform/opacity).
   ==================================================================== */
(function () {
    'use strict';

    var finePointer  = window.matchMedia('(pointer: fine)').matches && !('ontouchstart' in window);

    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    ready(function () {
        initSmoothScroll();
        initPageTransition();
        initPreloader();
        initReveal();
        initCounters();
        initScrollFx();
        initHeroSlider();
        initHeroParallax();
        initTypewriter();
        initHeroParticles();
        initGlow();
        initMagnetic();
        initTilt();
        initRipple();
        initMobileNav();
        initLightbox();
        initFooterYear();
    });

    /* ================================================================
       0. SMOOTH SCROLL — native (halus via CSS), tanpa library eksternal
       ================================================================ */
    function initSmoothScroll() {
        window.__lenis = null;
        document.documentElement.classList.add('smooth-scroll', 'scroll-native');
    }

    function smoothScrollTo(y, dur) {
        window.scrollTo({ top: y, behavior: 'smooth' });
    }

    /* ================================================================
       1. PAGE TRANSITION — tirai antar halaman (suryaindosinga style)
       ================================================================ */
    function initPageTransition() {
        var overlay = document.getElementById('pageTransition');
        if (!overlay) return;
        var FLAG = 'pt-nav';

        /* Datang dari navigasi: overlay menutup lalu terbuka */
        if (sessionStorage.getItem(FLAG) === '1') {
            sessionStorage.removeItem(FLAG);
            document.body.classList.add('page-transitioning');
            overlay.classList.add('active', 'reveal');
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    overlay.classList.add('out');
                });
            });
            setTimeout(function () {
                overlay.classList.remove('active', 'reveal', 'out');
                document.body.classList.remove('page-transitioning');
                document.body.classList.add('loaded');
            }, 720);
        }

        /* Tangkap klik tautan internal -> putar tirai */
        document.addEventListener('click', function (e) {
            var a = e.target.closest('a');
            if (!a) return;
            var href = a.getAttribute('href') || '';
            if (!href || href.charAt(0) === '#') return;
            if (a.target && a.target !== '_self') return;
            if (a.hasAttribute('download')) return;
            if (a.getAttribute('data-bs-toggle')) return;          /* modal/collapse */
            if (/^(mailto:|tel:|javascript:)/i.test(href)) return;
            if (/^(https?:)?\/\//i.test(href) && a.hostname !== location.hostname) return;
            if (e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;

            /* anchor di halaman yang sama -> scroll halus */
            if (a.pathname === location.pathname && a.hash) {
                var target = document.querySelector(a.hash);
                if (target) {
                    e.preventDefault();
                    smoothScrollTo(target, 1.1);
                }
                return;
            }

            e.preventDefault();
            sessionStorage.setItem(FLAG, '1');
            overlay.classList.add('reveal');
            overlay.classList.add('active');
            setTimeout(function () { window.location.href = a.href; }, 500);
        });
    }

    /* ================================================================
       2. PRELOADER — logo + persen (kunjungan langsung)
       ================================================================ */
    function initPreloader() {
        var pre = document.getElementById('preloader');
        if (!pre) return;
        var pct = document.getElementById('preloaderPct');
        var done = false, finishTimer = null;

        function finish() {
            if (done) return;
            done = true;
            clearTimeout(finishTimer);
            pre.classList.add('hide');
            document.body.classList.add('loaded');
            setTimeout(function () { if (pre.parentNode) pre.parentNode.removeChild(pre); }, 600);
        }

        /* Jalankan animasi persen hingga 100% dulu (halus), lalu tutup.
           Minimal durasi agar tidak terpotong; safety 900ms. */
        var start = null, dur = 700;
        function frame(ts) {
            if (pre.classList.contains('hide')) return;
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            if (pct) pct.textContent = Math.floor(p * 100) + '%';
            if (p < 1) requestAnimationFrame(frame);
            else finish();
        }
        requestAnimationFrame(frame);
        finishTimer = setTimeout(finish, 900);
    }

    /* ================================================================
       3. REVEAL ON SCROLL — kompatibel data-aos (tanpa CDN)
       ================================================================ */
    function initReveal() {
        var items = document.querySelectorAll('[data-aos]');
        if (!items.length) return;

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                var el = en.target;
                if (en.isIntersecting) {
                    el.classList.add('aos-animate');
                    io.unobserve(el);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

        items.forEach(function (el) {
            var delay = parseInt(el.getAttribute('data-aos-delay'), 10) || 0;
            var dur   = parseInt(el.getAttribute('data-aos-duration'), 10) || 850;
            el.classList.add('aos-init');
            el.style.transitionDelay = delay + 'ms';
            el.style.transitionDuration = dur + 'ms';
            el.addEventListener('transitionend', function handler(ev) {
                if (ev.propertyName !== 'opacity') return;
                el.removeEventListener('transitionend', handler);
                setTimeout(function () {
                    /* bersihkan agar transform/hover CSS asli tetap berfungsi */
                    el.removeAttribute('data-aos');
                    el.classList.remove('aos-init', 'aos-animate');
                    el.style.transitionDelay = '';
                    el.style.transitionDuration = '';
                }, 60);
            });
        });

        /* Arm observer setelah body "loaded" (setelah preloader/tirai) */
        var armed = false;
        function arm() {
            if (armed) return;
            armed = true;
            items.forEach(function (el) { io.observe(el); });
        }
        function checkLoaded() {
            if (document.body.classList.contains('loaded')) arm();
            else setTimeout(checkLoaded, 60);
        }
        checkLoaded();
        setTimeout(arm, 3400); /* pengaman */
    }

    /* ================================================================
       4. COUNTER ANGKA
       ================================================================ */
    function initCounters() {
        var counters = document.querySelectorAll('[data-count]');
        if (!counters.length) return;

        function animate(el) {
            var target = parseFloat(el.getAttribute('data-count')) || 0;
            var suffix = el.getAttribute('data-suffix') || '';
            var fmt = function (n) { return n.toLocaleString('id-ID') + suffix; };
            var dur = 1600, start = null;
            function step(ts) {
                if (!start) start = ts;
                var p = Math.min((ts - start) / dur, 1);
                var val = Math.floor(target * (1 - Math.pow(1 - p, 3)));
                el.textContent = fmt(val);
                if (p < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { animate(en.target); io.unobserve(en.target); }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (c) { io.observe(c); });
    }

    /* ================================================================
       5. SCROLL — progress bar, tombol ke atas (ring), navbar hide
       ================================================================ */
    function initScrollFx() {
        var progress = document.getElementById('scrollProgress');
        var toTop = document.getElementById('toTop');
        var nav = document.getElementById('mainNav');
        var lastY = 0, ticking = false;

        function update() {
            ticking = false;
            var st = window.scrollY;
            var h = document.documentElement.scrollHeight - window.innerHeight;
            var pct = h > 0 ? (st / h) * 100 : 0;
            if (progress) progress.style.width = pct + '%';
            if (toTop) {
                toTop.style.setProperty('--p', pct.toFixed(1));
                toTop.classList.toggle('show', st > 420);
            }
            if (nav && !document.body.classList.contains('page-transitioning')) {
                if (st > 180) nav.classList.toggle('nav-hidden', st > lastY && st > 260);
                else nav.classList.remove('nav-hidden');
            }
            lastY = st;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
        }, { passive: true });
        update();

        if (toTop) {
            toTop.addEventListener('click', function () {
                smoothScrollTo(0, 1);
            });
        }
    }

    /* ================================================================
       6. SLIDESHOW FOTO HERO — foto berganti otomatis (crossfade)
       ================================================================ */
    function initHeroSlider() {
        var slides = document.querySelectorAll('.hero .hero-bg');
        if (slides.length < 2) return;
        var dotsWrap = document.getElementById('heroDots');
        var dots = [];
        var current = 0, timer = null;

        function loadBg(el) {
            if (!el.dataset.bg || el.style.backgroundImage) return;
            var img = new Image();
            img.src = el.dataset.bg;
            img.onload = function () {
                el.style.backgroundImage = "url('" + el.dataset.bg + "')";
            };
        }

        function go(idx) {
            slides[current].classList.remove('is-active');
            if (dots[current]) dots[current].classList.remove('is-active');
            current = idx;
            slides[current].classList.add('is-active');
            if (dots[current]) dots[current].classList.add('is-active');
            loadBg(slides[current]);
            pulseContent();
        }
        function next() { go((current + 1) % slides.length); }
        function start() {
            clearInterval(timer);
            timer = setInterval(next, 6500);
            /* preload slide berikutnya jauh sebelum aktif (crossfade mulus) */
            if (slides[current + 1] || slides[0]) {
                var nxt = slides[current + 1] || slides[0];
                loadBg(nxt);
            }
        }

        function pulseContent() {
            var hero = document.querySelector('.hero');
            if (!hero || hero.classList.contains('slide-change')) return;
            hero.classList.add('slide-change');
            setTimeout(function () { hero.classList.remove('slide-change'); }, 1700);
        }

        for (var i = 0; i < slides.length; i++) {
            var d = document.createElement('span');
            d.className = 'hero-dot' + (i === 0 ? ' is-active' : '');
            (function (idx) {
                d.addEventListener('click', function () { go(idx); start(); });
            })(i);
            if (dotsWrap) dotsWrap.appendChild(d);
            dots.push(d);
        }
        start();
    }

    /* ================================================================
       7. PARALLAX HERO (halus, tanpa resize/scale)
       ================================================================ */
    function initHeroParallax() {
        if (!finePointer) return;
        var hero = document.querySelector('.hero');
        if (!hero) return;
        var visual = hero.querySelector('.hero-visual');
        var ticking = false;

        function update() {
            ticking = false;
            var rect = hero.getBoundingClientRect();
            if (rect.bottom < 0 || rect.top > window.innerHeight) return;
            var off = window.scrollY;
            /* Tanpa scale agar ukuran foto tidak berubah saat scroll */
            if (visual) visual.style.transform = 'translate3d(0,' + (off * -0.08).toFixed(1) + 'px,0)';
        }
        window.addEventListener('scroll', function () {
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
        }, { passive: true });
        update();
    }

    /* ================================================================
       8. TYPEWRITER HERO — kata berganti otomatis
       ================================================================ */
    function initTypewriter() {
        var el = document.getElementById('heroType');
        if (!el) return;
        var words = [];
        try { words = JSON.parse(el.getAttribute('data-words') || '[]'); } catch (e) { words = []; }
        if (!words.length) return;
        var wi = 0, ci = 0, deleting = false;
        function tick() {
            var word = words[wi];
            if (deleting) { ci--; } else { ci++; }
            el.textContent = word.slice(0, ci);
            var delay = deleting ? 38 : 85;
            if (!deleting && ci === word.length) { delay = 1900; deleting = true; }
            else if (deleting && ci === 0) { deleting = false; wi = (wi + 1) % words.length; delay = 400; }
            setTimeout(tick, delay);
        }
        tick();
    }

    /* ================================================================
       9. PARTIKEL CAHAYA HERO (canvas ringan)
       ================================================================ */
    function initHeroParticles() {
        var hero = document.querySelector('.hero');
        if (!hero || !finePointer) return;
        var canvas = document.createElement('canvas');
        canvas.id = 'heroParticles';
        hero.insertBefore(canvas, hero.querySelector('.container'));
        var ctx = canvas.getContext('2d');
        var W = 0, H = 0, parts = [];
        var running = false, rafId = 0;

        function resize() {
            var r = hero.getBoundingClientRect();
            var dpr = Math.min(window.devicePixelRatio || 1, 2);
            W = r.width; H = r.height;
            canvas.width = Math.round(W * dpr);
            canvas.height = Math.round(H * dpr);
            canvas.style.width = W + 'px';
            canvas.style.height = H + 'px';
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }
        function make() {
            parts = [];
            var n = Math.max(12, Math.min(45, Math.floor((W * H) / 20000)));
            for (var i = 0; i < n; i++) {
                parts.push({
                    x: Math.random() * W,
                    y: Math.random() * H,
                    r: Math.random() * 2.2 + 0.7,
                    vy: -(Math.random() * 0.35 + 0.12),
                    vx: (Math.random() - 0.5) * 0.18,
                    a: Math.random() * 0.45 + 0.15,
                    tw: Math.random() * Math.PI * 2
                });
            }
        }
        function tick() {
            if (!running) return;
            ctx.clearRect(0, 0, W, H);
            for (var i = 0; i < parts.length; i++) {
                var p = parts[i];
                p.y += p.vy; p.x += p.vx; p.tw += 0.045;
                if (p.y < -8) { p.y = H + 8; p.x = Math.random() * W; }
                if (p.x < -8) p.x = W + 8;
                else if (p.x > W + 8) p.x = -8;
                var alpha = p.a * (0.6 + 0.4 * Math.sin(p.tw));
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,' + alpha.toFixed(3) + ')';
                ctx.fill();
            }
            rafId = requestAnimationFrame(tick);
        }
        function start() { if (!running) { running = true; rafId = requestAnimationFrame(tick); } }
        function stop()  { running = false; cancelAnimationFrame(rafId); }

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (es) {
                es.forEach(function (en) {
                    if (en.isIntersecting) start(); else stop();
                });
            }, { threshold: 0.05 });
            io.observe(hero);
        } else { start(); }

        resize(); make();
        window.addEventListener('resize', function () { resize(); make(); }, { passive: true });
    }

    /* ================================================================
       7. GLOW MENGIKUTI MOUSE (desktop saja)
       ================================================================ */
    function initGlow() {
        if (!finePointer) return;
        var dot = document.createElement('div');
        dot.id = 'glowSpot';
        document.body.appendChild(dot);

        var x = window.innerWidth / 2, y = window.innerHeight / 2, tx = x, ty = y, ticking = false;
        window.addEventListener('mousemove', function (e) {
            tx = e.clientX; ty = e.clientY;
            if (!ticking) { ticking = true; requestAnimationFrame(loop); }
        }, { passive: true });

        function loop() {
            ticking = false;
            x += (tx - x) * 0.14; y += (ty - y) * 0.14;
            dot.style.transform = 'translate(' + x + 'px,' + y + 'px) translate(-50%,-50%)';
            if (Math.abs(tx - x) > 0.5 || Math.abs(ty - y) > 0.5) {
                ticking = true; requestAnimationFrame(loop);
            }
        }
    }

    /* ================================================================
       8. TOMBOL MAGNETIK
       ================================================================ */
    function initMagnetic() {
        if (!finePointer) return;
        document.querySelectorAll('.btn, .soc-icon').forEach(function (el) {
            var strength = 0.25, raf = 0, px = 0, py = 0;
            function apply() {
                raf = 0;
                el.style.transform = 'translate(' + px + 'px,' + py + 'px)';
            }
            el.addEventListener('mousemove', function (e) {
                var r = el.getBoundingClientRect();
                px = (e.clientX - (r.left + r.width / 2)) * strength;
                py = (e.clientY - (r.top + r.height / 2)) * strength;
                if (!raf) raf = requestAnimationFrame(apply);
            });
            el.addEventListener('mouseleave', function () {
                if (raf) cancelAnimationFrame(raf);
                el.style.transform = '';
            });
        });
    }

    /* ================================================================
       9. TILT 3D KARTU
       ================================================================ */
    function initTilt() {
        if (!finePointer) return;
        var max = 7;
        document.querySelectorAll('.feature-card, .product-card, .testimonial-card, .gallery-item').forEach(function (el) {
            var raf = 0, rx = 0, ry = 0;
            function apply() {
                raf = 0;
                el.style.transition = 'transform .08s linear';
                el.style.transform = 'perspective(900px) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg) translateY(-4px)';
            }
            el.addEventListener('mousemove', function (e) {
                var r = el.getBoundingClientRect();
                var px = (e.clientX - r.left) / r.width;
                var py = (e.clientY - r.top) / r.height;
                rx = (0.5 - py) * max;
                ry = (px - 0.5) * max;
                el.style.willChange = 'transform';
                if (!raf) raf = requestAnimationFrame(apply);
            });
            el.addEventListener('mouseleave', function () {
                if (raf) cancelAnimationFrame(raf);
                el.style.transition = 'transform .5s cubic-bezier(.22,1,.36,1)';
                el.style.transform = '';
                el.style.willChange = 'auto';
            });
        });
    }

    /* ================================================================
       10. RIPPLE KLIK PADA TOMBOL
       ================================================================ */
    function initRipple() {
        document.querySelectorAll('.btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                var r = btn.getBoundingClientRect();
                var d = Math.max(r.width, r.height) * 2;
                var span = document.createElement('span');
                span.className = 'ripple';
                span.style.width = span.style.height = d + 'px';
                span.style.left = (e.clientX - r.left - d / 2) + 'px';
                span.style.top = (e.clientY - r.top - d / 2) + 'px';
                btn.appendChild(span);
                setTimeout(function () { span.remove(); }, 650);
            });
        });
    }

    /* ================================================================
       11. MENU MOBILE TERTUTUP SETELAH KLIK
       ================================================================ */
    function initMobileNav() {
        var nav = document.getElementById('navMenu');
        if (!nav) return;
        nav.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () {
                if (nav.classList.contains('show') && window.bootstrap) {
                    var bs = bootstrap.Collapse.getInstance(nav);
                    if (bs) bs.hide();
                }
            });
        });
    }

    /* ================================================================
       12. LIGHTBOX GALERI
       ================================================================ */
    function initLightbox() {
        var lightbox = document.getElementById('galleryLightbox');
        var lbImg = document.getElementById('galleryLightboxImg');
        var lbCap = document.getElementById('galleryLightboxCaption');
        document.querySelectorAll('[data-lightbox]').forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                if (lbImg) lbImg.src = a.href;
                if (lbCap) lbCap.textContent = a.getAttribute('data-caption') || '';
                var m = lightbox && window.bootstrap ? bootstrap.Modal.getOrCreateInstance(lightbox) : null;
                if (m) m.show();
            });
        });
    }

    /* ================================================================
       13. TAHUN FOOTER (fallback)
       ================================================================ */
    function initFooterYear() {
        var fy = document.getElementById('footerYear');
        if (fy) fy.textContent = new Date().getFullYear();
    }
})();
