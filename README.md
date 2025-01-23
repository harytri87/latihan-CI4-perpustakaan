### Versi
[PHP 8.3.11](https://www.php.net/downloads.php)<br>
[MySQL 8.0.30](https://dev.mysql.com/downloads/installer/)<br>
[CodeIgniter 4.5.5](https://codeigniter.com)<br>
[Bootstrap 5.3.3](https://getbootstrap.com/docs/5.3/getting-started/download/) *(udh di-download, bisa offline)*

### Penjelasan web ini
(Web belum beres)
Pengguna dapat melihat semua buku yang ada di perpustakaan lalu menambahkannya ke wishlist. Saat pengguna / anggota perpustakaan datang ke perpustakaan ingin meminjam buku, pegawai perpustakaan mengecek wishlist anggota tersebut lalu mengkonfirmasi peminjaman bukunya.

Bila anggota perpustakaan ingin meminjam buku tetapi tidak tahu tentang web perpustakaan ini, maka pegawai akan mengecek apakah anggota tersebut sudah terdaftar. Jika sudah terdaftar maka bisa langsung masukan data peminjaman melalui halaman admin.

Untuk anggota perpustakaan yang tidak tahu tentang web ini, data email dan usernamenya diisi sembarang oleh pegawai/admin, passwordnya diisi "anggota12345".

### Info login buat ngetes webnya
1. Admin:
   - admin@example.net
   - admin12345
2. Pegawai:
   - dudungsurudung@example.net
   - dudung12345
3. Anggota:
   - dadangdaradang@example.net
   - dadang12345
   
*Info login yg lain ada di file seeder app\Database\Seeds\PenggunaSeeder.php*

*Penjelasan tambahan soal kategori ada di file app\Database\Seeds\KategoriSeeder.php*

### Catatan buat sendiri
*(kalo lupa)*
1. Edit / copas file env jadi .env
   - <code>CI_ENVIRONMENT = development</code>
   - *Uncomment* semua bagian <code>database.default</code>
   - Ubah nama database jadi: latihan-perpustakaan
2. Bikin database: latihan-perpustakaan
   - Manual atau *command*:
   - php spark db:create latihan-perpustakaan
3. php spark migrate<br>
   &nbsp;*(bikin table di dalem database)*
4. php spark db:seed SemuaSeeder<br>
   &nbsp;*(ngisi data di table)*
5. php spark serve<br>
   &nbsp;Terus masukin link localhost yg muncul itu ke browser
6. php spark<br>
   &nbsp;*(liat semua command)*

*semua php spark itu diketik di terminal / console yg udh masuk ke folder projek latihan ini*
