<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GrupSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'grup_nama'       => 'Admin',
                'grup_keterangan' => 'Mengatur semua'
            ],
            [
                'grup_nama'       => 'Pegawai',
                'grup_keterangan' => 'Pegawai perpustakaan'
            ],
            [
                'grup_nama'       => 'Anggota',
                'grup_keterangan' => 'Anggota perpustakaan'
            ]
        ];
		
		$this->db->table('grup')->insertBatch($data);
    }
}
