<?php
$activePage = 'news';
$pageTitle  = 'Berita';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/content.php';
include __DIR__ . '/includes/header.php';

$news = array_reverse(pt_data('news'));
?>

<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb-custom"><a href="<?= pt_url() ?>">Home</a><span class="sep">/</span>Berita</nav>
        <h1 class="mt-2 mb-0">Berita &amp; <span style="color:var(--accent)">Artikel</span></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($news)): ?>
            <div class="text-center text-muted py-5">Belum ada berita.</div>
        <?php endif; ?>
        <div class="row g-4">
            <?php foreach ($news as $nid => $n): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="product-card d-flex flex-column">
                        <div class="img-wrap">
                            <img src="<?= pt_img($n['gambar'] ?? '') ?>" alt="<?= pt_e($n['judul'] ?? '') ?>" loading="lazy">
                            <span class="img-tag"><?= pt_tgl_id($n['tanggal'] ?? '') ?></span>
                        </div>
                        <div class="product-body flex-grow-1 d-flex flex-column">
                            <h5><?= pt_e($n['judul'] ?? '') ?></h5>
                            <p><?= pt_e(mb_substr($n['isi'] ?? '', 0, 120)) ?>...</p>
                            <div class="mt-auto">
                                <a href="#news<?= $nid ?>" class="btn-link-sm" data-bs-toggle="modal" data-bs-target="#newsModal<?= $nid ?>">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="newsModal<?= $nid ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <div class="cat text-uppercase small fw-bold" style="color:var(--accent-dark)"><?= pt_tgl_id($n['tanggal'] ?? '') ?></div>
                                    <h5 class="modal-title fw-bold"><?= pt_e($n['judul'] ?? '') ?></h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?= pt_img($n['gambar'] ?? '') ?>" class="img-fluid rounded-3 mb-3 w-100" style="max-height:320px;object-fit:cover;" alt="">
                                <p style="white-space:pre-line"><?= pt_e($n['isi'] ?? '') ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-brand" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>