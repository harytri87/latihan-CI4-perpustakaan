<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableLengkap extends Migration
{
    public function up()
    {
        // Table grup
        $this->forge->addField([
            'grup_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'grup_nama'       => ['type' => 'varchar', 'constraint' => 50],
            'grup_keterangan' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('grup_id');
        $this->forge->createTable('grup');
        
        
        // Table pengguna
        $this->forge->addField([
            'pengguna_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pengguna_email'    => ['type' => 'varchar', 'constraint' => 100],
            'pengguna_username' => ['type' => 'varchar', 'constraint' => 255],
            'pengguna_password' => ['type' => 'varchar', 'constraint' => 255],
            'pengguna_nama'     => ['type' => 'varchar', 'constraint' => 255],
            'pengguna_foto'     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'grup_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => '3'],
            'pengguna_status'   => ['type' => 'varchar', 'constraint' => 30, 'default' => 'aktif'],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('pengguna_id');
        $this->forge->addUniqueKey(['pengguna_email', 'pengguna_username']);
        $this->forge->addForeignKey('grup_id', 'grup', 'grup_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengguna');
        
        // Table kategori
        $this->forge->addField([
            'kategori_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kategori_kode' => ['type' => 'varchar', 'constraint' => 20],
            'kategori_nama' => ['type' => 'varchar', 'constraint' => 255],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('kategori_id');
        $this->forge->addUniqueKey('kategori_kode');
        $this->forge->createTable('kategori');
        
        // Table buku
        $this->forge->addField([
            'buku_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'isbn'          => ['type' => 'varchar', 'constraint' => 20],
            'buku_judul'    => ['type' => 'varchar', 'constraint' => 255],
            'buku_penulis'  => ['type' => 'varchar', 'constraint' => 255],
            'buku_terbit'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'buku_sinopsis' => ['type' => 'text'],
            'kategori_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'slug'          => ['type' => 'varchar', 'constraint' => 255],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('buku_id');
        $this->forge->addUniqueKey('isbn');
        $this->forge->addForeignKey('kategori_id', 'kategori', 'kategori_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('buku');
        
        // Table nomor_seri
        $this->forge->addField([
            'seri_id'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'seri_kode'   => ['type' => 'varchar', 'constraint' => 20],
            'isbn'        => ['type' => 'varchar', 'constraint' => 20],
            'status_buku' => ['type' => 'varchar', 'constraint' => 255],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('seri_id');
        $this->forge->addUniqueKey('seri_kode');
        $this->forge->addForeignKey('isbn', 'buku', 'isbn', 'CASCADE', 'CASCADE');
        $this->forge->createTable('nomor_seri');
        
        // Table peminjaman
        $this->forge->addField([
            'peminjaman_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'peminjaman_kode'      => ['type' => 'varchar', 'constraint' => 20],
            'peminjaman_waktu'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'peminjaman_tanggal datetime default current_timestamp',
            'pengembalian_tanggal' => ['type' => 'datetime', 'null' => true],
            'seri_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'pengguna_id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'peminjaman_status'    => ['type' => 'varchar', 'constraint' => 255],
            'pengembalian_status'  => ['type' => 'varchar', 'constraint' => 255],
            'denda'                => ['type' => 'varchar', 'constraint' => 255, 'default' => 0]
        ]);
        $this->forge->addPrimaryKey('peminjaman_id');
        $this->forge->addUniqueKey('peminjaman_kode');
        $this->forge->addForeignKey('seri_id', 'nomor_seri', 'seri_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pengguna_id', 'pengguna', 'pengguna_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman');
        
        // Table wishlist
        $this->forge->addField([
            'wishlist_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'wishlist_kode' => ['type' => 'varchar', 'constraint' => 20],
            'seri_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'pengguna_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'status'        => ['type' => 'varchar', 'constraint' => 255],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('wishlist_id');
        $this->forge->addUniqueKey('wishlist_kode');
        $this->forge->addForeignKey('seri_id', 'nomor_seri', 'seri_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pengguna_id', 'pengguna', 'pengguna_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wishlist');
        
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable('grup');
        $this->forge->dropTable('pengguna');
        $this->forge->dropTable('kategori');
        $this->forge->dropTable('buku');
        $this->forge->dropTable('nomor_seri');
        $this->forge->dropTable('peminjaman');
        $this->forge->dropTable('wishlist');

        $this->db->enableForeignKeyChecks();
    }
}
