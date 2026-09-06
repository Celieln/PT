<?php
$activePage = 'products';
$pageTitle  = 'Produk';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/content.php';
include __DIR__ . '/includes/header.php';

$catas = pt_data('products');
?>

<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb-custom"><a href="<?= pt_url() ?>">Home</a><span class="sep">/</span>Produk</nav>
        <h1 class="mt-2 mb-0">Produk <span style="color:var(--accent)">Kami</span></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php foreach ($catas as $k): ?>
            <div class="mb-5" id="<?= pt_e($k['kategori'] ?? '') ?>">
                <div data-aos="fade-up">
                    <div class="section-eyebrow">Kategori</div>
                    <h2 class="section-title mt-1 mb-1"><?= pt_e($k['judul'] ?? '') ?></h2>
                    <p class="section-sub mb-4"><?= pt_e($k['deskripsi'] ?? '') ?></p>
                </div>
                <div class="row g-4">
                    <?php foreach ($k['produk'] ?? [] as $it): ?>
                        <div class="col-md-6 col-lg-4" data-aos="fade-up">
                            <div class="product-card">
                                <div class="img-wrap">
                                    <img src="<?= pt_img($it['gambar'] ?? '') ?>" alt="<?= pt_e($it['nama'] ?? '') ?>" loading="lazy">
                                    <span class="img-tag"><?= pt_e($k['judul'] ?? '') ?></span>
                                </div>
                                <div class="product-body">
                                    <h5><?= pt_e($it['nama'] ?? '') ?></h5>
                                    <p><?= pt_e($it['isi'] ?? '') ?></p>
                                    <a href="<?= pt_url('contact.php') ?>" class="btn-link-sm">Pesan Sekarang <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="cta-band mt-4" data-aos="fade-up">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h3>Butuh produk tertentu?</h3>
                    <p class="mb-0">Kami siap membantu kebutuhan pengadaan Anda dengan harga terbaik.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?= pt_url('contact.php') ?>" class="btn btn-brand btn-lg px-4">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>