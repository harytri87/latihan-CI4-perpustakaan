<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table            = 'peminjaman';
    protected $primaryKey       = 'peminjaman_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['peminjaman_kode', 'peminjaman_durasi', 'peminjaman_tanggal', 'pengembalian_tanggal', 'seri_id', 'pengguna_id', 'peminjaman_status', 'pengembalian_status', 'denda', 'keterangan'];
    
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
        'peminjaman_kode'      => 'required|alpha_dash|max_length[15]',
        'peminjaman_durasi'    => 'required|numeric|max_length[5]',
        'peminjaman_tanggal'   => 'required|valid_date',
        'pengembalian_tanggal' => 'permit_empty|valid_date',
        'seri_id'              => 'required|numeric',
        'pengguna_id'          => 'required|numeric',
        'peminjaman_status'    => 'required|max_length[10]',
        'pengembalian_status'  => 'required_with[pengembalian_tanggal]|max_length[15]',
        'denda'                => 'permit_empty|numeric',
        'keterangan'           => 'required_with[denda]'
    ];
    protected $validationMessages   = [
        'peminjaman_kode'      => [
            'required'   => 'Kolom kode peminjaman harus diisi.',
            'alpha_dash' => 'Kode peminjaman hanya boleh alfabet, angka dan strip.',
            'max_length' => 'Kode peminjaman maksimal 15 karakter.'
        ],
        'peminjaman_durasi'      => [
            'required'   => 'Kolom jumlah hari peminjaman harus diisi.',
            'numeric'    => 'Jumlah hari peminjaman harus berupa angka.',
            'max_length' => 'Jumlah hari peminjaman maksimal 5 karakter.'
        ],
        'peminjaman_tanggal'   => [
            'required'   => 'Kolom tanggal peminjaman harus diisi.',
            'valid_date' => 'Tanggal peminjaman tidak valid.'
        ],
        'pengembalian_tanggal' => [
            'valid_date' => 'Tanggal pengembalian tidak valid.'
        ],
        'seri_id'              => [
            'required'   => 'Kolom id seri harus diisi.',
            'numeric'    => 'Jumlah id seri harus berupa angka.',
        ],
        'pengguna_id'          => [
            'required'   => 'Kolom id pengguna harus diisi.',
            'numeric'    => 'Jumlah id pengguna harus berupa angka.',
        ],
        'peminjaman_status'    => [
            'required'   => 'Kolom status peminjaman harus diisi.',
            'max_length' => 'Status peminjaman maksimal 10 karakter.'
        ],
        'pengembalian_status'  => [
            'required_with' => 'Status pengembalian harus diisi.',
            'max_length'    => 'Status pengembalian maksimal 15 karakter.'
        ],
        'denda'                => [
            'numeric'    => 'Kolom denda harus berupa angka.',
        ],
        'keterangan'  => [
            'required_with' => 'Keterangan harus diisi.'
        ],
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


    public function getPeminjaman($cari = "", $status = "", $peminjam = "")
    {
        // Semua peminjaman atau hasil pencarian

        $this->select('peminjaman.*, nomor_seri.isbn, nomor_seri.seri_kode, buku.buku_judul, buku.slug, buku.buku_foto, pengguna.pengguna_email, pengguna.pengguna_username, pengguna_nama, pengguna_foto, DATEDIFF(DATE_ADD(peminjaman.peminjaman_tanggal, INTERVAL peminjaman.peminjaman_durasi DAY), CURDATE()) AS sisa_hari')
             ->join('nomor_seri', 'peminjaman.seri_id = nomor_seri.seri_id', 'left')
             ->join('buku', 'nomor_seri.isbn = buku.isbn', 'left')
             ->join('pengguna', 'peminjaman.pengguna_id = pengguna.pengguna_id', 'left');

        if ($peminjam != "") {
            // Dari halaman rincian pengguna
            $this->groupStart()
                    ->where('pengguna.pengguna_username', $peminjam)
                 ->groupEnd();
        }     

        if ($status != "") {
            if ($status == "telat") {
                $this->groupStart()
                        ->where('peminjaman.peminjaman_status', 'dipinjam')
                        ->Where('DATEDIFF(DATE_ADD(peminjaman.peminjaman_tanggal, INTERVAL peminjaman.peminjaman_durasi DAY), CURDATE()) <', 0)
                     ->groupEnd();
            } else {
                $this->groupStart()
                        ->like('peminjaman.peminjaman_status', $status)
                        ->orLike('peminjaman.pengembalian_status', $status)
                     ->groupEnd();
            }
        }

		if ($cari != "") {
            $this->groupStart()
                    ->like('pengguna.pengguna_email', $cari)
                    ->orLike('pengguna.pengguna_nama', $cari)
                    ->orLike('peminjaman.peminjaman_kode', $cari)
                    ->orLike('buku.buku_judul', $cari)
                 ->groupEnd();
        }

        return $this->groupBy('peminjaman.peminjaman_id')
                    ->orderBy('peminjaman.peminjaman_id', "ASC")
                    ->paginate(20);
    }

    public function getSatuPeminjaman($peminjaman_id)
    {
        return $this->select('peminjaman.*, nomor_seri.isbn, nomor_seri.seri_kode, buku.buku_judul, buku.slug, buku.buku_foto, pengguna.pengguna_email, pengguna.pengguna_username, pengguna_nama, pengguna_foto, DATEDIFF(DATE_ADD(peminjaman.peminjaman_tanggal, INTERVAL peminjaman.peminjaman_durasi DAY), CURDATE()) AS sisa_hari')
                    ->join('nomor_seri', 'peminjaman.seri_id = nomor_seri.seri_id', 'left')
                    ->join('buku', 'nomor_seri.isbn = buku.isbn', 'left')
                    ->join('pengguna', 'peminjaman.pengguna_id = pengguna.pengguna_id', 'left')
                    ->where('peminjaman.peminjaman_id', $peminjaman_id)
                    ->groupBy('peminjaman.peminjaman_id')
                    ->first();
    }

    public function cekDuplikat($pengguna_id, $isbn)
    {
        // Ngecek buku yang sama udah ada di daftar wishlist pengguna tersebut

        return $this->select('peminjaman.*, nomor_seri.isbn')
                    ->join('nomor_seri', 'peminjaman.seri_id = nomor_seri.seri_id', 'left')
                    ->where(['peminjaman.pengguna_id' => $pengguna_id])
                    ->where(['nomor_seri.isbn' => $isbn])
                    ->where(['peminjaman.peminjaman_status' => 'dipinjam'])
                    ->countAllResults();
    }
}
