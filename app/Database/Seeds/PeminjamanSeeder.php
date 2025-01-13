<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        $waktu = new Time();
        $tanggalKode = $waktu->toLocalizedString('ddMMyyyy');
        $tanggalDefault = $waktu->toLocalizedString('yyyy-MM-dd HH:mm:ss');
        $sisa1Hari = Time::parse("now -6 days");
        $sisa1HariKode = $sisa1Hari->toLocalizedString('ddMMyyyy');
        $sisa1HariTanggal = $sisa1Hari->toLocalizedString('yyyy-MM-dd HH:mm:ss');
        $sisa0Hari = Time::parse("now -7 days");
        $sisa0HariKode = $sisa0Hari->toLocalizedString('ddMMyyyy');
        $sisa0HariTanggal = $sisa0Hari->toLocalizedString('yyyy-MM-dd HH:mm:ss');

        $data = [
            [
                'peminjaman_kode'      => '3-01092024',
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => '2024-09-01 12:37:06',
                'pengembalian_tanggal' => '2024-09-07 12:37:06',
                'seri_id'              => '24',
                'pengguna_id'          => '3',
                'peminjaman_status'    => 'selesai',        // dipinjam / selesai
                'pengembalian_status'  => 'tepat waktu',    // tepat waktu / terlambat / rusak (+ keterangan)
                'denda'                => '0',
                'keterangan'           => NULL
            ],
            [
                'peminjaman_kode'      => '7-18092024',
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => '2024-09-18 10:37:12',
                'pengembalian_tanggal' => '2024-10-18 10:37:12',
                'seri_id'              => '19',
                'pengguna_id'          => '7',
                'peminjaman_status'    => 'selesai',
                'pengembalian_status'  => 'rusak',
                'denda'                => '63000',
                'keterangan'           => 'Terlambat 23 hari, denda Rp 23.000. Rusak, denda Rp 40.000.'
            ],
            [
                'peminjaman_kode'      => '7-18092024',
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => '2024-09-18 10:37:12',
                'pengembalian_tanggal' => NULL,
                'seri_id'              => '9',
                'pengguna_id'          => '7',
                'peminjaman_status'    => 'dipinjam',
                'pengembalian_status'  => NULL,
                'denda'                => '0',
                'keterangan'           => NULL
            ],
            [
                'peminjaman_kode'      => '5-14102024',
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => '2024-10-14 08:20:41',
                'pengembalian_tanggal' => '2024-10-19 14:53:01',
                'seri_id'              => '23',
                'pengguna_id'          => '5',
                'peminjaman_status'    => 'selesai',
                'pengembalian_status'  => 'tepat waktu',
                'denda'                => '0',
                'keterangan'           => NULL
            ],
            [
                'peminjaman_kode'      => '6-01112024',
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => '2024-11-01 13:45:41',
                'pengembalian_tanggal' => '2024-11-10 14:53:01',
                'seri_id'              => '23',
                'pengguna_id'          => '5',
                'peminjaman_status'    => 'selesai',
                'pengembalian_status'  => 'terlambat',
                'denda'                => '2000',
                'keterangan'           => 'Terlambat 2 hari, denda Rp 2.000.'
            ],
            [
                'peminjaman_kode'      => '2-06122024',
                'peminjaman_durasi'    => '14',
                'peminjaman_tanggal'   => '2024-12-06 13:45:41',
                'pengembalian_tanggal' => '2024-12-20 13:45:41',
                'seri_id'              => '7',
                'pengguna_id'          => '2',
                'peminjaman_status'    => 'selesai',
                'pengembalian_status'  => 'tepat waktu',
                'denda'                => '0',
                'keterangan'           => NULL
            ],
            [
                'peminjaman_kode'      => '4-' . $sisa0HariKode,
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => $sisa0HariTanggal,
                'pengembalian_tanggal' => NULL,
                'seri_id'              => '7',
                'pengguna_id'          => '4',
                'peminjaman_status'    => 'dipinjam',
                'pengembalian_status'  => NULL,
                'denda'                => '0',
                'keterangan'           => NULL
            ],
            [
                'peminjaman_kode'      => '3-' . $sisa1HariKode,
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => $sisa1HariTanggal,
                'pengembalian_tanggal' => NULL,
                'seri_id'              => '10',
                'pengguna_id'          => '3',
                'peminjaman_status'    => 'dipinjam',
                'pengembalian_status'  => NULL,
                'denda'                => '0',
                'keterangan'           => NULL
            ],
            [
                'peminjaman_kode'      => '5-' . $tanggalKode,
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => $tanggalDefault,
                'pengembalian_tanggal' => NULL,
                'seri_id'              => '24',
                'pengguna_id'          => '5',
                'peminjaman_status'    => 'dipinjam',
                'pengembalian_status'  => NULL,
                'denda'                => '0',
                'keterangan'           => NULL
            ],
            [
                'peminjaman_kode'      => '6-' . $tanggalKode,
                'peminjaman_durasi'    => '7',
                'peminjaman_tanggal'   => $tanggalDefault,
                'pengembalian_tanggal' => NULL,
                'seri_id'              => '22',
                'pengguna_id'          => '6',
                'peminjaman_status'    => 'dipinjam',
                'pengembalian_status'  => NULL,
                'denda'                => '0',
                'keterangan'           => NULL
            ],
        ];
		
		$this->db->table('peminjaman')->insertBatch($data);
    }
}
