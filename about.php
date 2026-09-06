<?php
$activePage = 'about';
$pageTitle  = 'Tentang Kami';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/content.php';
include __DIR__ . '/includes/header.php';

$settings = pt_data('settings');
$values   = $settings['nilai'] ?? [];
?>

<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb-custom"><a href="<?= pt_url() ?>">Home</a><span class="sep">/</span>Tentang Kami</nav>
        <h1 class="mt-2 mb-0">Tentang <span style="color:var(--accent)">Kami</span></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-visual position-relative">
                    <img src="<?= pt_assets('img/foto/about.jpg') ?>" alt="Profil Perusahaan" class="img-fluid rounded-4 shadow" loading="lazy" width="1200" height="798">
                    <div class="about-badge-card">
                        <div class="fs-3 fw-bold text-white">8+</div>
                        <div class="small text-white-50">Tahun<br>Pengalaman</div>
                    </div>
                    <div class="about-dots"></div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="section-eyebrow">Siapa Kami</div>
                <h2 class="section-title mt-2"><?= pt_e(pt_setting('nama')) ?></h2>
                <p class="mt-3"><?= pt_e(pt_setting('deskripsi')) ?></p>
                <p><?= pt_e(pt_setting('tentang')) ?></p>
                <p class="mb-0">Kami terus berinovasi dan memperluas jaringan untuk memberikan layanan terbaik, dari produksi hingga distribusi.</p>

                <div class="row g-3 mt-4">
                    <div class="col-sm-6">
                        <div class="about-stat-box"><div class="num">100%</div><div class="small text-muted">Komitmen Mutu</div></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="about-stat-box"><div class="num">24/7</div><div class="small text-muted">Siap Melayani</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-soft">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-eyebrow centered">Nilai Kami</div>
            <h2 class="section-title mt-2">Prinsip yang Kami Pegang</h2>
            <p class="section-sub mx-auto">Empat nilai yang menjadi fondasi setiap keputusan dan layanan kami.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($values as $vi => $v): ?>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $vi * 80 ?>">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi <?= pt_e($v['icon'] ?? 'bi-heart') ?>"></i></div>
                        <h5><?= pt_e($v['judul'] ?? '') ?></h5>
                        <p><?= pt_e($v['isi'] ?? '') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>