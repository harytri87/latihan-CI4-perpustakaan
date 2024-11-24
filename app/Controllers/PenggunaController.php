<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\PenggunaModel;
use App\Models\GrupModel;
use App\Models\WishlistModel;

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
		$penggunaModel = new PenggunaModel();
		$data = [
			'pengguna' => $penggunaModel->getPengguna($pengguna_username),
			'title'    => "Rincian Pengguna | Perpustakaan"
		];
		// dd($data['pengguna']['pengguna_nama']);

		if ($data['pengguna'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data pengguna: ' . $pengguna_username);
		}

		$data['title'] = "Profil " . $data['pengguna']['pengguna_nama'] . " | Perpustakaan";

		return view('halaman/pengguna/rincian', $data);
	}

	
	public function wishlist($pengguna_username)
	{
		$penggunaModel = new PenggunaModel();
		$wishlistModel = new WishlistModel();
		$data = [
			'pengguna' => $penggunaModel->getPengguna($pengguna_username),
			'title'    => "Wishlist Anggota | Perpustakaan"
		];
		// dd($data['pengguna']['pengguna_nama']);

		if ($data['pengguna'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data pengguna: ' . $pengguna_username);
		}

		$wishlist = $wishlistModel->wishlistPengguna($data['pengguna']['pengguna_id']);

		$data['title'] = "Wishlist " . $data['pengguna']['pengguna_nama'] . " | Perpustakaan";
		$data['wishlist_list'] = $wishlist;

		return view('halaman/pengguna/wishlist', $data);
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
}
