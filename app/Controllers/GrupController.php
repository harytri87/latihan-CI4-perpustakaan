<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\GrupModel;

class GrupController extends BaseController
{
    public function index()
    {
        $grupModel = new GrupModel();
        $data = [
            'grup_list' => $grupModel->paginate(5),
            'pager'     => $grupModel->pager,
            'title'     => 'Data Grup | Perpustakaan',
        ];

        return view('halaman/grup/index', $data);
    }

    // Ini ga kepake buat grup, sama kayak edit()
    public function show($grup_id = null)
    {
        $grupModel = new GrupModel();
        $data['grup'] = $grupModel->getGrup($grup_id);

        if ($data['grup'] === null) {
            throw new PageNotFoundException('Tidak dapat menemukan data grup: ' . $grup_id);
        }

        $data['title'] = 'Rincian Grup | Perpustakaan';

        return view('halaman/grup/rincian', $data);
    }

    
    public function new()
    {
        $data = [
            // 'news_list' => $grupModel->getNews(),
            'title'     => 'Grup Baru | Perpustakaan',
        ];

        return view('halaman/grup/tambah', $data);
    }

    
    public function create()
    {
        $grupModel = new GrupModel();

        // Ngambil semua data yg dikirimin dari post, termasuk csrf token sama method dari input hiddennya
        // Bisa langsung update pake $dataPost, bisa jg bikin variable baru yg isinya relevan buat table
        $dataPost = $this->request->getPost();
		$data = [
            // Pake penamaan_helper.php
			'grup_nama'       => formatJudul($dataPost['grup_nama']),
			'grup_keterangan' => $dataPost['grup_keterangan']
		];

        if ($grupModel->save($data) === false) {
            return redirect()->back()->with('errors', $grupModel->errors())->withInput();
        }

        return redirect()->route('grupIndex')->with('message', 'Grup berhasil ditambahkan!');
    }

    
    public function edit($grup_id = null)
    {
        $grupModel = new GrupModel();
        $data['grup'] = $grupModel->getGrup($grup_id);

        if ($data['grup'] === null) {
            throw new PageNotFoundException('Tidak dapat menemukan data grup: ' . $grup_id);
        }

        $data['title'] = 'Ubah Data Grup | Perpustakaan';

        return view('halaman/grup/ubah', $data);
    }

    
    public function update($grup_id = null)
    {
        $grupModel = new GrupModel();
        // $data = $grupModel->getGrup($grup_id);
        $data = $grupModel->find($grup_id);
        // sama aja

        if (!$data) {
            return redirect()->route('grupIndex')->with('message', 'Data kategori tidak tersedia.');
        }

        $dataPost = $this->request->getPost();
		$data = [
			'grup_nama'       => formatJudul($dataPost['grup_nama']),
			'grup_keterangan' => $dataPost['grup_keterangan']
		];

        if ($grupModel->update($grup_id, $data) === false) {
			return redirect()->back()->with('errors', $grupModel->errors())->withInput();
		}

		return redirect()->route('grupIndex')->with('message', 'Data kategori berhasil dubah!');
    }

    
    public function delete($grup_id = null)
    {
        $grupModel = new GrupModel();
        $data = $grupModel->find($grup_id);

        if (!$data) {
            return redirect()->route('grupIndex')->with('message', 'Data kategori tidak tersedia.');
        }

        if ($grupModel->delete($grup_id) === false) {
			return redirect()->back()->with('errors', $grupModel->errors())->withInput();
		}

		return redirect()->route('grupIndex')->with('error', 'Data kategori berhasil dihapus!');
    }
}
