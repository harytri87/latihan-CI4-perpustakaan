### Versi
[PHP 8.3.11](https://www.php.net/downloads.php)<br>
[MySQL 8.0.30](https://dev.mysql.com/downloads/installer/)<br>
[CodeIgniter 4.5.5](https://codeigniter.com)<br>
[Bootstrap 5.3.3](https://getbootstrap.com/docs/5.3/getting-started/download/)

### Info login buat ngetes webnya
1. Admin:
   - admin@example.net
   - admin123
2. Anggota:
   - dudungsurudung@example.net
   - dudung123
   
*Info login yg lain ada di file seeder*

### Catatan buat sendiri
*(kalo lupa)*
1. Edit / copas file env jadi .env
   - <code>CI_ENVIRONMENT = development</code>
   - *Uncomment* semua bagian <code>database.default</code>
   - Ubah nama database jadi: latihan-perpustakaan
2. Bikin database: latihan-perpustakaan
   - Manual atau *command*:
   - php spark db:create latihan-perpustakaan
3. php spark migrate    *(bikin table di dalem database)*
4. php spark db:seed    *(ngisi data di table)*
5. php spark serve terus masukin link localhost yg muncul itu ke browser
6. php spark            *(liat semua command)*

*semua php spark itu diketik di terminal / console yg udh masuk ke folder projek latihan ini*
