<?php
/**
 * Helper baca konten dari data store (JSON) dengan cache per-request.
 * Semua data yang bisa diedit lewat admin panel dibaca dari sini.
 */

function pt_data_dir() {
    return __DIR__ . '/../data';
}

function pt_data_path($file) {
    return pt_data_dir() . '/' . $file . '.json';
}

/* Cache konten dalam satu request agar file hanya dibaca sekali */
$GLOBALS['_pt_cache'] = [];

function pt_data($file) {
    if (isset($GLOBALS['_pt_cache'][$file])) {
        return $GLOBALS['_pt_cache'][$file];
    }
    $path = pt_data_path($file);
    $data = [];
    if (is_file($path)) {
        $raw = file_get_contents($path);
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $data = $decoded;
        }
    }
    $GLOBALS['_pt_cache'][$file] = $data;
    return $data;
}

/* Simpan data kembali ke JSON */
function pt_data_save($file, $data) {
    $path = pt_data_path($file);
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if (file_put_contents($path, $json) === false) {
        return false;
    }
    $GLOBALS['_pt_cache'][$file] = $data;
    return true;
}

/* URL relatif situs */
function pt_url($path = '') {
    $base = rtrim(BASE_URL, '/');
    return ($base === '' ? '' : $base) . '/' . ltrim($path, '/');
}

function pt_assets($path = '') {
    return pt_url('assets/' . ltrim($path, '/'));
}

/* Baca satu setting; fallback ke konstanta PT_* jika tidak ada di JSON */
function pt_setting($key, $fallback = '') {
    $s = pt_data('settings');
    if (isset($s[$key]) && $s[$key] !== '') {
        return $s[$key];
    }
    if ($fallback === '' && defined('PT_' . strtoupper($key))) {
        return constant('PT_' . strtoupper($key));
    }
    return $fallback;
}

/* Escaping ringkas untuk output HTML */
function pt_e($v) {
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/* Folder upload fisik & URL-nya */
function pt_upload_dir() {
    return __DIR__ . '/../assets/uploads';
}
function pt_upload_url($name = '') {
    return pt_url('assets/uploads/' . ltrim($name, '/'));
}

/* Ambil URL gambar: cek folder uploads terlebih dahulu, lalu folder img/ */
function pt_img($name) {
    $name = ltrim((string) $name, '/');
    if ($name === '') return pt_url('assets/img/produk-1.svg');
    if (is_file(pt_upload_dir() . '/' . $name)) {
        return pt_upload_url($name);
    }
    return pt_assets('img/' . $name);
}

/* Format tanggal Indonesia */
function pt_tgl_id($date) {
    if (!$date) return '-';
    $t = strtotime($date);
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bln  = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $hari[(int)date('w', $t)] . ', ' . date('j', $t) . ' ' . $bln[(int)date('n', $t)] . ' ' . date('Y', $t);
}
