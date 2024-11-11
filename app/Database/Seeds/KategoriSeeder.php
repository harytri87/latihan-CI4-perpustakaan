<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
		// Harusnya ada table sub-kategori atau table ini dilengkapin datanya. Tapi males
        // Sumber lengkapnya:
		// https://en.wikipedia.org/wiki/List_of_Dewey_Decimal_classes

		// Contoh penulisan nomor seri
		// 000 UDI mj 3
		// 000: kode kategori
		// UDI: 3 huruf dari nama penulis Udin Sedunia
		// mj:   1 huruf kata pertama & 1 huruf kata kedua judul buku Menangkap dan Melatih Jangkrik
		// 3:   buku ketiga dari semua buku yang sama yang ada di perpustakaan

        $data = [
            [
				'kategori_kode'	   => '000',
                'kategori_nama'    => 'Komputer, Informasi, dan Referensi Umum',
                'kategori_link'    => 'komputer-informasi-dan-referensi-umum',
                'kategori_rincian' => 'Mencakup teknologi informasi, bibliografi, ensiklopedia, dan karya umum lainnya.'
            ],
            [
				'kategori_kode'	   => '100',
                'kategori_nama'    => 'Filsafat dan Psikologi',
                'kategori_link'    => 'filsafat-dan-psikologi',
                'kategori_rincian' => 'Mencakup filsafat, psikologi, etika, dan pemikiran manusia.'
            ],
            [
				'kategori_kode'	   => '200',
                'kategori_nama'    => 'Agama',
                'kategori_link'    => 'agama',
                'kategori_rincian' => 'Mencakup berbagai agama, kitab suci, dan pemikiran teologis.'
            ],
            [
				'kategori_kode'	   => '300',
                'kategori_nama'    => 'Ilmu Sosial',
                'kategori_link'    => 'ilmu-sosial',
                'kategori_rincian' => 'Mencakup sosiologi, politik, ekonomi, dan sejarah sosial.'
            ],
            [
				'kategori_kode'	   => '400',
                'kategori_nama'    => 'Bahasa',
                'kategori_link'    => 'bahasa',
                'kategori_rincian' => 'Mencakup linguistik, pembelajaran bahasa, dan sastra bahasa.'
            ],
            [
				'kategori_kode'	   => '500',
                'kategori_nama'    => 'Sains dan Matematika',
                'kategori_link'    => 'sains-dan-matematika',
                'kategori_rincian' => 'Mencakup fisika, kimia, biologi, matematika, dan ilmu terkait.'
            ],
            [
				'kategori_kode'	   => '600',
                'kategori_nama'    => 'Teknologi dan Ilmu Terapan',
                'kategori_link'    => 'teknologi-dan-ilmu-terapan',
                'kategori_rincian' => 'Mencakup kesehatan, pertanian, dan teknologi terapan lainnya.'
            ],
            [
				'kategori_kode'	   => '700',
                'kategori_nama'    => 'Kesenian dan Rekreasi',
                'kategori_link'    => 'kesenian-dan-rekreasi',
                'kategori_rincian' => 'Mencakup seni rupa, musik, teater, serta kegiatan rekreasi.'
            ],
            [
				'kategori_kode'	   => '800',
                'kategori_nama'    => 'Sastra',
                'kategori_link'    => 'sastra',
                'kategori_rincian' => 'Mencakup puisi, prosa, drama, dan karya sastra lainnya.'
            ],
            [
				'kategori_kode'	   => '900',
                'kategori_nama'    => 'Sejarah dan Geografi',
                'kategori_link'    => 'sejarah-dan-geografi',
                'kategori_rincian' => 'Mencakup sejarah dunia, geografi, budaya, dan tradisi.'
            ],
        ];

        // Masukkan data ke tabel
        $this->db->table('kategori')->insertBatch($data);
    }
}
