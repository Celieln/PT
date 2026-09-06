<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/content.php';

$menu = [
    'index'    => ['Home',    pt_url()],
    'about'    => ['About',   pt_url('about.php')],
    'products' => ['Produk',  pt_url('products.php')],
    'gallery'  => ['Galeri',  pt_url('gallery.php')],
    'news'     => ['Berita',  pt_url('news.php')],
    'contact'  => ['Kontak',  pt_url('contact.php')],
];
$active = isset($activePage) ? $activePage : 'index';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= pt_e(pt_setting("deskripsi")) ?>">
    <title><?= htmlspecialchars($pageTitle ?? 'Home', ENT_QUOTES) ?> | <?= pt_e(pt_setting("nama")) ?></title>

    <link rel="icon" href="<?= pt_assets('img/logo.svg') ?>" type="image/svg+xml">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php if ($pageTitle === 'Home'): ?>
    <link rel="preload" as="image" href="<?= pt_assets('img/foto/hero.jpg') ?>" fetchpriority="high">
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= pt_assets('css/style.css') ?>">
    <script>document.documentElement.classList.add('js');</script>
</head>
<body id="top">

<!-- Dekorasi latar: mesh gradien + blob -->
<div class="bg-blobs" aria-hidden="true"><span class="blob-1"></span><span class="blob-2"></span><span class="blob-3"></span></div>

<!-- Preloader -->
<div class="preloader" id="preloader">
    <div class="preloader-inner">
        <div class="preloader-ring">
            <div class="preloader-logo"><img src="<?= pt_assets('img/logo.svg') ?>" alt="Logo" width="46" height="46"></div>
        </div>
        <div class="preloader-brand"><?= pt_e(pt_setting('singkat')) ?></div>
        <div class="preloader-pct" id="preloaderPct">0%</div>
    </div>
</div>

<!-- Tirai transisi antar halaman -->
<div class="page-transition" id="pageTransition" aria-hidden="true">
    <div class="pt-overlay"></div>
    <div class="pt-center">
        <div class="pt-logo"><img src="<?= pt_assets('img/logo.svg') ?>" alt="Logo"><span><?= pt_e(pt_setting('singkat')) ?></span></div>
        <div class="pt-bar"><span></span></div>
        <div class="pt-label">Memuat Halaman</div>
    </div>
</div>

<!-- Scroll progress bar -->
<div class="scroll-progress" id="scrollProgress"></div>

<!-- ===== Topbar ===== -->
<div class="topbar d-none d-lg-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="topbar-left d-flex gap-4">
            <span><i class="bi bi-telephone-fill"></i> <?= pt_e(pt_setting("telp")) ?></span>
            <span><i class="bi bi-envelope-fill"></i> <?= pt_e(pt_setting("email")) ?></span>
        </div>
        <div class="topbar-right">
            <span><i class="bi bi-clock-fill"></i> <?= pt_e(pt_setting("jam")) ?></span>
        </div>
    </div>
</div>

<!-- ===== Navbar ===== -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= pt_url() ?>">
            <img src="<?= pt_assets('img/logo.svg') ?>" alt="Logo" width="42" height="42">
            <span class="brand-text"><?= pt_e(pt_setting("singkat")) ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <?php foreach ($menu as $key => $m): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $active === $key ? 'active' : '' ?>" href="<?= $m[1] ?>"><?= htmlspecialchars($m[0]) ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-brand btn-sm px-3 py-2" href="<?= pt_url('contact.php') ?>">Hubungi Kami</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Tombol kembali ke atas -->
<button class="to-top" id="toTop" aria-label="Kembali ke atas"><i class="bi bi-chevron-up"></i></button>
