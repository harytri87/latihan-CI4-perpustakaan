<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table            = 'wishlist';
    protected $primaryKey       = 'wishlist_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['seri_id', 'pengguna_id', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'seri_id'     => 'required|numeric',
        'pengguna_id' => 'required|numeric',
        'status'      => 'required|min_length[8]'
    ];
    protected $validationMessages   = [
        'seri_id'   => [
            'required' => 'Kolom seri_id harus diisi.', 
            'numeric'  => 'Kolom seri_id harus berupa angka.'
        ],
        'pengguna_id'        => [
            'required' => 'Kolom pengguna_id harus diisi.', 
            'numeric'  => 'Kolom pengguna_id harus berupa angka.'
        ],
        'status' => [
            'required'   => 'Kolom status harus diisi.', 
            'min_length' => 'Kolom status wishlist minimal 8 karakter.'
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


    public function getWishlist($cari = "", $status = "")
    {
        // Semua wishlist atau hasil pencarian

        $this->select('wishlist.*, nomor_seri.isbn, buku.buku_judul, buku.slug, buku.buku_foto, pengguna.pengguna_email')
             ->join('nomor_seri', 'wishlist.seri_id = nomor_seri.seri_id', 'left')
             ->join('buku', 'nomor_seri.isbn = buku.isbn', 'left')
             ->join('pengguna', 'wishlist.pengguna_id = pengguna.pengguna_id', 'left');
             

        if ($status != "") {
            $this->groupStart()
                    ->where('wishlist.status', $status)
                 ->groupEnd();
        }

		if ($cari != "") {
            $this->groupStart()
                    ->like('nomor_seri.isbn', $cari, 'both')
                    ->orLike('buku.buku_judul', $cari)
                    ->orLike('pengguna.pengguna_email', $cari)
                 ->groupEnd();
        }

        return $this->groupBy('wishlist.wishlist_id')
                    ->orderBy('pengguna.pengguna_email', "ASC")
                    ->paginate(20);
    }

    public function wishlistPengguna($pengguna_id)
    {
        return $this->select('wishlist.*, nomor_seri.seri_kode, nomor_seri.isbn, buku.buku_judul, buku.slug, buku.buku_foto, pengguna.pengguna_email, pengguna.pengguna_username')
                    ->join('nomor_seri', 'wishlist.seri_id = nomor_seri.seri_id', 'left')
                    ->join('buku', 'nomor_seri.isbn = buku.isbn', 'left')
                    ->join('pengguna', 'wishlist.pengguna_id = pengguna.pengguna_id', 'left')
                    ->where(['wishlist.pengguna_id' => $pengguna_id])
                    ->findAll();
    }

    public function cekDuplikat($pengguna_id, $isbn)
    {
        return $this->select('wishlist.*, nomor_seri.isbn')
                    ->join('nomor_seri', 'wishlist.seri_id = nomor_seri.seri_id', 'left')
                    ->where(['wishlist.pengguna_id' => $pengguna_id])
                    ->where(['nomor_seri.isbn' => $isbn])
                    ->countAllResults();
    }


    public function getByStatus($status, $pengguna_id)
    {
        // Ngambil data wishlist dari 1 pengguna buat dimasukin ke table peminjaman
        
        return $this->where(['status' => $status])
                    ->where(['pengguna_id' => $pengguna_id])
                    ->findAll();
    }

}
