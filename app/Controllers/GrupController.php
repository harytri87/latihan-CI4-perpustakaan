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
        $model = new GrupModel();
        $data = [
            'grup_list' => $model->paginate(5),
            'pager'     => $model->pager,
            'title'     => 'Data Grup',
        ];

        return view('halaman/grup/index', $data);
    }

    // Ini ga kepake buat grup, sama kayak edit()
    public function show($grup_id = null)
    {
        $model = new GrupModel();
        $data['grup'] = $model->getGrup($grup_id);

        if ($data['grup'] === null) {
            throw new PageNotFoundException('Tidak dapat menemukan data grup: ' . $grup_id);
        }

        return view('halaman/grup/rincian', $data);
    }

    
    public function new()
    {
        helper('form');

        $data = [
            // 'news_list' => $model->getNews(),
            'title'     => 'Grup Baru | Perpustakaan',
        ];

        return view('halaman/grup/tambah', $data);
    }

    
    public function create()
    {
        helper('form');

        $grup = new GrupModel();

        // Ngambil semua data yg dikirimin dari post, termasuk csrf token sama method dari input hiddennya
        // Bisa langsung update pake $dataPost, bisa jg bikin variable baru yg isinya relevan buat table
        $dataPost = $this->request->getPost();
		$data = [
            // Pake penamaan_helper.php
			'grup_nama'       => formatJudul($dataPost['grup_nama']),
			'grup_keterangan' => $dataPost['grup_keterangan']
		];

        if ($grup->save($data) === false) {
            return view('halaman/grup/tambah', ['errors' => $grup->errors()]);
        }

        return redirect()->route('grupIndex')->with('message', 'Grup berhasil ditambahkan!');
    }

    
    public function edit($grup_id = null)
    {
        helper('form');

        $model = new GrupModel();
        $data['grup'] = $model->getGrup($grup_id);

        if ($data['grup'] === null) {
            throw new PageNotFoundException('Tidak dapat menemukan data grup: ' . $grup_id);
        }

        return view('halaman/grup/ubah', $data);
    }

    
    public function update($grup_id = null)
    {
        helper('form');

        $model = new GrupModel();
        // $data = $model->getGrup($grup_id);
        $data = $model->find($grup_id);
        // sama aja

        if (!$data) {
            return redirect()->route('grupIndex')->with('message', 'Data kategori tidak tersedia.');
        }

        $dataPost = $this->request->getPost();
		$data = [
			'grup_nama'       => formatJudul($dataPost['grup_nama']),
			'grup_keterangan' => $dataPost['grup_keterangan']
		];

        if ($model->update($grup_id, $data) === false) {
			return redirect()->back()->with('errors', $model->errors())->withInput();
		}

		return redirect()->route('grupIndex')->with('message', 'Data kategori berhasil dubah!');
    }

    
    public function delete($grup_id = null)
    {
        $model = new GrupModel();
        $data = $model->find($grup_id);

        if (!$data) {
            return redirect()->route('grupIndex')->with('message', 'Data kategori tidak tersedia.');
        }

        if ($model->delete($grup_id) === false) {
			return redirect()->back()->with('errors', $model->errors())->withInput();
		}

		return redirect()->route('grupIndex')->with('message', 'Data kategori berhasil dihapus!');
    }
}
