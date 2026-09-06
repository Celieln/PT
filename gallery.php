<?php
$activePage = 'gallery';
$pageTitle  = 'Galeri';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/content.php';
include __DIR__ . '/includes/header.php';

$gal = pt_data('gallery');
?>

<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb-custom"><a href="<?= pt_url() ?>">Home</a><span class="sep">/</span>Galeri</nav>
        <h1 class="mt-2 mb-0">Galeri <span style="color:var(--accent)">Kegiatan</span></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-eyebrow">Dokumentasi</div>
            <h2 class="section-title mt-2">Momen & Kegiatan Kami</h2>
            <p class="section-sub mx-auto">Berikut dokumentasi produk, fasilitas, dan aktivitas operasional perusahaan.</p>
        </div>

        <div class="row g-4">
            <?php if (empty($gal)): ?>
                <div class="col-12 text-center text-muted py-5">Belum ada foto. Tambahkan lewat panel admin.</div>
            <?php endif; ?>
            <?php foreach ($gal as $gi => $g): ?>
                <div class="col-md-4 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($gi % 3) * 80 ?>">
                    <a class="gallery-item" href="<?= pt_img($g['gambar'] ?? '') ?>" data-lightbox data-caption="<?= pt_e($g['caption'] ?? '') ?>">
                        <img src="<?= pt_img($g['gambar'] ?? '') ?>" alt="<?= pt_e($g['caption'] ?? '') ?>" loading="lazy">
                        <span class="gallery-overlay"><span class="gallery-cap"><i class="bi bi-zoom-in me-1"></i><?= pt_e($g['caption'] ?? '') ?></span></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Modal lightbox galeri -->
<div class="modal fade" id="galleryLightbox" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-0">
            <div class="modal-body p-2 text-center">
                <img id="galleryLightboxImg" src="" alt="Gambar" class="img-fluid rounded-3" style="max-height:78vh;">
                <div id="galleryLightboxCaption" class="text-light small py-2"></div>
            </div>
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>