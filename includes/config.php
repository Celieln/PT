<?php
/* ============================================================
 * KONFIGURASI SITUS COMPANY PROFILE PT
 * Ubah semua data di bawah ini sesuai perusahaan Anda.
 * ============================================================ */

/* Identitas perusahaan */
define('PT_NAMA',    'PT. NAMA PERUSAHAAN');      // Nama PT (kosongkan/hapus "PT." jika belum tentu)
define('PT_SINGKAT', 'NAMA PERUSAHAAN');
define('PT_TAGLINE', 'Trading, Distribusi & Supplier Produk Pangan Berkualitas');
define('PT_DESKRIPSI', 'Perusahaan kami bergerak di bidang perdagangan, distribusi dan pemasaran produk pangan segar serta produk olahan berkualitas untuk pasar lokal dan internasional.');

/* Kontak */
define('PT_ALAMAT',  'Jl. Contoh Raya No. 123, Kel. Contoh, Kec. Contoh, Kota Bandung, Jawa Barat');
define('PT_TELP',    '+62 812-3456-7890');
define('PT_WA',      '6281234567890');            // tanpa +62 / 0, untuk link wa.me
define('PT_EMAIL',   'info@perusahaan.co.id');
define('PT_JAM',     'Senin - Sabtu: 08.00 - 17.00 WIB');

/* Alamat sosial media (biarkan kosong jika belum ada) */
define('PT_FB',  '');
define('PT_IG',  '');
define('PT_WEB', '');

/* Peta Google Maps embed (opsional, isi src iframe) */
define('PT_MAPS_SRC', '');

/* Tahun berjalan untuk copyright */
define('PT_TAHUN', date('Y'));

/* Aset: hitung path web root situs dari lokasi file ini (folder includes/) */
$__ptRoot = dirname(__DIR__);
$__ptDoc  = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/\\'));
$__ptWeb  = str_replace('\\', '/', $__ptRoot);
if (strpos($__ptWeb, $__ptDoc) === 0) {
    define('BASE_URL', rtrim(substr($__ptWeb, strlen($__ptDoc)), '/'));
} else {
    define('BASE_URL', '');
}
unset($__ptRoot, $__ptDoc, $__ptWeb);
