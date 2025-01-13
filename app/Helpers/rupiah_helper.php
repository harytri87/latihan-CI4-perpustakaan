<?php

if (!function_exists('formatRupiah')) {
  function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
  }
}

if (!function_exists('formatRupiahKalimat')) {
  function formatRupiahKalimat($kalimat) {
    return preg_replace_callback('/\b\d+\b/', function ($matches) {
      return formatRupiah($matches[0]);
    }, $kalimat);
  }
}