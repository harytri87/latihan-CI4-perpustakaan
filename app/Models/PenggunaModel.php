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
        'pengguna_email'    => 'required|max_length[254]|valid_email|is_unique[pengguna.pengguna_email]',
        'pengguna_username' => 'required|max_length[254]|is_unique[pengguna.pengguna_username]',
        'pengguna_password' => 'required|max_length[255]|min_length[8]',
        'password_ulang'    => 'required_with[pengguna_password]|max_length[255]|matches[pengguna_password]',
    ];
    protected $validationMessages   = [
        'pengguna_nama' => [
            'min_length'  => 'Nama Lengkap minimal 4 karakter'
        ],
        'pengguna_email' => [
            'valid_email' => 'Harap masukan email yang valid.',
            'is_unique'   => 'Email ini sudah terpakai.',
        ],
        'pengguna_username' => [
            'is_unique'   => 'Email ini sudah terpakai.',
        ],
        'pengguna_password' => [
            'min_length'  => 'Password minimal 8 karakter'
        ],
        'password_ulang' => [
            'matches'    => 'Password tidak sesuai.'
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
}
