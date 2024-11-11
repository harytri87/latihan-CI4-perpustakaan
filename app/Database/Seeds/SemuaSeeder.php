<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SemuaSeeder extends Seeder
{
    public function run()
    {
        $this->call('GrupSeeder');
        $this->call('PenggunaSeeder');
        $this->call('KategoriSeeder');
        $this->call('BukuSeeder');
        $this->call('NomorSeriSeeder');
    }
}
