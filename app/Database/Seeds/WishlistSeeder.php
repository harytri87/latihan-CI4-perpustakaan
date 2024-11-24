<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WishlistSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'seri_id' => '4',
                'pengguna_id' => '5',
                'status' => 'wishlist'
            ],
            [
                'seri_id' => '9',
                'pengguna_id' => '5',
                'status' => 'wishlist'
            ],
            [
                'seri_id' => '14',
                'pengguna_id' => '6',
                'status' => 'wishlist'
            ],
        ];
		
		$this->db->table('wishlist')->insertBatch($data);
    }
}
