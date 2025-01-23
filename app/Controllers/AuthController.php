<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PenggunaModel;

class AuthController extends BaseController
{
	public function loginView()
	{
		$data = [
			'title'     => 'Login | Perpustakaan',
		];

		return view('halaman/auth/login', $data);
	}

	public function loginAction()
	{
		// // Ngecek yg dimasukin tuh email atau username
		// $fieldType = filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		// echo $fieldType;
		
		$dataPost = $this->request->getPost();
		
		$rules = [
			'pengguna_email'		=> 'required',
			'pengguna_password'	=> 'required|validateUser[pengguna_email,pengguna_password]'
		];

		$errors = [
			'pengguna_email' => [
				'required' => 'Email harus diisi'
			],
			'pengguna_password' => [
				'required' 		 => 'Password harus diisi',
				'validateUser' => 'Email atau password salah'
			]
		];
		
		if (! $this->validate($rules, $errors)) {
			return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
		} else {
			// Berhasil validasi. Set session
			$penggunaModel = new PenggunaModel();
			$pengguna = $penggunaModel->getPengguna($dataPost['pengguna_email']);

			$this->setLoginSession($pengguna);

			return redirect()->route('index')->with('message', 'Login berhasil!');
		}
	}

	private function setLoginSession($pengguna)
	{
		// Menambah session login
		$dataSession = [
			'id'				 => $pengguna['pengguna_id'],
			'username'	 => $pengguna['pengguna_username'],
			'grup'			 => $pengguna['grup_nama'],
			'isLoggedIn' => true
		];

		session()->set($dataSession);
    return true;
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->route('index')->with('message', 'Anda telah logout.');
	}

	public function registerView()
	{
		helper('form');

		$data = [
			'title'     => 'Daftar | Perpustakaan',
		];

		return view('halaman/auth/daftar', $data);
	}

	public function registerAction()
	{
		helper('form');

		$pengguna = new PenggunaModel();
		$data = $this->request->getPost();

		if ($pengguna->insert($data) === false) {
			return view('halaman/auth/daftar', ['errors' => $pengguna->errors()]);
		}

		return redirect()->route('authDaftarForm')->with('message', 'Pendaftaran berhasil!');
	}
}
