<?php
$activePage = 'index';
$pageTitle  = 'Home';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/content.php';
include __DIR__ . '/includes/header.php';

$settings = pt_data('settings');
$stats    = $settings['stats'] ?? [];
$feats    = $settings['keunggulan'] ?? [];
$mitra    = $settings['mitra'] ?? [];
$testi    = $settings['testimoni'] ?? [];
$catas    = pt_data('products');
?>

<!-- ===== MARQUEE MITRA (di atas hero) ===== -->
<?php if (!empty($mitra)): ?>
<div class="marquee-wrap">
    <div class="marquee-track">
        <?php for ($i = 0; $i < 2; $i++): ?>
            <?php foreach ($mitra as $m): ?>
                <div class="marquee-item"><i class="bi bi-building-check me-2"></i><?= pt_e($m) ?></div>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>
<?php endif; ?>

<!-- ===== HERO ===== -->
<section class="hero">
    <div class="hero-slides" aria-hidden="true">
        <div class="hero-bg is-active" style="background-image:url('<?= pt_assets('img/foto/hero.jpg') ?>');"></div>
        <div class="hero-bg" data-bg="<?= pt_assets('img/foto/gudang.jpg') ?>"></div>
        <div class="hero-bg" data-bg="<?= pt_assets('img/foto/p-eggs.jpg') ?>"></div>
        <div class="hero-bg" data-bg="<?= pt_assets('img/foto/p-ayam.jpg') ?>"></div>
    </div>
    <div class="hero-aurora" aria-hidden="true"><span class="aurora-1"></span><span class="aurora-2"></span><span class="aurora-3"></span></div>
    <div class="hero-slider-dots" id="heroDots" aria-hidden="true"></div>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="hero-badge" data-aos="fade-down"><i class="bi bi-award"></i> Perusahaan Terpercaya</span>
                <h1 class="mt-3" data-aos="fade-up" data-aos-delay="80">
                    <?= pt_e(pt_setting('tagline')) ?>
                </h1>
                <div class="hero-typer" data-aos="fade-up" data-aos-delay="150">
                    <span>Kami melayani</span>
                    <span class="typer-text" id="heroType" data-words='["Distribusi Bahan Pangan","Supplier Produk Segar","Layanan Tepat Waktu","Kemitraan Jangka Panjang","Produk Berkualitas Tinggi"]'></span><span class="type-cursor" aria-hidden="true"></span>
                </div>
                <p class="lead mt-3" data-aos="fade-up" data-aos-delay="200">
                    <?= pt_e(pt_setting('deskripsi')) ?> Kami melayani kebutuhan bisnis Anda dengan produk bermutu, harga bersaing, dan pengiriman tepat waktu.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4" data-aos="fade-up" data-aos-delay="280">
                    <a href="<?= pt_url('products.php') ?>" class="btn btn-accent btn-lg px-4"><i class="bi bi-box-seam me-2"></i>Lihat Produk</a>
                    <a href="<?= pt_url('contact.php') ?>" class="btn btn-outline-light-2 btn-lg px-4"><i class="bi bi-whatsapp me-2"></i>Hubungi Kami</a>
                </div>
                <div class="hero-strip mt-5" data-aos="fade-up" data-aos-delay="360">
                    <i class="bi bi-patch-check-fill"></i>
                    <span><strong>100% Terpercaya</strong> &middot; Tersertifikasi &amp; Standar Mutu Terjaga</span>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-visual" data-aos="zoom-in" data-aos-delay="200">
                    <div class="hero-card glass">
                        <div class="hero-card-top d-flex align-items-center gap-3">
                            <img src="<?= pt_assets('img/logo.svg') ?>" alt="Logo" width="56" height="56">
                            <div>
                                <div class="fw-bold text-white"><?= pt_e(pt_setting('singkat')) ?></div>
                                <div class="small text-white-50"><?= pt_e(pt_setting('jam')) ?></div>
                            </div>
                        </div>
                        <hr class="border-light my-3 opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-white-50">Omzet per bulan</div>
                                <div class="fs-4 fw-bold text-white">Rp 2,5 M+</div>
                            </div>
                            <div class="badge-up"><i class="bi bi-graph-up-arrow"></i> +18%</div>
                        </div>
                        <div class="hero-mini-stats row text-center mt-3 g-2">
                            <?php foreach (array_slice($stats, 0, 4) as $s): ?>
                                <div class="col-3">
                                    <div class="mini-num"><span data-count="<?= (int)($s['value'] ?? 0) ?>" data-suffix="<?= pt_e($s['suffix'] ?? '') ?>">0</span></div>
                                    <div class="mini-lbl"><?= pt_e($s['label'] ?? '') ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="hero-float-card"><i class="bi bi-truck"></i> Pengiriman Tepat Waktu</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== KEUNGGULAN ===== -->
