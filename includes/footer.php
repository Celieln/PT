    <!-- ===== Footer ===== -->
    <footer class="site-footer pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="<?= pt_assets('img/logo.svg') ?>" alt="Logo" width="44" height="44" class="bg-white rounded-3 p-1">
                        <span class="fw-bold fs-5 text-white" style="font-family:var(--font-head);"><?= pt_e(pt_setting('singkat')) ?></span>
                    </div>
                    <p class="footer-text"><?= pt_e(pt_setting('deskripsi')) ?></p>
                    <div class="d-flex gap-2 mt-3">
                        <?php if (pt_setting('fb') !== ''): ?><a class="soc-icon" href="<?= pt_e(pt_setting('fb')) ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a><?php endif; ?>
                        <?php if (pt_setting('ig') !== ''): ?><a class="soc-icon" href="<?= pt_e(pt_setting('ig')) ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a><?php endif; ?>
                        <?php if (pt_setting('wa') !== ''): ?><a class="soc-icon" href="https://wa.me/<?= pt_e(pt_setting('wa')) ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a><?php endif; ?>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="footer-head">Menu</h6>
                    <ul class="footer-links list-unstyled">
                        <li><a href="<?= pt_url() ?>">Home</a></li>
                        <li><a href="<?= pt_url('about.php') ?>">About</a></li>
                        <li><a href="<?= pt_url('products.php') ?>">Produk</a></li>
                        <li><a href="<?= pt_url('gallery.php') ?>">Galeri</a></li>
                        <li><a href="<?= pt_url('news.php') ?>">Berita</a></li>
                        <li><a href="<?= pt_url('contact.php') ?>">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h6 class="footer-head">Produk</h6>
                    <ul class="footer-links list-unstyled">
                        <li><a href="<?= pt_url('products.php') ?>#pangan">Produk Pangan Segar</a></li>
                        <li><a href="<?= pt_url('products.php') ?>#olahan">Produk Olahan</a></li>
                        <li><a href="<?= pt_url('products.php') ?>#distribusi">Jasa Distribusi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="footer-head">Kontak</h6>
                    <ul class="list-unstyled footer-contact">
                        <li><i class="bi bi-geo-alt-fill"></i> <?= pt_e(pt_setting('alamat')) ?></li>
                        <li><i class="bi bi-telephone-fill"></i> <?= pt_e(pt_setting('telp')) ?></li>
                        <li><i class="bi bi-envelope-fill"></i> <?= pt_e(pt_setting('email')) ?></li>
                    </ul>
                    <a href="<?= pt_url('contact.php') ?>" class="btn btn-accent btn-sm mt-2 px-3">Kirim Pesan</a>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="row align-items-center footer-bottom">
                <div class="col-md-6 text-center text-md-start">&copy; <?= PT_TAHUN ?> <?= pt_e(pt_setting('nama')) ?>. Hak cipta dilindungi.</div>
                <div class="col-md-6 text-center text-md-end">Dibuat dengan <i class="bi bi-heart-fill text-danger"></i> untuk layanan terbaik</div>
            </div>
        </div>
    </footer>

    <!-- Tombol WhatsApp mengambang -->
    <?php if (pt_setting('wa') !== ''): ?>
    <a class="wa-float" href="https://wa.me/<?= pt_e(pt_setting('wa')) ?>?text=Halo%2C%20saya%20ingin%20bertanya" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= pt_assets('js/main.js') ?>"></script>

    <!-- Kursor bintang (sparkle emas) -->
    <div class="cursor-tani" id="kursorTani" aria-hidden="true"><span class="bintang"></span></div>
    <script>
    (function () {
        if (window.matchMedia('(max-width:768px)').matches) return;
        var k = document.getElementById('kursorTani'), n = 0, raf = null;
        var tx = -100, ty = -100, x = tx, y = ty;
        k.style.transform = 'translate3d(-100px,-100px,0)';
        function loop() {
            x += (tx - x) * 0.24;
            y += (ty - y) * 0.24;
            k.style.transform = 'translate3d(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px,0)';
            if (Math.abs(tx - x) > 0.4 || Math.abs(ty - y) > 0.4) raf = requestAnimationFrame(loop);
            else raf = null;
        }
        document.addEventListener('mousemove', function (e) {
            tx = e.clientX; ty = e.clientY;
            if (!raf) raf = requestAnimationFrame(loop);
            n++;
            if (n % 3 === 0) {
                var s = document.createElement('span'); s.className = 'kilau';
                s.style.setProperty('--dx', (Math.random() * 20 - 10) + 'px');
                s.style.setProperty('--dy', (Math.random() * -25 - 8) + 'px');
                k.appendChild(s); setTimeout(function () { s.remove(); }, 1300);
            }
            if (n % 7 === 0) {
                var c = document.createElement('span'); c.className = 'cincin';
                k.appendChild(c); setTimeout(function () { c.remove(); }, 1100);
            }
        });
    })();
    </script>
</body>
</html>
