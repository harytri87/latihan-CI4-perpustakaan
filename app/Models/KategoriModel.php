<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'kategori_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kategori_kode', 'kategori_nama', 'kategori_rincian', 'kategori_link'];

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
        'kategori_kode'    => 'required|min_length[3]|max_length[20]|is_unique[kategori.kategori_kode]',
        'kategori_nama'    => 'required|min_length[4]|max_length[100]',
        'kategori_rincian' => 'required|min_length[8]|max_length[255]',
        'kategori_link'    => 'required|min_length[4]|max_length[100]|is_unique[kategori.kategori_link,kategori_id,{kategori_id}]'
    ];
    protected $validationMessages   = [
        'kategori_kode' => [
            'required'  => 'Harap isi kolom kode',
            'min_length'=> 'Kolom kode minimal 3 karakter',
            'max_length'=> 'Kolom kode maksimal 20 karakter',
            'is_unique' => 'Tidak dapat memasukan kode yang sudah ada'
        ],
        'kategori_nama' => [
            'required'  => 'Harap isi kolom nama',
            'min_length'=> 'Kolom nama minimal 4 karakter',
            'max_length'=> 'Kolom nama maksimal 100 karakter'
        ],
        'kategori_rincian' => [
            'required'  => 'Harap isi kolom rincian',
            'min_length'=> 'Kolom rincian minimal 8 karakter',
            'max_length'=> 'Kolom rincian maksimal 255 karakter'
        ],
        'kategori_link' => [
            'required'  => 'Harap isi kolom nama link',    // Ini ga bakal muncul di form. Tapi jaga2 aja.
            'min_length'=> 'Kolom nama link minimal 4 karakter',
            'max_length'=> 'Kolom nama link maksimal 100 karakter',
            'is_unique' => 'Tidak dapat membuat kategori yang serupa'
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

    
	public function getKategori(string $kategori_link = null)
	{
       if ($kategori_link !== null) {
            return $this->where(['kategori_link' => $kategori_link])->first();
		}

        return $this->orderBy('kategori_kode')->paginate(20);
	}

    public function cariKategori(string $cari)
    {
        $this->like('kategori_nama', $cari);
        $this->orLike('kategori_kode', $cari);
        $this->orLike('kategori_rincian', $cari);

        return $this->orderBy('kategori_kode')->paginate(20);
    }
}
