<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BukuModel;

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
}
