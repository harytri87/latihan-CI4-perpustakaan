<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kategori_nama'    => 'Matematika',
                'kategori_link'    => 'matematika',
                'kategori_rincian' => 'Matematika secara umum.'
            ],
            [
                'kategori_nama'    => 'Fisika',
                'kategori_link'    => 'fisika',
                'kategori_rincian' => 'Fisika secara umum.'
            ],
            [
                'kategori_nama'    => 'Kimia',
                'kategori_link'    => 'kimia',
                'kategori_rincian' => 'Kimia secara umum.'
            ],
            [
                'kategori_nama'    => 'Biologi',
                'kategori_link'    => 'biologi',
                'kategori_rincian' => 'Biologi secara umum.'
            ],
            [
                'kategori_nama'    => 'Agama',
                'kategori_link'    => 'agama',
                'kategori_rincian' => 'Agama secara umum.'
            ],
            [
                'kategori_nama'    => 'Bahasa',
                'kategori_link'    => 'bahasa',
                'kategori_rincian' => 'Bahasa secara umum.'
            ],
            [
                'kategori_nama'    => 'Olahraga',
                'kategori_link'    => 'olahraga',
                'kategori_rincian' => 'Olahraga secara umum.'
            ],
            [
                'kategori_nama'    => 'Teknologi dan Teknik',
                'kategori_link'    => 'teknologi-dan-teknik',
                'kategori_rincian' => 'Teknologi dan Teknik secara umum.'
            ],
            [
                'kategori_nama'    => 'Seni',
                'kategori_link'    => 'seni',
                'kategori_rincian' => 'Seni secara umum.'
            ],
            [
                'kategori_nama'    => 'Fiksi',
                'kategori_link'    => 'fiksi',
                'kategori_rincian' => 'Fiksi secara umum.'
            ],
            [
                'kategori_nama'    => 'Novel',
                'kategori_link'    => 'novel',
                'kategori_rincian' => 'Novel secara umum.'
            ],
            [
                'kategori_nama'    => 'Komik',
                'kategori_link'    => 'komik',
                'kategori_rincian' => 'Komik secara umum.'
            ],
        ];

        // Masukkan data ke tabel
        $this->db->table('kategori')->insertBatch($data);
    }
}
