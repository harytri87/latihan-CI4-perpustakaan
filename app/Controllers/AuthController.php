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
            // 'news_list' => $model->getNews(),
            'title'     => 'Login | Perpustakaan',
        ];

        return view('halaman/auth/login', $data);
    }

    public function loginAction()
    {
        // Ngecek yg dimasukin tuh email atau username
        $fieldType = filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        echo $fieldType;
    }

    public function registerView()
    {
        helper('form');

        $data = [
            // 'news_list' => $model->getNews(),
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
