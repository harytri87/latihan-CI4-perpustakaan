<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'pengguna_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'pengguna_email', 'pengguna_username', 'pengguna_password', 'pengguna_nama', 'pengguna_foto', 'grup_id', 'pengguna_status',
    ];

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
        'pengguna_nama'     => 'required|min_length[4]',
        'pengguna_email'    => 'required|min_length[8]|max_length[254]|valid_email|is_unique[pengguna.pengguna_email]',
        'pengguna_username' => 'required|min_length[4]|max_length[254]|is_unique[pengguna.pengguna_username]',
        'pengguna_password' => 'required|min_length[8]|max_length[255]',
        // 'password_ulang'    => 'matches[pengguna_password]',
        // 'pengguna_foto'     => 'is_image[pengguna_foto]|mime_in[pengguna_foto,image/jpg,image/jpeg,image/png,image/webp]|max_size[pengguna_foto,100]|max_dims[pengguna_foto,1024,768]'

        // Yang dikomen itu validasinya ribet kalo lewat sini
    ];
    protected $validationMessages   = [
        'pengguna_nama' => [
            'required'    => 'Harap isi kolom nama.',
            'min_length'  => 'Nama Lengkap minimal 4 karakter'
        ],
        'pengguna_email' => [
            'required'    => 'Harap isi kolom email.',
            'min_length'  => 'Email minimal 8 karakter',
            'valid_email' => 'Harap isi kolom email yang valid.',
            'is_unique'   => 'Email ini sudah terpakai.'
        ],
        'pengguna_username' => [
            'required'    => 'Harap isi kolom username.',
            'min_length'  => 'Username minimal 4 karakter',
            'is_unique'   => 'Username ini sudah terpakai.'
        ],
        'pengguna_password' => [
            'required'    => 'Harap isi kolom password.',
            'min_length'  => 'Password minimal 8 karakter'
        ],
        // 'password_ulang' => [
        //     'matches'       => 'Password tidak sesuai'
        // ],
        // 'pengguna_foto' => [
        //     // 'uploaded'    => 'Harap pilih foto profil',  // mirip required
        //     'is_image'    => 'Harap pilih gambar foto profil',
        //     'mime_in'     => 'File gambar tidak didukung',
        //     'max_size'    => 'File gambar maksimal 100 KB',
        //     'max_dims'    => 'Resolusi gambar maksimal 1024x768 pixel'
        // ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    
	public function getPengguna(string $pengguna_username = null)
	{
        $this->select('*')->join('grup', 'grup.grup_id = pengguna.grup_id')->orderBy('pengguna.grup_id, pengguna.pengguna_nama');
    
		if ($pengguna_username !== null) {
            return $this->where(['pengguna_username' => $pengguna_username])->first();
		}

        return $this->paginate(20);
	}

    public function cariPengguna(string $cari)
    {
        $this->select('*')->join('grup', 'grup.grup_id = pengguna.grup_id')->orderBy('pengguna.grup_id, pengguna.pengguna_nama');
        $this->like('pengguna_email', $cari);
        $this->orLike('pengguna_nama', $cari);

        return $this->paginate(20);
    }

    public function getAktifBukanAdmin()
    {
        return $this->where('grup_id !=', 1)
                    ->where('pengguna_status', 'aktif')
                    ->findAll();
    }
}
