<?php

namespace App\Models;

use CodeIgniter\Model;

class NomorSeriModel extends Model
{
    protected $table            = 'nomor_seri';
    protected $primaryKey       = 'seri_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['seri_kode', 'isbn', 'status_buku'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'seri_kode'   => 'required|min_length[9]|is_unique[nomor_seri.seri_kode]',
        'isbn'        => 'required|exact_length[13]',
        'status_buku' => 'required|min_length[5]'
    ];
    protected $validationMessages   = [
        'seri_kode'   => [
            'required'   => 'Kolom seri_kode harus diisi.', 
            'min_length' => 'Kolom seri_kode minimal karakter.',
            'is_unique'  => 'Tidak dapat menggunakan kode yang sudah ada'
        ],
        'isbn'        => [
            'required'     => 'Kolom ISBN harus diisi.', 
            'exact_length' => 'Kolom ISBN harus berisi 13 angka.'
        ],
        'status_buku' => [
            'required'   => 'Kolom status buku harus diisi.', 
            'min_length' => 'Kolom status buku minimal 5 karakter.'
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

    
	public function getNomorSeri($cari = "", $status = "")
	{
        $this->select('nomor_seri.*, buku.buku_judul, buku.slug, buku_foto')
             ->join('buku', 'nomor_seri.isbn = buku.isbn', 'left');

        if ($status != "") {
            $this->groupStart()
                    ->where('nomor_seri.status_buku', $status)
                 ->groupEnd();
        }
    
        if ($cari != "") {
            $this->groupStart()
                    ->like('nomor_seri.seri_kode', $cari, 'both')
                    ->orLike('nomor_seri.isbn', $cari, 'both')
                    ->orLike('buku.buku_judul', $cari, 'both')
                 ->groupEnd();
        }

        return $this->groupBy('nomor_seri.seri_id')
                    ->orderBy('buku.buku_judul', "ASC");
	}
    public function satuNomorSeri($kode)
    {
        return $this->select('nomor_seri.*, buku.buku_judul, buku.slug, buku_foto')
                    ->join('buku', 'nomor_seri.isbn = buku.isbn', 'left')
                    ->where(['nomor_seri.seri_kode' => $kode])
                    ->groupBy('nomor_seri.seri_id')
                    ->first();
    }

    public function satuISBNStatus($isbn, $status)
    {
        return $this->select('nomor_seri.*, buku.buku_judul, buku.slug, buku_foto')
                    ->join('buku', 'nomor_seri.isbn = buku.isbn', 'left')
                    ->where(['nomor_seri.isbn' => $isbn])
                    ->where(['nomor_seri.status_buku' => $status])
                    ->groupBy('nomor_seri.seri_id')
                    ->first();
    }

    public function getISBN($isbn)
    {
        return $this->where(['isbn' => $isbn])->findAll();
    }

    public function countTersedia($isbn)
    {
        return $this->where('status_buku', 'tersedia')
                    ->where('isbn', $isbn)
                    ->countAllResults();
    }

    public function getMaxKode($isbn)
    {
        return $this->selectMax('seri_kode')
                    ->where('isbn', $isbn)
                    ->first();
    }
}