<section class="section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-eyebrow centered">Mengapa Memilih Kami</div>
            <h2 class="section-title mt-2">Komitmen Kami untuk Anda</h2>
            <p class="section-sub mx-auto">Pelayanan terbaik adalah prioritas utama kami di setiap transaksi.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($feats as $fi => $f): ?>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $fi * 80 ?>">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi <?= pt_e($f['icon'] ?? 'bi-box-seam') ?>"></i></div>
                        <h5><?= pt_e($f['judul'] ?? '') ?></h5>
                        <p><?= pt_e($f['isi'] ?? '') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== TENTANG ===== -->
<section class="section section-soft">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-visual position-relative">
                    <img src="<?= pt_assets('img/foto/about.jpg') ?>" alt="Tentang Perusahaan" class="img-fluid rounded-4 shadow" loading="lazy" width="1200" height="798">
                    <div class="about-badge-card">
                        <div class="fs-3 fw-bold text-white">8+</div>
                        <div class="small text-white-50">Tahun<br>Pengalaman</div>
                    </div>
                    <div class="about-dots"></div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="section-eyebrow">Tentang Kami</div>
                <h2 class="section-title mt-2"><?= pt_e(pt_setting('nama')) ?></h2>
                <p class="mt-3"><?= pt_e(pt_setting('deskripsi')) ?></p>
                <p><?= pt_e(pt_setting('tentang')) ?></p>
                <div class="row g-3 mt-2">
                    <div class="col-sm-6">
                        <div class="about-stat-box"><div class="num"><span data-count="98" data-suffix="%">0</span></div><div class="small text-muted">Kepuasan Pelanggan</div></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="about-stat-box"><div class="num"><span data-count="120" data-suffix="+">0</span></div><div class="small text-muted">Produk Tersedia</div></div>
                    </div>
                </div>
                <a href="<?= pt_url('about.php') ?>" class="btn btn-brand mt-4 px-4">Selengkapnya <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATISTIK ===== -->
<section class="stats-band">
    <div class="container">
        <div class="row text-center g-4">
            <?php foreach ($stats as $s): ?>
                <div class="col-6 col-lg-3" data-aos="fade-up">
                    <div class="stat-cell">
                        <div class="stat-number"><span data-count="<?= (int)($s['value'] ?? 0) ?>" data-suffix="<?= pt_e($s['suffix'] ?? '') ?>">0</span></div>
                        <div class="stat-label mt-1"><?= pt_e($s['label'] ?? '') ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== PRODUK ===== -->
<section class="section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-eyebrow centered">Produk Kami</div>
            <h2 class="section-title mt-2">Apa yang Kami Tawarkan</h2>
            <p class="section-sub mx-auto">Beragam produk unggulan untuk memenuhi kebutuhan rumah tangga hingga industri.</p>
        </div>
        <div class="row g-4">
            <?php
            $i = 0;
            foreach ($catas as $kat) {
                foreach ($kat['produk'] ?? [] as $prod) {
                    if ($i >= 4) break 2; ?>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                        <div class="product-card">
                            <div class="img-wrap">
                                <img src="<?= pt_img($prod['gambar'] ?? '') ?>" alt="<?= pt_e($prod['nama'] ?? '') ?>" loading="lazy">
                                <span class="img-tag"><?= pt_e($kat['judul'] ?? '') ?></span>
                            </div>
                            <div class="product-body">
                                <h5><?= pt_e($prod['nama'] ?? '') ?></h5>
                                <p><?= pt_e($prod['isi'] ?? '') ?></p>
                                <a href="<?= pt_url('contact.php') ?>" class="btn-link-sm">Pesan Sekarang <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php $i++;
                }
            } ?>
        </div>
        <div class="text-center mt-5" data-aos="zoom-in">
            <a href="<?= pt_url('products.php') ?>" class="btn btn-brand px-4 py-2">Semua Produk <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

