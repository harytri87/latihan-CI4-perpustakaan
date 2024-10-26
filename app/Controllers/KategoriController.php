<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\KategoriModel;

class KategoriController extends BaseController
{
  
  public function index()
  {
    // Menampilkan semua data kategori

    $kategoriModel = new KategoriModel();
    $data = [
      'title'     => 'Data Kategori | Perpustakaan',
      'penomoran' => 20	// samain sama paginate() di model getKategori()
    ];

    $cari = $this->request->getGet('cari');	// dari name-nya input type text
    if ($cari == null) {
      $data['kategori_list'] = $kategoriModel->getKategori();
      $data['pager']		   = $kategoriModel->pager;
    } else {
      $data['kategori_list'] = $kategoriModel->cariKategori($cari);
      $data['pager']		   = $kategoriModel->pager;
    }

    return view('halaman/kategori/index', $data);
  }

  
  public function show($kategori_link = null)
  {
    // Menampilkan rincian satu kategori

    $kategoriModel = new KategoriModel();
		$data = [
			'kategori' => $kategoriModel->getKategori($kategori_link),
			'title'    => 'Rincian Kategori | Perpustakaan'
		];

    // Jika data tidak ditemukan
		if ($data['kategori'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data kategori: ' . $kategori_link);
		}

		return view('halaman/kategori/rincian', $data);
  }

  
  public function new()
  {
    // Menampilkan form untuk menambah kategori baru

    $data['title'] = 'Kategori Baru | Perpustakaan';

    return view('halaman/kategori/tambah', $data);
  }

  
  public function create()
  {
    // Proses memasukan data kategori baru

    $kategoriModel = new KategoriModel();
    // Ngambil input & nambah data array baru
    $dataPost = $this->request->getPost();
    $dataPost['kategori_link'] = url_title($dataPost['kategori_nama'], '-', true);

    // Cek validasi
    if (! $this->validateData($dataPost, $kategoriModel->validationRules, $kategoriModel->validationMessages)) {
			return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
		}

    // Ngambil hasil validasi & ngubah penulisan huruf besar kecil namanya
    $data = $this->validator->getValidated();
    $data['kategori_nama'] = formatNama($data['kategori_nama']);

    // Input data
    if ($kategoriModel->skipValidation()->save($data) === false) {
      return redirect()->back()->with('errors', $kategoriModel->errors())->withInput();
    } else {
      return redirect()->route('kategoriIndex')->with('message', 'Kategori berhasil ditambahkan!');
    }
  }

  
  public function edit($kategori_link = null)
  {
    // Menampilkan form untuk mengubah suatu kategori

    $kategoriModel = new KategoriModel();
    $data = [
      'kategori' => $kategoriModel->getKategori($kategori_link),
      'title'    => 'Data Kategori | Perpustakaan'
    ];

    // Jika data tidak ditemukan
		if ($data['kategori'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data kategori: ' . $kategori_link);
		}

    return view('halaman/kategori/ubah', $data);
  }

  
  public function update($kategori_id = null)
  {
    // Proses mengubah data kategori

    $kategoriModel = new KategoriModel();
    $kategori = $kategoriModel->find($kategori_id);
    $dataPost = $this->request->getPost();
    $dataPost['kategori_link'] = url_title($dataPost['kategori_nama'], '-', true);
    $aturanValidasi = $kategoriModel->validationRules;

    // Ngubah aturan validasi is_unique biar aman buat kategori_id ini aja
    $aturanValidasi['kategori_link'] = "required|min_length[4]|max_length[100]|is_unique[kategori.kategori_link,kategori_id,{$kategori_id}]";

    // Cek ketersediaan data
    if (! $kategori) {
      return redirect()->route('kategoriIndex')->with('error', 'Data kategori tidak tersedia.');
    }

    // Cek validasi
    if (! $this->validateData($dataPost, $aturanValidasi, $kategoriModel->validationMessages)) {
      $errors = $this->validator->getErrors();

      // Ngebuang semua pesan error 'kategori_link' kecuali 'is_unique'.
      // Tapi kalo di validasi messagenya diubah, di sini jg harus diubah manual.
      if (isset($errors['kategori_link']) && $errors['kategori_link'] != 'Tidak dapat membuat kategori yang serupa.') {
        array_pop($errors);
      }

      return redirect()->back()->with('errors', $errors)->withInput();
		}

    // Ngambil hasil validasi & ngubah penulisan huruf besar kecil namanya
    $data = $this->validator->getValidated();
    $data['kategori_nama'] = formatNama($data['kategori_nama']);

    // Ubah data
    if ($kategoriModel->skipValidation()->update($kategori_id, $data) === false) {
      return redirect()->back()->with('errors', $kategoriModel->errors())->withInput();
    } else {
      return redirect()->route('kategoriIndex')->with('message', 'Kategori berhasil diubah!');
    }
  }


  public function delete($kategori_id = null)
  {
    // Proses menghapus data

    $kategoriModel = new KategoriModel();
    $kategori = $kategoriModel->find($kategori_id);

    // Cek ketersediaan data
    if (! $kategori) {
      return redirect()->route('kategoriIndex')->with('error', 'Data kategori tidak tersedia.');
    }

    // Hapus data
    if ($kategoriModel->delete($kategori_id) === false) {
      return redirect()->back()->with('errors', $kategoriModel->errors())->withInput();
    } else {
      return redirect()->route('kategoriIndex')->with('message', 'Kategori berhasil dihapus!');
    }
  }
}
