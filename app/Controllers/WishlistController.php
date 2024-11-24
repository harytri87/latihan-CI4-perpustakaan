<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\WishlistModel;
use App\Models\BukuModel;
use App\Models\NomorSeriModel;
use App\Models\PenggunaModel;

class WishlistController extends BaseController
{
  public function index()
  {
    // Menampilkan semua data wishlist

    $cariKeyword = $this->request->getVar('cari');
    $cariStatus = $this->request->getVar('status');

    $wishlistModel = new WishlistModel();
    $data = [
      'wishlist_list' => $wishlistModel->getWishlist($cariKeyword, $cariStatus),
      'pager'         => $wishlistModel->pager,
      'title'         => 'Data Wishlist | Perpustakaan',
      'penomoran'     => 20,	// samain sama paginate() di model getWishlist()
      'cari_keyword'  => $cariKeyword,
      'cari_status'   => $cariStatus,
    ];

    return view('halaman/wishlist/index', $data);
    // return view('halaman/wishlist/rincian');
  }

  public function new()
  {
    // Form tambah wishlist baru

		$username = $this->request->getVar('u');

    $bukuModel = new BukuModel();
    $penggunaModel = new PenggunaModel();
    $dataBuku = $bukuModel->findAll();
    $dataPengguna = $penggunaModel->findAll();
    $bukuList = [];
    $penggunaList = [];

    // Daftar buku buat option datalist
    foreach ($dataBuku as $buku) {
      $bukuList[$buku['isbn']] = [$buku['buku_judul'], $buku['buku_foto']];
    }

    // Daftar pengguna buat option datalist
    foreach ($dataPengguna as $pengguna) {
      $penggunaList[$pengguna['pengguna_username']] = $pengguna['pengguna_email'];
    }

		$data = [
			'buku_list'       => $bukuList,
			'pengguna_list'   => $penggunaList,
      'email_preset'    => '',
      'username_preset' => '',
			'title'           => 'Tambah Wishlist Baru | Perpustakaan'
		];
    
    // Kalo admin mau nambahin wishlist dari rincian CRUD pengguna
    if (isset($username)) {
      $pengguna = $penggunaModel->getPengguna($username);
      if ($pengguna !== null) {
        $data['email_preset'] = $pengguna['pengguna_email'];
        $data['username_preset'] = $pengguna['pengguna_username'];
      }
    }

		return view('halaman/wishlist/tambah', $data);
  }

  public function create()
  {
    // Proses memasukan data wishlist baru

    $wishlistModel = new WishlistModel();
    $seriModel = new NomorSeriModel();
    $penggunaModel = new PenggunaModel();
		$dataPost = $this->request->getPost();
    $seri = $seriModel->satuISBNStatus($dataPost['isbn'], 'tersedia');
    $pengguna = $penggunaModel->getPengguna($dataPost['pengguna_username']);
    $notif = [];

    // Cek ketersediaan
    if ($pengguna === null) {
      $notif[0] = 'Data anggota tidak ditemukan';
    }

    if ($seri === null) {
      $notif[1] = 'Judul buku tidak ditemukan';
    }

    if ($notif !== []) {
      return redirect()->route('wishlistTambahForm')->with('errors', $notif)->withInput();
    }

    // Cek buku yang sama udah ada di wishlistnya belum
    $cekDuplikat = $wishlistModel->cekDuplikat($pengguna['pengguna_id'], $dataPost['isbn']);

    if ($cekDuplikat > 0) {
      if (isset($dataPost['redirect'])) {
        $redirect = "?u=" . $dataPost['pengguna_username'];

        return redirect()
          ->to(route_to('wishlistTambahForm') . $redirect)
          ->with('errors', ['Setiap anggota hanya dapat meminjam satu buku yang sama'])
          ->withInput();
      } else {
        return redirect()->route('wishlistTambahForm')->with('errors', ['Setiap anggota hanya dapat meminjam satu buku yang sama'])->withInput();
      }
    }

    // Data yang bakal disimpen
    $data = [
      'seri_id' => $seri['seri_id'],
      'pengguna_id' => $pengguna['pengguna_id'],
      'status' => $dataPost['status']
    ];

    // Gagal input data
    if ($wishlistModel->save($data) === false) {
      return redirect()->route('wishlistTambahForm')->with('errors', $wishlistModel->errors())->withInput();
    }

    // Berhasil input data
    if (isset($dataPost['redirect'])) {
      return redirect()->route('penggunaWishlist', [$dataPost['pengguna_username']])->with('message', 'Data wishlist berhasil ditambahkan!');
    } else {
      return redirect()->route('wishlistIndex')->with('message', 'Data wishlist berhasil ditambahkan!');
    }
  }

