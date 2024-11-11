<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'buku_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['isbn', 'buku_judul', 'buku_penulis', 'buku_terbit', 'buku_sinopsis', 'kategori_id', 'buku_foto', 'slug'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'isbn'          => 'required|exact_length[13]|is_unique[buku.isbn]',
        'buku_judul'    => 'required|min_length[4]|max_length[255]',
        'buku_penulis'  => 'required|min_length[4]|max_length[255]',
        'buku_terbit'   => 'required|exact_length[4]|numeric|greater_than[1900]|less_than[2024]',
        'buku_sinopsis' => 'required|min_length[30]',
        'kategori_id'   => 'required|is_natural_no_zero',
        'buku_foto'     => 'required|min_length[4]',
        'slug'          => 'required|min_length[4]|max_length[255]|is_unique[buku.slug]'
    ];
    protected $validationMessages   = [
        'isbn' => [
            'required'     => 'Kolom ISBN harus diisi',
            'exact_length' => 'ISBN harus 13 angka',
            'is_unique'    => 'Tidak dapat memasukan ISBN yang sudah ada'
        ],
        'buku_judul' => [
            'required'     => 'Kolom judul buku harus diisi',
            'min_length'   => 'Kolom judul minimal 4 karakter',
            'max_length'   => 'Kolom judul maksimal 255 karakter',
        ],
        'buku_penulis' => [
            'required'     => 'Kolom penulis buku harus diisi',
            'min_length'   => 'Kolom penulis minimal 4 karakter',
            'max_length'   => 'Kolom penulis maksimal 255 karakter',
        ],
        'buku_terbit' => [
            'required'     => 'Kolom tahun terbit harus diisi',
            'exact_length' => 'Kolom tahun terbit harus 4 karakter',
            'numeric'      => 'Kolom tahun terbit harus berupa angka',
            'greater_than' => 'Tahun terbit tidak bisa kurang dari tahun segitu',
            'less_than'    => 'Tahun terbit tidak bisa lebih dari tahun sekarang'

        ],
        'buku_sinopsis' => [
            'required'     => 'Kolom sinopsis harus diisi',
            'min_length'   => 'Kolom sinopsis minimal 30 karakter'
        ],
        'kategori_id' => [
            'required'           => 'Kolom kategori harus diisi',
            'is_natural_no_zero' => 'Kolom kategori harus berupa angka'
        ],
        'buku_foto' => [
            'required'     => 'Foto harus diisi',
            'min_length'   => 'Kolom foto minimal 4 karakter'
        ],
        'slug' => [
            'required'     => 'Kolom link judul harus diisi',
            'min_length'   => 'Kolom link judul minimal 4 karakter',
            'max_length'   => 'Kolom link judul maksimal 255 karakter',
            'is_unique'    => 'Tidak dapat membuat data buku yang serupa'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getBuku($cari = "", $kategori = "")
    {
        // Semua buku atau hasil pencarian

        $this->select('buku.*, kategori.kategori_kode, kategori.kategori_nama, COUNT(nomor_seri.seri_id) AS jumlah_buku')
             ->join('nomor_seri', 'buku.isbn = nomor_seri.isbn', 'left')
             ->join('kategori', 'buku.kategori_id = kategori.kategori_id', 'left');
             

        if ($kategori != "") {
            $this->groupStart()
                    ->where('kategori.kategori_kode', $kategori)
                 ->groupEnd();
        }

		if ($cari != "") {
            $this->groupStart()
                    ->like('buku.isbn', $cari, 'both')
                    ->orLike('buku.buku_judul', $cari)
                    ->orLike('buku.buku_penulis', $cari)
                 ->groupEnd();
        }

        return $this->groupBy('buku.buku_id')
                    ->orderBy('buku.buku_judul', "ASC")
                    ->paginate(20);
    }

    public function satuBuku($slug)
    {
        // Satu buku, rinciannya

        return $this->select('buku.*, kategori.kategori_kode, kategori.kategori_nama, COUNT(nomor_seri.seri_id) AS jumlah_buku')
                    ->join('nomor_seri', 'buku.isbn = nomor_seri.isbn', 'left')
                    ->join('kategori', 'buku.kategori_id = kategori.kategori_id', 'left')
                    ->where(['buku.slug' => $slug])
                    ->groupBy('buku.buku_id')
                    ->first();
    }
}
