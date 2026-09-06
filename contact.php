<?php
$activePage = 'contact';
$pageTitle  = 'Kontak';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/content.php';
include __DIR__ . '/includes/header.php';

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = trim($_POST['nama'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subjek  = trim($_POST['subjek'] ?? '');
    $isi     = trim($_POST['pesan'] ?? '');

    if ($nama === '' || $email === '' || $isi === '') {
        $pesan = '<div class="alert alert-danger">Mohon isi nama, email, dan pesan Anda.</div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pesan = '<div class="alert alert-danger">Format email tidak valid.</div>';
    } else {
        /* Simpan pesan ke data store agar terbaca di panel admin */
        $msgs   = pt_data('messages');
        $msgs[] = [
            'nama'   => $nama,
            'email'  => $email,
            'subjek' => $subjek !== '' ? $subjek : '(tanpa subjek)',
            'pesan'  => $isi,
            'waktu'  => date('Y-m-d H:i:s'),
            'baca'   => false,
        ];
        pt_data_save('messages', $msgs);
        $pesan = '<div class="alert alert-success">Terima kasih, pesan Anda telah kami terima. Tim kami akan segera menghubungi Anda.</div>';
    }
}
?>

<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb-custom"><a href="<?= pt_url() ?>">Home</a><span class="sep">/</span>Kontak</nav>
        <h1 class="mt-2 mb-0">Hubungi <span style="color:var(--accent)">Kami</span></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-5">
            <!-- Info kontak -->
            <div class="col-lg-5" data-aos="fade-up">
                <div class="section-eyebrow">Kontak Kami</div>
                <h2 class="section-title mt-2">Mari Berbincang</h2>
                <p class="section-sub mb-4">Tim kami siap membantu menjawab pertanyaan Anda.</p>

                <div class="card-soft p-4">
                    <div class="contact-item">
                        <div class="contact-icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <h6>Alamat</h6>
                            <p><?= pt_e(pt_setting('alamat')) ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="bi bi-telephone"></i></div>
                        <div>
                            <h6>Telepon</h6>
                            <p><a href="tel:<?= pt_e(preg_replace('/[^0-9+]/', '', pt_setting('telp'))) ?>" class="text-decoration-none text-reset"><?= pt_e(pt_setting('telp')) ?></a></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="bi bi-envelope"></i></div>
                        <div>
                            <h6>Email</h6>
                            <p><a href="mailto:<?= pt_e(pt_setting('email')) ?>" class="text-decoration-none text-reset"><?= pt_e(pt_setting('email')) ?></a></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="bi bi-clock"></i></div>
                        <div>
                            <h6>Jam Operasional</h6>
                            <p><?= pt_e(pt_setting('jam')) ?></p>
                        </div>
                    </div>
                </div>

                <?php if (pt_setting('wa') !== ''): ?>
                <a class="btn btn-brand w-100 mt-3 py-2" href="https://wa.me/<?= pt_e(pt_setting('wa')) ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-2"></i>Chat WhatsApp</a>
                <?php endif; ?>
            </div>

            <!-- Form -->
            <div class="col-lg-7" data-aos="fade-up">
                <div class="card-soft p-4 p-lg-5">
                    <h4 class="fw-bold mb-1">Kirim Pesan</h4>
                    <p class="text-muted mb-4">Isi form berikut dan kami akan merespons secepatnya.</p>
                    <?= $pesan ?>
                    <form method="post" action="<?= pt_url('contact.php') ?>" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" required placeholder="Nama Anda">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required placeholder="email@contoh.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Subjek</label>
                                <input type="text" class="form-control" name="subjek" placeholder="Subjek pesan">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Pesan <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="pesan" rows="6" required placeholder="Tulis pesan Anda..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-brand btn-lg w-100 py-2"><i class="bi bi-send me-2"></i>Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        $mapSrc = trim((string) pt_setting('maps'));
        if ($mapSrc === '') {
            $mapSrc = 'https://maps.google.com/maps?q=' . rawurlencode((string) pt_setting('alamat')) . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
        }
        $mapLink = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode((string) pt_setting('alamat'));
        ?>
        <div class="mt-5" data-aos="fade-up">
            <div class="map-wrap rounded-4 overflow-hidden shadow-sm">
                <iframe src="<?= pt_e($mapSrc) ?>" title="Lokasi" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <a class="map-open" href="<?= pt_e($mapLink) ?>" target="_blank" rel="noopener"><i class="bi bi-geo-alt-fill me-2"></i>Buka di Google Maps</a>
            </div>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section section-soft pt-0">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-eyebrow centered">FAQ</div>
            <h2 class="section-title mt-2">Pertanyaan yang Sering Diajukan</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAcc">
                    <?php
                    $faqs = [
                        ['Apakah ada minimal pemesanan?', 'Minimal pemesanan disesuaikan dengan jenis produk dan rute pengiriman. Silakan hubungi tim kami untuk informasi lengkapnya.'],
                        ['Bagaimana sistem pengiriman produk?', 'Kami melayani pengiriman ke berbagai kota dengan armada terjadwal dan menjaga kesegaran produk selama perjalanan.'],
                        ['Apakah bisa bekerja sama dalam jangka panjang?', 'Tentu. Kami membuka peluang kemitraan rutin untuk hotel, restoran, katering, hingga distributor dengan harga khusus.'],
                        ['Metode pembayaran apa saja yang tersedia?', 'Kami mendukung transfer bank, dan dapat dibicarakan sesuai kesepakatan kerja sama.'],
                    ];
                    ?>
                    <?php foreach ($faqs as $fi => $f): ?>
                        <div class="accordion-item faq-item" data-aos="fade-up" data-aos-delay="<?= $fi * 60 ?>">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $fi > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $fi ?>" aria-expanded="<?= $fi === 0 ? 'true' : 'false' ?>">
                                    <?= pt_e($f[0]) ?>
                                </button>
                            </h2>
                            <div id="faq<?= $fi ?>" class="accordion-collapse collapse <?= $fi === 0 ? 'show' : '' ?>" data-bs-parent="#faqAcc">
                                <div class="accordion-body"><?= pt_e($f[1]) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>