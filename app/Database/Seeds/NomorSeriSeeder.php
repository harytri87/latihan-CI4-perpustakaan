<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NomorSeriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'seri_kode'   => '000 SAT bk 1',
                'isbn'        => '1111111111111',
                'status_buku' => 'tersedia' // gudang / tersedia (dipajang di rak buku) / dipinjam / rusak / hilang
            ],
            [
                'seri_kode'   => '000 SAT bk 2',
                'isbn'        => '1111111111111',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '000 SAT bk 3',
                'isbn'        => '1111111111111',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '100 DUA bf 1',
                'isbn'        => '2222222222222',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '200 TIG ba 1',
                'isbn'        => '3333333333333',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '200 TIG ba 2',
                'isbn'        => '3333333333333',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '200 TIG ba 3',
                'isbn'        => '3333333333333',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '200 TIG ba 4',
                'isbn'        => '3333333333333',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '300 EMP bis 1',
                'isbn'        => '4444444444444',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '300 EMP bis 2',
                'isbn'        => '4444444444444',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '300 EMP bis 3',
                'isbn'        => '4444444444444',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '300 EMP bis 4',
                'isbn'        => '4444444444444',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '300 EMP bis 5',
                'isbn'        => '4444444444444',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '400 LIM bb 1',
                'isbn'        => '5555555555555',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '400 LIM bb 2',
                'isbn'        => '5555555555555',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '500 ENA bs 1',
                'isbn'        => '6666666666666',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '600 TUJ bt 1',
                'isbn'        => '7777777777777',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '600 TUJ bt 2',
                'isbn'        => '7777777777777',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '600 TUJ bt 3',
                'isbn'        => '7777777777777',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '600 TUJ bt 4',
                'isbn'        => '7777777777777',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '700 DEL bk 1',
                'isbn'        => '8888888888888',
                'status_buku' => 'tersedia'
            ],
            [
                'seri_kode'   => '700 DEL bk 2',
                'isbn'        => '8888888888888',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '800 SEM bs 1',
                'isbn'        => '9999999999999',
                'status_buku' => 'tersedia'
            ],
            // 
            [
                'seri_kode'   => '900 SEP bs 1',
                'isbn'        => '1010101010101',
                'status_buku' => 'tersedia'
            ],
            // 
        ];

        // Masukkan data ke tabel
        $this->db->table('nomor_seri')->insertBatch($data);
    }
}
