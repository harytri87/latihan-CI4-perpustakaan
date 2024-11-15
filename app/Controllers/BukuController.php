<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\NomorSeriModel;

class BukuController extends BaseController
{

  public function index()
  {
    // Menampilkan semua data buku

    $cariKeyword = $this->request->getVar('cari');
    $cariKategori = $this->request->getVar('kategori');

    $bukuModel = new BukuModel();
    $kategoriModel = new KategoriModel();
    $data = [
      'buku_list'     => $bukuModel->getBuku($cariKeyword, $cariKategori),
      'pager'         => $bukuModel->pager,
      'kategori_list' => $kategoriModel->findAll(),
      'title'         => 'Data Buku | Perpustakaan',
      'penomoran'     => 20,	// samain sama paginate() di model getBuku()
      'cari_keyword'  => $cariKeyword,
      'cari_kategori' => $cariKategori,
    ];

    return view('halaman/buku/index', $data);
  }


  public function show($slug = null)
  {
    // Menampilkan rincian satu buku

    $bukuModel = new BukuModel();
    $nomorSeriModel = new NomorSeriModel();
		$buku = $bukuModel->satuBuku($slug);
		$cariStatus = $this->request->getVar('status');

		$data = [
			'buku'            => $buku,
			'title'           => 'Rincian Buku | Perpustakaan',
			'penomoran'       => 20,	// samain sama paginate() di model getNomorSeri()
			'cari_status'     => $cariStatus,
			'aksi'						=> 'bukuController',	// Tanda manggil tampilan tablenya dari controller ini
		];

    // Jika data tidak ditemukan
		if ($data['buku'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data buku: ' . $slug);
		}

    $data['jumlah_tersedia'] = $nomorSeriModel->countTersedia($buku['isbn']);
    $data['nomor_seri_list'] = $nomorSeriModel->getNomorSeri($buku['isbn'], $cariStatus);
    $data['pager'] = $nomorSeriModel->pager;

		return view('halaman/buku/rincian', $data);
  }


  public function new()
  {
    // Menampilkan form untuk menambah buku baru

    $kategoriModel = new KategoriModel();
    $data = [
      'kategori_list' => $kategoriModel->findAll(),
      'title' => 'Buku Baru | Perpustakaan'
    ];

    return view('halaman/buku/tambah', $data);
  }


  public function create()
  {
    // Proses memasukan data buku baru

    $bukuModel = new BukuModel();
    $kategoriModel = new KategoriModel();
    $seriModel = new NomorSeriModel();
    $dataPost = $this->request->getPost();

    // Ngambil kata pertama dari nama penulis buat dimasukin ke slug
    // Kalo ada judul buku yang sama, tetep aman ditambah nama penulisnya
    $namaPenulis = explode(' ', $dataPost['buku_penulis']);
    $dataPost['slug'] = url_title($dataPost['buku_judul'] . ' ' . $namaPenulis[0], '-', true);

    $tahunValidasi = date('Y', strtotime('+1 year'));
    $aturanValidasi = $bukuModel->validationRules;
    $aturanValidasi['buku_terbit'] = "required|exact_length[4]|numeric|greater_than[1900]|less_than[$tahunValidasi]";

    // Validasi file
		$validationRule = validasiSampul($adaFoto = true);
		if (! $this->validateData([], $validationRule)) {
			return redirect()->route('adminBukuTambahForm')->with('errors', $this->validator->getErrors())->withInput();
		}

    // Cek upload foto
		$foto = $this->request->getFile('buku_foto');
		if ($foto != "") {
      $dataPost['buku_foto'] = cekUploadSampul($foto);
      $fotoBaru = ROOTPATH . 'public/images/buku/' . $dataPost['buku_foto'];
		}

    // Validasi input lainnya
    if (! $this->validateData($dataPost, $aturanValidasi, $bukuModel->validationMessages)) {
      unlink($fotoBaru);

			return redirect()->route('adminBukuTambahForm')->with('errors', $this->validator->getErrors())->withInput();
		}

    // Ngambil hasil validasi & ngubah penulisan huruf besar kecil namanya
    $dataBuku = $this->validator->getValidated();
    $dataBuku['buku_judul'] = formatJudul($dataBuku['buku_judul']);
    $dataBuku['buku_penulis'] = formatJudul($dataBuku['buku_penulis']);
    $kategori = $kategoriModel->find($dataBuku['kategori_id']);

    // Input dataBuku
    if ($bukuModel->skipValidation()->save($dataBuku) === false) {
      unlink($fotoBaru);
      
      return redirect()->route('adminBukuTambahForm')->with('errors', $bukuModel->errors())->withInput();
    } else {
      // Sekalian ubah seri_kode di table nomor_seri

      $kategoriKode = $kategori['kategori_kode'];
      $resultPenulis = tigaHurufPenulis($dataBuku['buku_penulis']);
      $resultJudul = inisialJudul($dataBuku['buku_judul']);

      // Perulangan input data sesuai jumlah buku
      $jumlah = $dataPost['jumlah_buku'];
      for ($i = 1; $i <= $jumlah; $i++) {
        $seriKode = $kategoriKode . ' ' . $resultPenulis . ' ' . $resultJudul . ' ' . $i;
        $dataSeri = [
          'seri_kode'   => $seriKode,
          'isbn'        => $dataBuku['isbn'],
          'status_buku' => 'tersedia'
        ];

        $seriModel->save($dataSeri);
      }

      return redirect()->route('adminBukuIndex')->with('message', 'Data buku berhasil ditambahkan!');
    }
  }

  public function edit($slug)
  {
    // Tampilan ubah data buku

    $bukuModel = new BukuModel();
    $kategoriModel = new KategoriModel();
    $data = [
      'buku'          => $bukuModel->satuBuku($slug),
      'kategori_list' => $kategoriModel->findAll(),
      'title'         => 'Ubah Data Buku | Perpustakaan'
    ];

    return view('halaman/buku/ubah', $data);
  }

  public function update($buku_id)
  {
    // Proses ubah data buku

    $bukuModel = new BukuModel();
    $kategoriModel = new KategoriModel();
    $seriModel = new NomorSeriModel();
    $buku = $bukuModel->find($buku_id);

    $dataPost = $this->request->getPost();

    $namaPenulis = explode(' ', $dataPost['buku_penulis']);
    $dataPost['slug'] = url_title($dataPost['buku_judul'] . ' ' . $namaPenulis[0], '-', true);

    $tahunValidasi = date('Y', strtotime('+1 year'));
    $aturanValidasi = $bukuModel->validationRules;
    $aturanValidasi['buku_terbit'] = "required|exact_length[4]|numeric|greater_than[1900]|less_than[$tahunValidasi]";

    // Ngubah aturan validasi is_unique biar aman buat buku_id ini aja
    $aturanValidasi['isbn'] = "required|exact_length[13]|is_unique[buku.isbn,buku_id,{$buku_id}]";
    $aturanValidasi['slug'] = "required|min_length[4]|max_length[255]|is_unique[buku.slug,buku_id,{$buku_id}]";

    // Cek ketersediaan data
    if (! $buku) {
      return redirect()->route('adminBukuIndex')->with('error', 'Data buku tidak tersedia.');
    }

    // Validasi file
		$validationRule = validasiSampul();
		if (! $this->validateData([], $validationRule)) {
			return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
		}

    // Cek upload foto
		$foto = $this->request->getFile('buku_foto');
		if ($foto != "") {
      $dataPost['buku_foto'] = cekUploadSampul($foto);
      $fotoBaru = ROOTPATH . 'public/images/buku/' . $dataPost['buku_foto'];
		} else {
      // Ngilangin validasi buku_foto kalo ga ngubah foto
      unset($aturanValidasi['buku_foto']);
    }

    // Validasi input lainnya
    if (! $this->validateData($dataPost, $aturanValidasi, $bukuModel->validationMessages)) {
      if ($foto != "") {
        // hapus foto kalo gagal input
        unlink($fotoBaru);
      }

			return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
		}

    // Ngambil hasil validasi & ngubah penulisan huruf besar kecil namanya
    $dataBuku = $this->validator->getValidated();
    $dataBuku['buku_judul'] = formatJudul($dataBuku['buku_judul']);
    $dataBuku['buku_penulis'] = formatJudul($dataBuku['buku_penulis']);
    $kategori = $kategoriModel->find($dataBuku['kategori_id']);

    // Ubah data buku
    if ($bukuModel->skipValidation()->update($buku_id, $dataBuku) === false) {
      // Kalo gagal
      if ($foto != "") {
        unlink($fotoBaru);
      }
      
      return redirect()->back()->with('errors', $bukuModel->errors())->withInput();
    } 
    else {
      // Kalo berhasil sekalian ubah seri_kode di table nomor_seri

      $kategoriKode = $kategori['kategori_kode'];
      $resultPenulis = tigaHurufPenulis($dataBuku['buku_penulis']);
      $resultJudul = inisialJudul($dataBuku['buku_judul']);

      // Perulangan ubah data seri_kode di table nomor_seri sesuai jumlah buku
      $seri_list = $seriModel->getISBN($dataBuku['isbn']);
      $i = 1;
      foreach ($seri_list as $seri_item) {
        $seriKode = $kategoriKode . ' ' . $resultPenulis . ' ' . $resultJudul . ' ' . $i++;
        $dataSeri = [
          'seri_kode' => $seriKode,
        ];

        $seriModel->update($seri_item['seri_id'], $dataSeri);
      }

      // Ngehapus foto lama
      if ($foto != "") {
        $fotoLama = ROOTPATH . 'public/images/buku/' . $buku['buku_foto'];
        if (file_exists($fotoLama)) {
          unlink($fotoLama);
        }
      }
    }

    return redirect()->route('adminBukuIndex')->with('message', 'Data buku berhasil diubah!');
  }

  public function delete($buku_id)
  {
    // Menghapus data buku & fotonya

    $bukuModel = new BukuModel();
		$buku = $bukuModel->find($buku_id);

		if (!$buku) {
			return redirect()->route('bukuIndex')->with('error', 'Data buku tidak tersedia.');
		}

		$fotoLama = ROOTPATH . 'public/images/buku/' . $buku['buku_foto'];

		if ($bukuModel->delete($buku_id) === false) {
			return redirect()->back()->with('errors', $bukuModel->errors())->withInput();
		}

		if (file_exists($fotoLama)) {
			unlink($fotoLama);
		}

		return redirect()->route('adminBukuIndex')->with('message', 'Data buku berhasil dihapus!');
  }
}
