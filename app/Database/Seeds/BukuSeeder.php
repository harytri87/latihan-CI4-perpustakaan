<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run()
    {
        // Males ngarang nama & biar bisa copy paste jadi nama penulisnya angka

        $data = [
            [
                'isbn'          => '1111111111111',
                'buku_judul'    => 'Buku Komputer',
                'buku_penulis'  => 'Satu Penulis',
                'buku_terbit'   => '2011',
                'buku_sinopsis' => 'Sinopsis buku Komputer Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '1',
                'buku_foto'     => 'buku-komputer.jpg',
                'slug'          => 'buku-komputer'
            ],
            [
                'isbn'          => '2222222222222',
                'buku_judul'    => 'Buku Filsafat',
                'buku_penulis'  => 'Dua Penulis',
                'buku_terbit'   => '2012',
                'buku_sinopsis' => 'Sinopsis buku Filsafat Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '2',
                'buku_foto'     => 'buku-filsafat.jpg',
                'slug'          => 'buku-filsafat'
            ],
            [
                'isbn'          => '3333333333333',
                'buku_judul'    => 'Buku Agama',
                'buku_penulis'  => 'Tiga Penulis',
                'buku_terbit'   => '2013',
                'buku_sinopsis' => 'Sinopsis buku Agama Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '3',
                'buku_foto'     => 'buku-agama.jpg',
                'slug'          => 'buku-agama'
            ],
            [
                'isbn'          => '4444444444444',
                'buku_judul'    => 'Buku Ilmu Sosial',
                'buku_penulis'  => 'Empat Penulis',
                'buku_terbit'   => '2014',
                'buku_sinopsis' => 'Sinopsis buku Ilmu Sosial Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '4',
                'buku_foto'     => 'buku-ilmu-sosial.jpg',
                'slug'          => 'buku-ilmu-sosial'
            ],
            [
                'isbn'          => '5555555555555',
                'buku_judul'    => 'Buku Bahasa',
                'buku_penulis'  => 'Lima Penulis',
                'buku_terbit'   => '2015',
                'buku_sinopsis' => 'Sinopsis buku Bahasa Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '5',
                'buku_foto'     => 'buku-bahasa.jpg',
                'slug'          => 'buku-bahasa'
            ],
            [
                'isbn'          => '6666666666666',
                'buku_judul'    => 'Buku Sains',
                'buku_penulis'  => 'Enam Penulis',
                'buku_terbit'   => '2016',
                'buku_sinopsis' => 'Sinopsis buku Sains Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '6',
                'buku_foto'     => 'buku-sains.jpg',
                'slug'          => 'buku-sains'
            ],
            [
                'isbn'          => '7777777777777',
                'buku_judul'    => 'Buku Teknologi',
                'buku_penulis'  => 'Tujuh Penulis',
                'buku_terbit'   => '2017',
                'buku_sinopsis' => 'Sinopsis buku Teknologi Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '7',
                'buku_foto'     => 'buku-teknologi.jpg',
                'slug'          => 'buku-teknologi'
            ],
            [
                'isbn'          => '8888888888888',
                'buku_judul'    => 'Buku Kesenian',
                'buku_penulis'  => 'Delapan Penulis',
                'buku_terbit'   => '2018',
                'buku_sinopsis' => 'Sinopsis buku Kesenian Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '8',
                'buku_foto'     => 'buku-kesenian.jpg',
                'slug'          => 'buku-kesenian'
            ],
            [
                'isbn'          => '9999999999999',
                'buku_judul'    => 'Buku Sastra',
                'buku_penulis'  => 'Sembilan Penulis',
                'buku_terbit'   => '2019',
                'buku_sinopsis' => 'Sinopsis buku Sastra Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '9',
                'buku_foto'     => 'buku-sastra.jpg',
                'slug'          => 'buku-sastra'
            ],
            [
                'isbn'          => '1010101010101',
                'buku_judul'    => 'Buku Sejarah',
                'buku_penulis'  => 'Sepuluh Penulis',
                'buku_terbit'   => '2020',
                'buku_sinopsis' => 'Sinopsis buku Sejarah Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis vitae cupiditate aspernatur ad sed veniam dignissimos commodi repellendus doloribus? Ab, harum. Voluptatem adipisci nulla, minus deleniti excepturi quam laudantium et!',
                'kategori_id'   => '10',
                'buku_foto'     => 'buku-sejarah.jpg',
                'slug'          => 'buku-sejarah'
            ],
        ];

        // Masukkan data ke tabel
        $this->db->table('buku')->insertBatch($data);
    }
}
