<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BukuModel;
use App\Models\WishlistModel;
use App\Models\NomorSeriModel;
use App\Models\PenggunaModel;

class HomeController extends BaseController
{
  public function index(): string
  {
    // Menampilkan semua data buku

    $nav_cari_keyword = $this->request->getVar('cari_buku');

    $bukuModel = new BukuModel();
    $data = [
      'buku_list'        => $bukuModel->getBuku($nav_cari_keyword),
      'pager'            => $bukuModel->pager,
      'title'            => 'Perpustakaan',
      'penomoran'        => 20,	// samain sama paginate() di model getBuku()
      'nav_cari_keyword' => $nav_cari_keyword
    ];

    return view('halaman/index', $data);
  }

  public function tambahWishlist($slug)
  {
    // Menambahkan wishlist dari halaman rincian buku di halaman utama
    $wishlistModel = new WishlistModel();
    $seriModel = new NomorSeriModel();
    $penggunaModel = new PenggunaModel();
    $dataPost = $this->request->getPost();
    $seri = $seriModel->satuISBNStatus($dataPost['isbn'], 'tersedia');
    $pengguna = $penggunaModel->getPengguna($dataPost['pengguna_username']);

    // Data yang bakal disimpen
    $data = [
      'seri_id' => $seri['seri_id'],
      'pengguna_id' => $pengguna['pengguna_id'],
      'status' => 'wishlist'
    ];

    if ($wishlistModel->save($data) === false) {
      return redirect()->back()->with('error', 'Gagal menambahkan wishlist!');
    }

    return redirect()->back()->with('message', 'Berhasil menambahkan wishlist!');
  }
}
