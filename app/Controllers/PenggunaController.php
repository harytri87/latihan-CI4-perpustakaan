<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\PenggunaModel;
use App\Models\GrupModel;
use App\Models\WishlistModel;
use App\Models\PeminjamanModel;
use App\Models\NomorSeriModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PenggunaController extends BaseController
{
	public function index()
	{
		$penggunaModel = new PenggunaModel();
		
		$data = [
			'title'     => 'Data Pengguna | Perpustakaan',
			'penomoran' => 20	// samain sama paginate() di model getPengguna()
		];

		$cari = $this->request->getGet('cari');	// dari name-nya input type text
		if ($cari == null) {
			$data['pengguna_list'] = $penggunaModel->getPengguna();
			$data['pager']				 = $penggunaModel->pager;
		} else {
			$data['pengguna_list'] = $penggunaModel->cariPengguna($cari);
			$data['pager']				 = $penggunaModel->pager;
		}

		return view('halaman/pengguna/index', $data);
	}

	
	public function show($pengguna_username = null)
	{
		// Rincian pengguna & riwayat peminjaman

		$cariKeyword = $this->request->getVar('cari');
		$cariStatus = $this->request->getVar('status');

		$penggunaModel = new PenggunaModel();
		$peminjamanModel = new PeminjamanModel();

		$data = [
			'pengguna'				=> $penggunaModel->getPengguna($pengguna_username),
			'peminjaman_list' => $peminjamanModel->getPeminjaman($cariKeyword, $cariStatus, $pengguna_username),
			'pager'         	=> $peminjamanModel->pager,
			'title'         	=> 'Rincian Pengguna | Perpustakaan',
			'penomoran'     	=> 20,	// samain sama paginate() di model getPeminjaman()
			'cari_keyword'  	=> $cariKeyword,
			'cari_status'   	=> $cariStatus
		];
		// dd($data['pengguna']['pengguna_nama']);

		if ($data['pengguna'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data pengguna: ' . $pengguna_username);
		}

		$data['title'] = "Profil " . $data['pengguna']['pengguna_nama'] . " | Perpustakaan";

		return view('halaman/pengguna/rincian', $data);
	}
	
	public function new()
	{
		$grupModel = new GrupModel();
		$data = [
			'grup_list'  => $grupModel->getGrup(),
			'title' => 'Pengguna Baru | Perpustakaan',
		];

		return view('halaman/pengguna/tambah', $data);
	}

	
	public function create()
	{
		$penggunaModel = new PenggunaModel();
		$dataPost = $this->request->getPost();

		$password = $dataPost['pengguna_password'];
		$passUlang = $dataPost['password_ulang'];
		$passHash = password_hash($password, PASSWORD_DEFAULT);

		// Validasi password
		if (password_verify($passUlang, $passHash)) {
			$dataPost['pengguna_password'] = $passHash;
		} else {
			return redirect()->route('penggunaTambahForm')->with('error', 'Password tidak sesuai')->withInput();
		}

		// Validasi file
		$validationRule = validasiProfil();
		if (! $this->validateData([], $validationRule)) {
			return redirect()->route('penggunaTambahForm')->with('errors', $this->validator->getErrors())->withInput();
		}

		// Cek upload foto
		$foto = $this->request->getFile('pengguna_foto');
		$dataPost['pengguna_foto'] = cekUploadFoto($foto);

		// Format huruf besar/kecil nama
		$dataPost['pengguna_nama'] = formatJudul($dataPost['pengguna_nama']);

		// Isi database pake validasi yang di model
		if ($penggunaModel->save($dataPost) === false) {
			// Data gagal masuk ke database tapi foto udah masuk ke folder duluan
			if ($foto != "") {
				$fotoBaru = ROOTPATH . 'public/images/profil/' . $dataPost['pengguna_foto'];
				unlink($fotoBaru);
			}

			return redirect()->route('penggunaTambahForm')->with('errors', $penggunaModel->errors())->withInput();
		}

		// Nanti di controller buku pake validasi di luar query save/update aja biar ga banyak ngulang ngecek foto.
		// Eh tapi nanti kalo gagal masukin ke database selain gara2 validasi, foto tetep pindah ke folder sih 

		return redirect()->route('penggunaIndex')->with('message', 'Pengguna berhasil ditambahkan!');
	}

	
	public function edit($pengguna_username = null)
	{
		$penggunaModel = new PenggunaModel();
		$grupModel = new GrupModel();
		$data = [
			'grup_list' => $grupModel->getGrup(),
			'pengguna'  =>$penggunaModel->getPengguna($pengguna_username),
			'title'     => 'Ubah Data Pengguna | Perpustakaan',
		];

		if ($data['pengguna'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data pengguna: ' . $pengguna_username);
		}

		return view('halaman/pengguna/ubah', $data);
	}

	
	public function update($pengguna_id = null)
	{
		
		$penggunaModel = new PenggunaModel();
		$pengguna = $penggunaModel->find($pengguna_id);
		$dataPost = $this->request->getPost();

		$password = $dataPost['pengguna_password'];
		$passUlang = $dataPost['password_ulang'];
		$passHash = password_hash($password, PASSWORD_DEFAULT);

		// Biar lolos validasi cek duplikat, data email sama username kalo ga diubah harus dibuang
		$data = [
			$dataPost['pengguna_email'] === $pengguna['pengguna_email']
				? "" : 'pengguna_email' => $dataPost['pengguna_email'],

			$dataPost['pengguna_username'] === $pengguna['pengguna_username']
				? "" : 'pengguna_username' => $dataPost['pengguna_username'],

			'pengguna_nama'     => formatJudul($dataPost['pengguna_nama']),
			'grup_id'           => $dataPost['grup_id']
		];

		// Validasi password
		if ($password != "") {
			if (password_verify($passUlang, $passHash)) {
				$data['pengguna_password'] = $passHash;
			} else {
				return redirect()->back()->with('error', 'Password tidak sesuai')->withInput();
			}
		}

		// Validasi file
		$validationRule = validasiProfil();
    if (! $this->validateData([], $validationRule)) {
			return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
    }

		// Cek upload foto
		$foto = $this->request->getFile('pengguna_foto');
		$data['pengguna_foto'] = cekUploadFoto($foto);

		// Isi database pake validasi yang di model
		if ($penggunaModel->update($pengguna_id, $data) === false) {
			// Data gagal masuk ke database tapi foto udah masuk ke folder duluan
			if ($foto != "") {
				$fotoBaru = ROOTPATH . 'public/images/profil/' . $data['pengguna_foto'];
				unlink($fotoBaru);
			}

			return redirect()->back()->with('errors', $penggunaModel->errors())->withInput();
		}

		// Baru dijalanin kalo ngupdate data berhasil
		if ($foto != "") {
			// Ngehapus foto lama, kalo ada
			$fotoLama = ROOTPATH . 'public/images/profil/' . $pengguna['pengguna_foto'];
			if (file_exists($fotoLama)) {
				unlink($fotoLama);
				// Katanya ada juga helper dari CI buat ngehapus. Tapi biar ga ngeload helper, pake bawaan PHPnya aja
			}
		}


		// Banyak ngecek foto gitu gara2 validasi data lainnya baru dicek pas jalanin model-update()

		return redirect()->route('penggunaIndex')->with('message', 'Pengguna berhasil ditambahkan!');
	}

	
	public function delete($pengguna_id = null)
	{
		$penggunaModel = new PenggunaModel();
		$pengguna = $penggunaModel->find($pengguna_id);

		if (!$pengguna) {
			return redirect()->route('penggunaIndex')->with('error', 'Data pengguna tidak tersedia.');
		}

		$fotoLama = ROOTPATH . 'public/images/profil/' . $pengguna['pengguna_foto'];

		if ($penggunaModel->delete($pengguna_id) === false) {
			return redirect()->back()->with('errors', $penggunaModel->errors())->withInput();
		}

		if (file_exists($fotoLama)) {
			unlink($fotoLama);
			// Katanya ada juga helper dari CI buat ngehapus. Tapi biar ga ngeload helper, pake bawaan PHPnya aja
		}

		return redirect()->route('penggunaIndex')->with('message', 'Data pengguna berhasil dihapus!');
	}
	

	public function wishlist($pengguna_username)
	{
		// Menampilkan daftar wishlist pengguna

		$penggunaModel = new PenggunaModel();
		$wishlistModel = new WishlistModel();
		$data = [
			'pengguna' => $penggunaModel->getPengguna($pengguna_username),
			'title'    => "Wishlist Anggota | Perpustakaan"
		];

		if ($data['pengguna'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data pengguna: ' . $pengguna_username);
		}

		$wishlist = $wishlistModel->wishlistPengguna($data['pengguna']['pengguna_id']);

		$data['title'] = "Wishlist " . $data['pengguna']['pengguna_nama'] . " | Perpustakaan";
		$data['wishlist_list'] = $wishlist;

		return view('halaman/pengguna/wishlist', $data);
	}

	public function updateWishlist()
	{
		// Nambahin wishlist ke peminjaman

		$db = \Config\Database::connect();
		$waktu = new Time();
		$wishlistModel = new WishlistModel();
		$seriModel = new NomorSeriModel();
		$peminjamanModel = new PeminjamanModel();
		$penggunaModel = new PenggunaModel();
		$dataPost = $this->request->getPost();
		$notif = [];
		$peminjamanDurasi = 7;
		$peminjamanStatus = "dipinjam";

		$tanggalKode = $waktu->toLocalizedString('ddMMyyyy');

		// Loop data buat ngefilter status "Konfirmasi"
		foreach ($dataPost['status'] as $key => $status) {
			if ($status === 'konfirmasi') {
				$wishlist[] = [
					'wishlist_id' => $dataPost['wishlist_id'][$key],
					'pengguna_id' => $dataPost['pengguna_id'][$key],
					'seri_kode'		=> $dataPost['seri_kode'][$key],
				];
			}
		}

		if (!isset($wishlist)) {
			return redirect()->back()->with('errors', ['Tidak ada data wishlist yang dikonfirmasi']);
		}

		foreach ($wishlist as $key => $item) {
			$seri = $seriModel->satuNomorSeri($item['seri_kode']);

			// Cek ketersediaan buku
			if ($seri === null) {
				$notif[0] = 'Label buku tidak sesuai';
			} else {
				if ($seri['status_buku'] !== 'tersedia') {
					$notif[0] = 'Label buku sedang tidak tersedia';
				}
			}

			if ($notif !== []) {
				return redirect()->back()->with('errors', $notif);
			}

			// Misahin array $wishlist jadi 3 array lain
			// Array pertama buat hapus data table wishlist
			$wishlist_id[$key]['wishlist_id'] = $item['wishlist_id'];
			
			// Array kedua buat nambahin data table peminjaman
			$dataPeminjaman[$key]['peminjaman_kode'] = $item['pengguna_id'] . "-" . $tanggalKode;
			$dataPeminjaman[$key]['peminjaman_durasi'] = $peminjamanDurasi;
			$dataPeminjaman[$key]['peminjaman_tanggal'] = $waktu;
			$dataPeminjaman[$key]['seri_id'] = $seri['seri_id'];
			$dataPeminjaman[$key]['pengguna_id'] = $item['pengguna_id'];
			$dataPeminjaman[$key]['peminjaman_status'] = $peminjamanStatus;

			// Array ketiga buat ngubah status nomor_seri jadi "dipinjam"
			$dataNomorSeri[$key]['seri_id'] = $seri['seri_id'];
			$dataNomorSeri[$key]['status_buku'] = $peminjamanStatus;
		}

		$pengguna = $penggunaModel->find($dataPost['pengguna_id']);

		$db->transStart();

		try {
			// Input data ke table peminjaman
			$peminjamanModel->insertBatch($dataPeminjaman);

			// Update data table nomor_seri
			$seriModel->updateBatch($dataNomorSeri, 'seri_id');

			// Ngehapus data table wishlist
			$wishlistIds = array_column($wishlist_id, 'wishlist_id');
			$wishlistModel->whereIn('wishlist_id', $wishlistIds)->delete();

			$db->transComplete();

			if ($db->transStatus() === false) {
				throw new DatabaseException('Proses gagal.');
			}

			return redirect()->route('penggunaRincian', [$pengguna[0]['pengguna_username']])->with('message', 'Data peminjaman berhasil ditambahkan.');
		} catch (DatabaseException $e) {
				$db->transRollback();
				return redirect()->back()->with('errors', $e->getMessage());
		}
	}
}
