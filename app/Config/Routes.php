<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// halaman utama
$routes->get('/', 'HomeController::index', ['as' => 'index']);
$routes->get('buku/(:segment)', 'BukuController::show/$1', ['as' => 'bukuRincian']);

// Nambah wishlist dari halaman rincian buku (halaman utama)
$routes->post('buku/(:segment)', 'HomeController::tambahWishlist/$1', ['as' => 'bukuRincianWishlist', 'filter' => 'grup']);

// ini di dalem grup biar dikasih filter yg udah login ga bisa ke sini
// atau bisa juga sih di controllernya kayak yg di CI Shield
$routes->group('/', ['filter' => 'masuk'], function($routes) {
    $routes->get('login', 'AuthController::loginView', ['as' => 'authLoginForm']);
    $routes->post('login', 'AuthController::loginAction', ['as' => 'authLoginAction']);
    $routes->get('daftar/(:segment)', 'PenggunaController::new/$1', ['as' => 'authDaftarForm']);
    $routes->post('daftar/(:segment)', 'PenggunaController::create/$1', ['as' => 'authDaftarAction']);
});

$routes->group('profil', ['filter' => 'grup'], function($routes) {
    // Filter biar yang belum login ga bisa logout. Soalnya di logout ada destroy() semua session.
    $routes->get('logout', 'AuthController::logout', ['as' => 'authLogout']);

    $routes->get('(:segment)', 'PenggunaController::show/$1', ['as' => 'profilRincian']);
    $routes->get('(:segment)/ubah', 'PenggunaController::edit/$1', ['as' => 'profilUbahForm']);
    $routes->put('(:num)', 'PenggunaController::update/$1', ['as' => 'profilUbahAction']);
    $routes->get('(:segment)/wishlist', 'PenggunaController::wishlist/$1', ['as' => 'profilWishlist']);
    $routes->get('(:segment)/peminjaman/(:segment)', 'PenggunaController::peminjamanRinci/$1/$2', ['as' => 'profilPeminjamanRinci']);
});

$routes->group('grup', ['filter' => 'grup:Admin'], function($routes) {
    $routes->get('tambah', 'GrupController::new', ['as' => 'grupTambahForm']);
    $routes->post('/', 'GrupController::create', ['as' => 'grupTambahAction']);
    $routes->get('/', 'GrupController::index', ['as' => 'grupIndex']);
    $routes->get('(:num)', 'GrupController::show/$1', ['as' => 'grupRincian']);
    $routes->get('(:num)/ubah', 'GrupController::edit/$1', ['as' => 'grupUbahForm']);
    $routes->put('(:num)', 'GrupController::update/$1', ['as' => 'grupUbahAction']);
    $routes->delete('(:num)', 'GrupController::delete/$1', ['as' => 'grupHapus']);
});

$routes->group('pengguna', ['filter' => 'grup:Admin, Pegawai'], function($routes) {
    $routes->get('tambah/(:segment)', 'PenggunaController::new/$1', ['as' => 'penggunaTambahForm']);
    $routes->post('(:segment)', 'PenggunaController::create/$1', ['as' => 'penggunaTambahAction']);
    $routes->get('/', 'PenggunaController::index', ['as' => 'penggunaIndex']);
    $routes->get('(:segment)', 'PenggunaController::show/$1', ['as' => 'penggunaRincian']);
    $routes->get('(:segment)/wishlist', 'PenggunaController::wishlist/$1', ['as' => 'penggunaWishlist']);
    $routes->put('(:segment)/wishlist', 'PenggunaController::updateWishlist/', ['as' => 'penggunaUbahWishlist']);
    $routes->get('(:segment)/ubah', 'PenggunaController::edit/$1', ['as' => 'penggunaUbahForm']);
    $routes->put('(:num)', 'PenggunaController::update/$1', ['as' => 'penggunaUbahAction']);
    $routes->delete('(:num)', 'PenggunaController::delete/$1', ['as' => 'penggunaHapus']);
});

