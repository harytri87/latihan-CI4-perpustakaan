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
    $routes->get('new', 'GrupController::new', ['as' => 'grupTambahForm']);
    $routes->post('/', 'GrupController::create', ['as' => 'grupTambahAction']);
    $routes->get('/', 'GrupController::index', ['as' => 'grupIndex']);
    $routes->get('(:num)', 'GrupController::show/$1', ['as' => 'grupRincian']);
    $routes->get('(:num)/edit', 'GrupController::edit/$1', ['as' => 'grupUbahForm']);
    $routes->put('(:num)', 'GrupController::update/$1', ['as' => 'grupUbahAction']);
    $routes->delete('(:num)', 'GrupController::delete/$1', ['as' => 'grupHapus']);
});

$routes->group('pengguna', [], function($routes) {
    $routes->get('new', 'PenggunaController::new', ['as' => 'penggunaTambahForm']);
    $routes->post('/', 'PenggunaController::create', ['as' => 'penggunaTambahAction']);
    $routes->get('/', 'PpenggunaController::index', ['as' => 'penggunaIndex']);
    $routes->get('(:segment)', 'PenggunaController::show/$1', ['as' => 'penggunaRincian']);
    $routes->get('(:segment)/edit', 'PenggunaController::edit/$1', ['as' => 'penggunaUbahForm']);
    $routes->put('(:segment)', 'PenggunaController::update/$1', ['as' => 'penggunaUbahAction']);
    $routes->delete('(:segment)', 'PenggunaController::delete/$1', ['as' => 'penggunaHapus']);
});

$routes->group('kategori', [], function($routes) {
    $routes->get('new', 'KategoriController::new', ['as' => 'kategoriTambahForm']);
    $routes->post('/', 'KategoriController::create', ['as' => 'kategoriTambahAction']);
    $routes->get('/', 'PKategoriController::index', ['as' => 'kategoriIndex']);
    $routes->get('(:segment)', 'KategoriController::show/$1', ['as' => 'kategoriRincian']);
    $routes->get('(:segment)/edit', 'KategoriController::edit/$1', ['as' => 'kategoriUbahForm']);
    $routes->put('(:segment)', 'KategoriController::update/$1', ['as' => 'kategoriUbahAction']);
    $routes->delete('(:segment)', 'KategoriController::delete/$1', ['as' => 'kategoriHapus']);
});

// ini sekalian sama nomor seri kayaknya
$routes->group('buku', [], function($routes) {
    $routes->get('new', 'BukuController::new', ['as' => 'bukuTambahForm']);
    $routes->post('/', 'BukuController::create', ['as' => 'bukuTambahAction']);
    $routes->get('/', 'PBukuController::index', ['as' => 'bukuIndex']);
    $routes->get('(:segment)', 'BukuController::show/$1', ['as' => 'bukuRincian']);
    $routes->get('(:segment)/edit', 'BukuController::edit/$1', ['as' => 'bukuUbahForm']);
    $routes->put('(:segment)', 'BukuController::update/$1', ['as' => 'bukuUbahAction']);
    $routes->delete('(:segment)', 'BukuController::delete/$1', ['as' => 'bukuHapus']);
});

$routes->group('wishlist', [], function($routes) {
    $routes->get('new', 'WishlistController::new', ['as' => 'wishlistTambahForm']);
    $routes->post('/', 'WishlistController::create', ['as' => 'wishlistTambahAction']);
    $routes->get('/', 'PWishlistController::index', ['as' => 'wishlistIndex']);
    $routes->get('(:segment)', 'WishlistController::show/$1', ['as' => 'wishlistRincian']);
    $routes->get('(:segment)/edit', 'WishlistController::edit/$1', ['as' => 'wishlistUbahForm']);
    $routes->put('(:segment)', 'WishlistController::update/$1', ['as' => 'wishlistUbahAction']);
    $routes->delete('(:segment)', 'WishlistController::delete/$1', ['as' => 'wishlistHapus']);
});

$routes->group('peminjaman', [], function($routes) {
    $routes->get('new', 'PeminjamanController::new', ['as' => 'peminjamanTambahForm']);
    $routes->post('/', 'PeminjamanController::create', ['as' => 'peminjamanTambahAction']);
    $routes->get('/', 'PPeminjamanController::index', ['as' => 'peminjamanIndex']);
    $routes->get('(:segment)', 'PeminjamanController::show/$1', ['as' => 'peminjamanRincian']);
    $routes->get('(:segment)/edit', 'PeminjamanController::edit/$1', ['as' => 'peminjamanUbahForm']);
    $routes->put('(:segment)', 'PeminjamanController::update/$1', ['as' => 'peminjamanUbahAction']);
    $routes->delete('(:segment)', 'PeminjamanController::delete/$1', ['as' => 'peminjamanHapus']);
});