<!-- ===== TESTIMONI ===== -->
<?php if (!empty($testi)): ?>
<section class="section section-soft">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-eyebrow centered">Testimoni</div>
            <h2 class="section-title mt-2">Apa Kata Mitra Kami</h2>
            <p class="section-sub mx-auto">Kepercayaan mereka adalah motivasi kami untuk terus lebih baik.</p>
        </div>
        <div id="testiCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000" data-aos="fade-up">
            <div class="carousel-inner">
                <?php $chunks = array_chunk($testi, 3); ?>
                <?php foreach ($chunks as $ci => $chunk): ?>
                    <div class="carousel-item <?= $ci === 0 ? 'active' : '' ?>">
                        <div class="row g-4 justify-content-center">
                            <?php foreach ($chunk as $t): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="testimonial-card h-100">
                                        <span class="quote">&ldquo;</span>
                                        <div class="stars mb-2">
                                            <?php for ($b = 0; $b < (int)($t['bintang'] ?? 5); $b++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                                        </div>
                                        <blockquote class="mb-3">&ldquo;<?= pt_e($t['isi'] ?? '') ?>&rdquo;</blockquote>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar"><?= pt_e(mb_strtoupper(mb_substr($t['nama'] ?? 'X', 0, 1))) ?></div>
                                            <div>
                                                <div class="fw-bold"><?= pt_e($t['nama'] ?? '') ?></div>
                                                <div class="small text-muted"><?= pt_e($t['jabatan'] ?? '') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="carousel-indicators-custom">
                <?php foreach ($chunks as $ci => $_): ?>
                    <button type="button" data-bs-target="#testiCarousel" data-bs-slide-to="<?= $ci ?>" class="<?= $ci === 0 ? 'active' : '' ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ===== BERITA ===== -->
<section class="section">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4" data-aos="fade-up">
            <div>
                <div class="section-eyebrow">Berita & Artikel</div>
                <h2 class="section-title mt-1 mb-0">Informasi Terbaru</h2>
            </div>
            <a href="<?= pt_url('news.php') ?>" class="btn btn-brand btn-sm">Semua Berita</a>
        </div>
        <?php $news = pt_data('news'); ?>
        <div class="row g-4">
            <?php foreach (array_slice(array_reverse($news), 0, 3) as $ni => $n): ?>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $ni * 80 ?>">
                    <div class="product-card">
                        <div class="img-wrap">
                            <img src="<?= pt_img($n['gambar'] ?? '') ?>" alt="<?= pt_e($n['judul'] ?? '') ?>" loading="lazy">
                            <span class="img-tag"><?= pt_tgl_id($n['tanggal'] ?? '') ?></span>
                        </div>
                        <div class="product-body">
                            <h5><?= pt_e($n['judul'] ?? '') ?></h5>
                            <p><?= pt_e(mb_substr($n['isi'] ?? '', 0, 90)) ?>...</p>
                            <a href="<?= pt_url('news.php') ?>" class="btn-link-sm">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="section pt-0">
    <div class="container">
        <div class="cta-band" data-aos="zoom-in">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h3>Tertarik bekerja sama dengan kami?</h3>
                    <p class="mb-0">Hubungi tim kami untuk penawaran harga dan konsultasi kebutuhan produk.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?= pt_url('contact.php') ?>" class="btn btn-dark btn-lg px-4"><i class="bi bi-arrow-right-circle me-2"></i>Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>