$routes->group('kategori', ['filter' => 'grup:Admin, Pegawai'], function($routes) {
    $routes->get('tambah', 'KategoriController::new', ['as' => 'kategoriTambahForm']);
    $routes->post('/', 'KategoriController::create', ['as' => 'kategoriTambahAction']);
    $routes->get('/', 'KategoriController::index', ['as' => 'kategoriIndex']);
    $routes->get('(:segment)', 'KategoriController::show/$1', ['as' => 'kategoriRincian']);
    $routes->get('(:segment)/ubah', 'KategoriController::edit/$1', ['as' => 'kategoriUbahForm']);
    $routes->put('(:num)', 'KategoriController::update/$1', ['as' => 'kategoriUbahAction']);
    $routes->delete('(:num)', 'KategoriController::delete/$1', ['as' => 'kategoriHapus']);
});

// Ini tampilan buku & nomor seri mode CRUD
$routes->group('data', ['filter' => 'grup:Admin, Pegawai'], function($routes) {
    $routes->get('buku/tambah', 'BukuController::new', ['as' => 'adminBukuTambahForm']);
    $routes->post('buku', 'BukuController::create', ['as' => 'adminBukuTambahAction']);
    $routes->get('buku', 'BukuController::index', ['as' => 'adminBukuIndex']);
    $routes->get('buku/(:segment)', 'BukuController::show/$1', ['as' => 'adminBukuRincian']);
    $routes->get('buku/(:segment)/ubah', 'BukuController::edit/$1', ['as' => 'adminBukuUbahForm']);
    $routes->put('buku/(:num)', 'BukuController::update/$1', ['as' => 'adminBukuUbahAction']);
    $routes->delete('buku/(:num)', 'BukuController::delete/$1', ['as' => 'adminBukuHapus']);
    
    // sebelah tombol cari ada dropdown buat statusnya
    $routes->get('label/tambah', 'NomorSeriController::new', ['as' => 'nomorSeriTambahForm']);
    $routes->post('label', 'NomorSeriController::create', ['as' => 'nomorSeriTambahAction']);
    $routes->get('label', 'NomorSeriController::index', ['as' => 'nomorSeriIndex']);
    $routes->get('label/(:segment)', 'NomorSeriController::show/$1', ['as' => 'nomorSeriRincian']);
    $routes->get('label/(:segment)/ubah', 'NomorSeriController::edit/$1', ['as' => 'nomorSeriUbahForm']);
    $routes->put('label/(:num)', 'NomorSeriController::update/$1', ['as' => 'nomorSeriUbahAction']);
    $routes->delete('label/(:num)', 'NomorSeriController::delete/$1', ['as' => 'nomorSeriHapus']);
});


$routes->group('wishlist', ['filter' => 'grup:Admin, Pegawai'], function($routes) {
    $routes->get('tambah', 'WishlistController::new', ['as' => 'wishlistTambahForm']);
    $routes->post('/', 'WishlistController::create', ['as' => 'wishlistTambahAction']);
    $routes->get('/', 'WishlistController::index', ['as' => 'wishlistIndex']);
    $routes->get('(:num)', 'WishlistController::show/$1', ['as' => 'wishlistRincian']);
    $routes->get('(:num)/ubah', 'WishlistController::edit/$1', ['as' => 'wishlistUbahForm']);
    $routes->put('(:num)', 'WishlistController::update/$1', ['as' => 'wishlistUbahAction']);
    $routes->delete('(:num)', 'WishlistController::delete/$1', ['as' => 'wishlistHapus']);
});

$routes->group('peminjaman', ['filter' => 'grup:Admin, Pegawai'], function($routes) {
    $routes->get('tambah', 'PeminjamanController::new', ['as' => 'peminjamanTambahForm']);
    $routes->post('/', 'PeminjamanController::create', ['as' => 'peminjamanTambahAction']);
    $routes->get('/', 'PeminjamanController::index', ['as' => 'peminjamanIndex']);
    $routes->get('(:segment)', 'PeminjamanController::show/$1', ['as' => 'peminjamanRincian']);
    $routes->get('(:segment)/ubah', 'PeminjamanController::edit/$1', ['as' => 'peminjamanUbahForm']);
    $routes->put('(:num)', 'PeminjamanController::update/$1', ['as' => 'peminjamanUbahAction']);
    $routes->delete('(:num)', 'PeminjamanController::delete/$1', ['as' => 'peminjamanHapus']);
    $routes->get('struk/(:segment)', 'LaporanController::strukPeminjaman/$1', ['as' => 'peminjamanCetakStruk']);
});