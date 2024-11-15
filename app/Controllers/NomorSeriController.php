<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\NomorSeriModel;
use App\Models\BukuModel;

class NomorSeriController extends BaseController
{
	public function index()
	{
		// Menampilkan semua data nomor seri / label
		
		$nomorSeriModel = new NomorSeriModel();
		$cariKeyword = $this->request->getVar('cari');
		$cariStatus = $this->request->getVar('status');

		$data = [
			'nomor_seri_list' => $nomorSeriModel->getNomorSeri($cariKeyword, $cariStatus),
			'pager'           => $nomorSeriModel->pager,
			'title'           => 'Data Buku | Perpustakaan',
			'penomoran'       => 20,	// samain sama paginate() di model getNomorSeri()
			'cari_keyword'    => $cariKeyword,
			'cari_status'     => $cariStatus,
			'aksi'						=> 'seriController'	// Tanda manggil tampilan tablenya dari controller ini
		];

		return view('halaman/nomorSeri/index', $data);
	}

	public function new()
	{
		// Ga jadi dipake. Nambahnya dari halaman rincian buku
		// Menampilkan form untuk menambah nomor seri baru

		$bukuModel = new BukuModel();
		$data = [
			'buku_list' => $bukuModel->findAll(),
			'title'     => 'Buku Baru | Perpustakaan'
		];

		return view('halaman/nomorSeri/tambah', $data);
	}

	public function create()
	{
		// Nambah jumlah buku yang udah ada
		
		$nomorSeriModel = new NomorSeriModel();
		$dataPost = $this->request->getPost();
		$isbn	= $dataPost['isbn'];
		$kodeTerbesar = $nomorSeriModel->getMaxKode($isbn)['seri_kode'];

		// Jika data tidak ditemukan
		if ($kodeTerbesar === null) {
			throw new PageNotFoundException('Tidak ada data buku yang sesuai ISBN: ' . $isbn);
		}

		// Ngambil slug buat kebutuhan redirect
		$bukuModel = new BukuModel();
		$slug = [$bukuModel->getBuku($isbn)[0]['slug']];

		if ($dataPost['status_buku'] === "" || $dataPost['jumlah_buku'] === "") {
			return redirect()->route('adminBukuRincian', $slug)->with('errors', [0 => 'Mohon lengkapi data status dan jumlah buku']);
		}

		preg_match('/(\d+)$/', $kodeTerbesar, $matches);		// Ambil angka terakhir
		$angkaTerakhir = $matches[1];
		$jumlahBuku = $dataPost['jumlah_buku'];

		for ($i = 0; $i < $jumlahBuku; $i++) {
			$angkaTerakhir++;
			$dataPost['seri_kode'] = preg_replace('/\d+$/', $angkaTerakhir, $kodeTerbesar);
			
			if ($nomorSeriModel->save($dataPost) === false) {
				return redirect()->route('adminBukuRincian', $slug)->with('errors', $nomorSeriModel->errors());
			}
		}

		return redirect()->route('adminBukuRincian', $slug)->with('message', 'Data buku berhasil ditambahkan!');

	}

	public function update($seri_id)
	{
		// Mengubah status buku aja. Data lain otomatis keubah pas ngubah data di table buku

		$seriModel = new NomorSeriModel();
		$seri = $seriModel->find($seri_id);
		$dataPost = $this->request->getPost();
		$slug = [$this->request->getVar('slug')];

		// Cek ketersediaan data
    if (! $seri) {
      return redirect()->route('nomorSeriIndex')->with('error', 'Data label buku tidak tersedia.');
    }

		// Ubah data status
		if ($seriModel->update($seri_id, $dataPost) === false) {
			return redirect()->back()->with('errors', $seriModel->errors())->withInput();
		}

		if ($slug[0] !== null) {
			return redirect()->route('adminBukuRincian', $slug)->with('message', 'Data label buku berhasil diubah!');
		}

		return redirect()->route('nomorSeriIndex')->with('message', 'Data label buku berhasil diubah!');
	}

	public function delete($seri_id)
	{
		// Menghapus data label buku

		$seriModel = new NomorSeriModel();
		$seri = $seriModel->find($seri_id);

		// Cek ketersediaan data
    if (! $seri) {
      return redirect()->route('nomorSeriIndex')->with('error', 'Data label buku tidak tersedia.');
    }

		// Hapus data
		if ($seriModel->delete($seri_id) === false) {
			return redirect()->back()->with('errors', $seriModel->errors())->withInput();
		}

		return redirect()->route('nomorSeriIndex')->with('message', 'Data label buku berhasil dihapus!');
	}
}
