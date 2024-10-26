<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// $routes->view('example-page', 'tes');
$routes->get('tes', 'TesController::index');
$routes->get('testa', 'TesController::testa');

// ini di dalem grup biar dikasih filter yg udah login ga bisa ke sini
// atau bisa juga sih di controllernya kayak yg di CI Shield
$routes->group('/', [], function($routes){
    $routes->get('login', 'AuthController::loginView', ['as' => 'authLoginForm']);
    $routes->post('login', 'AuthController::loginAction', ['as' => 'authLoginAction']);
    $routes->get('daftar', 'AuthController::registerView', ['as' => 'authDaftarForm']);
    $routes->post('daftar', 'AuthController::registerAction', ['as' => 'authDaftarAction']);
});

$routes->group('grup', [], function($routes) {
    $routes->get('tambah', 'GrupController::new', ['as' => 'grupTambahForm']);
    $routes->post('/', 'GrupController::create', ['as' => 'grupTambahAction']);
    $routes->get('/', 'GrupController::index', ['as' => 'grupIndex']);
    $routes->get('(:num)', 'GrupController::show/$1', ['as' => 'grupRincian']);
    $routes->get('(:num)/ubah', 'GrupController::edit/$1', ['as' => 'grupUbahForm']);
    $routes->put('(:num)', 'GrupController::update/$1', ['as' => 'grupUbahAction']);
    $routes->delete('(:num)', 'GrupController::delete/$1', ['as' => 'grupHapus']);
});

$routes->group('pengguna', [], function($routes) {
    $routes->get('tambah', 'PenggunaController::new', ['as' => 'penggunaTambahForm']);
    $routes->post('/', 'PenggunaController::create', ['as' => 'penggunaTambahAction']);
    $routes->get('/', 'PenggunaController::index', ['as' => 'penggunaIndex']);
    $routes->get('(:segment)', 'PenggunaController::show/$1', ['as' => 'penggunaRincian']);
    $routes->get('(:segment)/ubah', 'PenggunaController::edit/$1', ['as' => 'penggunaUbahForm']);
    $routes->put('(:num)', 'PenggunaController::update/$1', ['as' => 'penggunaUbahAction']);
    $routes->delete('(:num)', 'PenggunaController::delete/$1', ['as' => 'penggunaHapus']);
});

$routes->group('kategori', [], function($routes) {
    $routes->get('tambah', 'KategoriController::new', ['as' => 'kategoriTambahForm']);
    $routes->post('/', 'KategoriController::create', ['as' => 'kategoriTambahAction']);
    $routes->get('/', 'KategoriController::index', ['as' => 'kategoriIndex']);
    $routes->get('(:segment)', 'KategoriController::show/$1', ['as' => 'kategoriRincian']);
    $routes->get('(:segment)/ubah', 'KategoriController::edit/$1', ['as' => 'kategoriUbahForm']);
    $routes->put('(:num)', 'KategoriController::update/$1', ['as' => 'kategoriUbahAction']);
    $routes->delete('(:num)', 'KategoriController::delete/$1', ['as' => 'kategoriHapus']);
});

// ini sekalian sama nomor seri kayaknya
$routes->group('buku', [], function($routes) {
    $routes->get('tambah', 'BukuController::new', ['as' => 'bukuTambahForm']);
    $routes->post('/', 'BukuController::create', ['as' => 'bukuTambahAction']);
    $routes->get('/', 'BukuController::index', ['as' => 'bukuIndex']);
    $routes->get('(:segment)', 'BukuController::show/$1', ['as' => 'bukuRincian']);
    $routes->get('(:segment)/ubah', 'BukuController::edit/$1', ['as' => 'bukuUbahForm']);
    $routes->put('(:num)', 'BukuController::update/$1', ['as' => 'bukuUbahAction']);
    $routes->delete('(:num)', 'BukuController::delete/$1', ['as' => 'bukuHapus']);
});

$routes->group('wishlist', [], function($routes) {
    $routes->get('tambah', 'WishlistController::new', ['as' => 'wishlistTambahForm']);
    $routes->post('/', 'WishlistController::create', ['as' => 'wishlistTambahAction']);
    $routes->get('/', 'WishlistController::index', ['as' => 'wishlistIndex']);
    $routes->get('(:segment)', 'WishlistController::show/$1', ['as' => 'wishlistRincian']);
    $routes->get('(:segment)/ubah', 'WishlistController::edit/$1', ['as' => 'wishlistUbahForm']);
    $routes->put('(:num)', 'WishlistController::update/$1', ['as' => 'wishlistUbahAction']);
    $routes->delete('(:num)', 'WishlistController::delete/$1', ['as' => 'wishlistHapus']);
});

$routes->group('peminjaman', [], function($routes) {
    $routes->get('tambah', 'PeminjamanController::new', ['as' => 'peminjamanTambahForm']);
    $routes->post('/', 'PeminjamanController::create', ['as' => 'peminjamanTambahAction']);
    $routes->get('/', 'PeminjamanController::index', ['as' => 'peminjamanIndex']);
    $routes->get('(:segment)', 'PeminjamanController::show/$1', ['as' => 'peminjamanRincian']);
    $routes->get('(:segment)/ubah', 'PeminjamanController::edit/$1', ['as' => 'peminjamanUbahForm']);
    $routes->put('(:num)', 'PeminjamanController::update/$1', ['as' => 'peminjamanUbahAction']);
    $routes->delete('(:num)', 'PeminjamanController::delete/$1', ['as' => 'peminjamanHapus']);
});