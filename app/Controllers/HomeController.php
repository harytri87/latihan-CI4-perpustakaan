<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BukuModel;

class HomeController extends BaseController
{
    public function index(): string
    {
        // Menampilkan semua data buku
    
        $cariKeyword = $this->request->getVar('cari');
    
        $bukuModel = new BukuModel();
        $data = [
          'buku_list'     => $bukuModel->getBuku($cariKeyword),
          'pager'         => $bukuModel->pager,
          'title'         => 'Perpustakaan',
          'penomoran'     => 20,	// samain sama paginate() di model getBuku()
          'cari_keyword'  => $cariKeyword
        ];
    
        return view('halaman/index', $data);
    }
}
