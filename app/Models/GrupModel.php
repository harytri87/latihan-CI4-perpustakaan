<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupModel extends Model
{
    protected $table            = 'grup';
    protected $primaryKey       = 'grup_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['grup_nama', 'grup_keterangan'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    /* Ini true sama false sama aja kalo di table / migrationnya bikin:
     *  'created_at datetime default current_timestamp',
     *  'updated_at datetime default current_timestamp on update current_timestamp'
     * Kecuali cuma nentuin formatnya aja, ga ditambahin default baru fitur dates
     * di bawah ngaruh. Mungkin kepakenya kalo fitur soft delete diaktifin ya?
     */

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'grup_nama'       => 'required|min_length[4]',
        'grup_keterangan' => 'required|min_length[8]',
    ];
    protected $validationMessages   = [
        'grup_nama' => [
            'required'   => 'Harap masukan nama grup.',
            'min_length' => 'Nama grup minimal 4 karakter.'
        ],
        'grup_keterangan' => [
            'required'   => 'Harap masukan keterangan grup.',
            'min_length' => 'Keterangan grup minimal 8 karakter.'
        ],
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

    
	public function getGrup($grup_id = false)
	{
		if ($grup_id === false) {
			return $this->findAll();
		}

		return $this->where(['grup_id' => $grup_id])->first();
	}
}