  public function edit($wishlist_id)
  {
    // Tampilan ubah data wishlist

    $wishlistModel = new WishlistModel();
    $bukuModel = new BukuModel();
    $penggunaModel = new PenggunaModel();
    $wishlist = $wishlistModel->satuWishlist($wishlist_id);
    $dataBuku = $bukuModel->findAll();
    $dataPengguna = $penggunaModel->findAll();
    $bukuList = [];
    $penggunaList = [];

    if ($wishlist === null) {
			throw new PageNotFoundException('Data wishlist tidak ditemukan');
		}

    // Daftar buku buat option datalist
    foreach ($dataBuku as $buku) {
      $bukuList[$buku['isbn']] = [$buku['buku_judul'], $buku['buku_foto']];
    }

    // Daftar pengguna buat option datalist
    foreach ($dataPengguna as $pengguna) {
      $penggunaList[$pengguna['pengguna_username']] = $pengguna['pengguna_email'];
    }

		$data = [
      'wishlist'      => $wishlist,
			'buku_list'     => $bukuList,
			'pengguna_list' => $penggunaList,
			'title'         => 'Tambah Wishlist Baru | Perpustakaan'
		];

		return view('halaman/wishlist/ubah', $data);
  }

  public function update($wishlist_id)
  {
    // Proses mengubah data wishlist

    $wishlistModel = new WishlistModel();
    $seriModel = new NomorSeriModel();
    $penggunaModel = new PenggunaModel();
		$dataPost = $this->request->getPost();

    $seri = $seriModel->satuISBNStatus($dataPost['isbn'], 'tersedia');
    $pengguna = $penggunaModel->getPengguna($dataPost['pengguna_username']);

    $notif = [];

    if ($pengguna === null) {
      $notif[0] = 'Data anggota tidak ditemukan';
    }

    if ($seri === null) {
      $notif[1] = 'Judul buku tidak ditemukan';
    }

    if ($notif !== []) {
      return redirect()->route('wishlistUbahForm', [$wishlist_id])->with('errors', $notif)->withInput();
    }

    $data = [
      'seri_id' => $seri['seri_id'],
      'pengguna_id' => $pengguna['pengguna_id'],
      'status' => $dataPost['status']
    ];

    if ($wishlistModel->update($wishlist_id, $data) === false) {
      return redirect()->route('wishlistUbahForm', [$wishlist_id])->with('errors', $wishlistModel->errors())->withInput();
    }

    return redirect()->route('wishlistIndex')->with('message', 'Data wishlist berhasil diubah!');
  }

  public function delete($wishlist_id)
  {
    // Menghapus data wishlist

    $wishlistModel = new WishlistModel();
		$wishlist = $wishlistModel->find($wishlist_id);

		// Cek ketersediaan data
    if (! $wishlist) {
      return redirect()->route('nomorSeriIndex')->with('error', 'Data label buku tidak tersedia.');
    }

		// Hapus data
		if ($wishlistModel->delete($wishlist_id) === false) {
			return redirect()->route('wishlistIndex')->with('errors', $wishlistModel->errors())->withInput();
		}

		return redirect()->route('wishlistIndex')->with('message', 'Data wishlist berhasil dihapus!');
  }
}
