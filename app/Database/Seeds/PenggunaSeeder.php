<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'pengguna_email'    => 'asepkarasep@example.net',
                'pengguna_username' => 'asepkarasep',
                'pengguna_password' => password_hash('asep12345', PASSWORD_DEFAULT),
                'pengguna_nama'     => 'Asep Karasep',
                'grup_id'           => '1',
                'pengguna_status'   => 'Aktif',
            ],
            [
                'pengguna_email'    => 'ucupsurucup@example.net',
                'pengguna_username' => 'ucupsurucup',
                'pengguna_password' => password_hash('ucup12345', PASSWORD_DEFAULT),
                'pengguna_nama'     => 'Ucup Surucup',
                'grup_id'           => '2',
                'pengguna_status'   => 'Aktif',
            ],
            [
                'pengguna_email'    => 'dudungsurudung@example.net',
                'pengguna_username' => 'dudungsurudung',
                'pengguna_password' => password_hash('dudung12345', PASSWORD_DEFAULT),
                'pengguna_nama'     => 'Dudung Surudung',
                'grup_id'           => '2',
                'pengguna_status'   => 'Aktif',
            ],
            [
                'pengguna_email'    => 'otongsurotong@example.net',
                'pengguna_username' => 'otongsurotong',
                'pengguna_password' => password_hash('otong12345', PASSWORD_DEFAULT),
                'pengguna_nama'     => 'Otong Surotong',
                'grup_id'           => '3',
                'pengguna_status'   => 'Aktif',
            ],
            [
                'pengguna_email'    => 'dadangdaradang@example.net',
                'pengguna_username' => 'dadangdaradang',
                'pengguna_password' => password_hash('dadang12345', PASSWORD_DEFAULT),
                'pengguna_nama'     => 'Dadang Daradang',
                'grup_id'           => '3',
                'pengguna_status'   => 'Aktif',
            ],
            [
                'pengguna_email'    => 'udinsedunia@example.net',
                'pengguna_username' => 'udinsedunia',
                'pengguna_password' => password_hash('udin12345', PASSWORD_DEFAULT),
                'pengguna_nama'     => 'Udin Sedunia',
                'grup_id'           => '3',
                'pengguna_status'   => 'Berhenti',
            ],
        ];

        // Masukkan data ke tabel
        $this->db->table('pengguna')->insertBatch($data);
    }
}
