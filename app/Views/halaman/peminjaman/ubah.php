<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="card container my-4">
    <div class="card-body">
      <?= $this->include('layout/inc/alert.php') ?>

      <?= form_open(route_to('peminjamanUbahAction', esc($peminjaman['peminjaman_id']))) ?>
        <input type="hidden" name="_method" value="PUT"/>

        <!-- Data Peminjaman -->
        <div class="row">

          <!-- Foto Sampul Buku -->
          <div class="col-md-4 mb-3">
            <div class="my-3 sampul-rinci" id="fotoDivWishlist">
              <img class="sampul" src="<?= base_url('images/buku/') . esc($peminjaman['buku_foto']) ?>" alt="<?= esc($peminjaman['buku_judul']) ?>" id="fotoImgWishlist">
            </div>
            <div class="sampul-preview mb-2" id="fotoDivWishlist" style="display: none;">
              <img class="sampul" src="/" id="fotoImgWishlist">
            </div>
          </div>

          <!-- Data -->
           <!-- yang id-nya "wishlist" biarin, biar ga ganti/nambah di javascriptnya -->
          <div class="col-lg-8">
            <!-- Email Peminjam -->
            <div class="form-floating mb-2">
              <input type="email" name="pengguna_email" id="wishlistEmailInput" autocomplete="off" list="wishlist_email_list" class="form-control" placeholder="Email Peminjam" maxlength="100" required value="<?= old('pengguna_email') !== null ? old('pengguna_email') : esc($peminjaman['pengguna_email']) ?>">
              <label for="wishlistEmailInput">Email Peminjam</label>

              <datalist id="wishlist_email_list">
                <?php foreach (esc($pengguna_list) as $username => $pengguna) : ?>
                  <option value="<?= $pengguna[0] ?>"
                  data-username-wishlist="<?= $username ?>"
                  data-nama-wishlist="<?= $pengguna[1] ?>">
                    <?= $pengguna[0] ?>
                  </option>
                <?php endforeach ?>
              </datalist>
            </div>

            <!-- Username Peminjam -->
            <div class="form-floating mb-2">
              <input type="hidden" name="pengguna_username" id="wishlistUsernameInput" class="form-control" placeholder="Username Peminjam" value="<?= old('pengguna_username') !== null ? old('pengguna_username') : esc($peminjaman['pengguna_username']) ?>">
              <!-- <label for="wishlistUsernameInput">Username Peminjam</label> -->
            </div>

            <!-- Nama Peminjam -->
            <div class="form-floating mb-2">
              <input type="text" name="pengguna_nama" id="wishlistNamaInput" class="form-control" placeholder="Nama Peminjam" value="<?= old('pengguna_nama') !== null ? old('pengguna_nama') : esc($peminjaman['pengguna_nama']) ?>">
              <label for="wishlistNamaInput">Nama Peminjam</label>
            </div>

            <!-- Judul -->
            <div class="form-floating mb-2">
              <input type="text" name="buku_judul" id="wishlistJudulInput" autocomplete="off" list="wishlist_buku_list" class="form-control" placeholder="Judul" maxlength="100" required value="<?= old('buku_judul') !== null ? old('buku_judul') : esc($peminjaman['buku_judul']) ?>">
              <label for="wishlistJudulInput">Judul Buku</label>
              <datalist id="wishlist_buku_list">
                <?php foreach (esc($seri_list) as $isbn => $buku) : ?>
                  <option value="<?= $buku[0] ?>"
                  data-isbn-wishlist="<?= $isbn ?>"
                  data-foto-wishlist="<?= base_url('images/buku/') . $buku[1] ?>"
                  data-seriKode-wishlist="<?= $buku[2] ?>">
                    <?= $buku[0] ?>
                  </option>
                <?php endforeach ?>
              </datalist>
            </div>

            <!-- ISBN -->
            <div class="form-floating mb-2">
              <input type="hidden" name="isbn" id="wishlistISBNInput" class="form-control" placeholder="ISBN" minlength="13" maxlength="13" value="<?= old('isbn') !== null ? old('isbn') : esc($peminjaman['isbn']) ?>">
              <!-- <label for="wishlistISBNInput">ISBN</label> -->
            </div>

            <!-- Nomor Seri Buku -->
            <div class="form-floating mb-2">
              <input type="text" name="seri_kode" id="wishlistLabelBukuInput" class="form-control" placeholder="*Label Buku" minlength="12" maxlength="20" required value="<?= old('seri_kode') !== null ? old('seri_kode') : esc($peminjaman['seri_kode']) ?>">
              <label for="wishlistLabelBukuInput">*Label Buku</label>
            </div>
            
            <!-- Durasi Peminjaman -->
            <div class="form-floating mb-2">
              <input type="text" name="peminjaman_durasi" id="peminjamanDurasiInput" class="form-control" placeholder="Durasi Peminjaman (hari)" minlength="12" maxlength="20" required value="<?= old('peminjaman_durasi') !== null ? old('peminjaman_durasi') : esc($peminjaman['peminjaman_durasi']) ?>">
              <label for="peminjamanDurasiInput">Durasi Peminjaman (hari)</label>
              <i class="small">*Untuk perpanjang, tambah durasi sebelumnya dengan durasi perpanjang (misal 7 + 4 = 11, masukkan 11)</i>
            </div>

            <!-- Tanggal Peminjaman -->
            <div class="form-floating mb-2">
              <input type="datetime-local" name="peminjaman_tanggal" id="peminjamanTanggalInput" autocomplete="off" class="form-control" placeholder="Tanggal peminjaman" required value="<?= old('peminjaman_tanggal') !== null ? old('peminjaman_tanggal') : esc($peminjaman['peminjaman_tanggal']) ?>">
              <label for="peminjamanTanggalInput">Tanggal peminjaman</label>
            </div>

            <!-- Tanggal Pengembalian -->
            <div class="form-floating mb-2">
              <input type="datetime-local" name="pengembalian_tanggal" id="pengembalianTanggalInput" autocomplete="off" class="form-control" placeholder="Tanggal Pengembalian" value="<?= old('pengembalian_tanggal') !== null ? old('pengembalian_tanggal') : esc($peminjaman['pengembalian_tanggal']) ?>">
              <label for="pengembalianTanggalInput">Tanggal Pengembalian</label>
            </div>
            
            <!-- Status Peminjaman -->
            <div class="form-floating mb-2">
              <?php
              $pilihan_status = [
                "dipinjam" => "dipinjam",
                "selesai"  => "selesai"
              ];

              $hiasan = [
                "class" => "form-control",
                "id"    => "peminjamanStatusInput"
              ];

              echo form_dropdown("peminjaman_status", $pilihan_status, old('peminjaman_status') !== null ? old('peminjaman_status') : esc($peminjaman['peminjaman_status']), $hiasan);
              ?>
              <label for="peminjamanStatusInput">Status Peminjaman</label>
            </div>
            
            <!-- Status Pengembalian -->
            <div class="form-floating mb-2">
              <?php
              // tepat waktu / terlambat / rusak
              $pilihan_status = [
                null          => "belum",
                "tepat waktu" => "tepat waktu",
                "terlambat"   => "terlambat",
                "rusak"       => "rusak"
              ];

              $hiasan = [
                "class" => "form-control",
                "id"    => "pengembalianStatusInput"
              ];

              echo form_dropdown("pengembalian_status", $pilihan_status, old('pengembalian_status') !== null ? old('pengembalian_status') : esc($peminjaman['pengembalian_status']), $hiasan);
              ?>
              <label for="pengembalianStatusInput">Status Pengembalian</label>
            </div>

            <!-- Denda -->
            <div class="form-floating mb-2">
              <input type="number" name="denda" id="peminjamanDendaInput" class="form-control" placeholder="*Denda" value="<?= old('denda') !== null ? old('denda') : esc($peminjaman['denda']) ?>">
              <label for="peminjamanDendaInput">*Denda</label>
            </div>

            <!-- Keterangan -->
            <div class="form-floating mb-2">
              <input type="text" name="keterangan" id="peminjamanKeteranganInput" class="form-control" placeholder="*Keterangan" value="<?= old('keterangan') !== null ? old('keterangan') : esc($peminjaman['keterangan']) ?>">
              <label for="peminjamanKeteranganInput">*Keterangan</label>
            </div>
          </div>

          <!-- Tombol -->
          <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto">
            <i class="text-center">Pastikan label buku dan data lainnya sudah sesuai</i>
            <i class="text-center">*Bila kolom denda dan keterangan kosong, maka akan diisi otomatis.</i>

            <button type="submit" class="btn btn-primary my-3">Ubah Data</button>

            <p class="text-center"><a href="<?= route_to('peminjamanIndex') ?>">Batal</a></p>
          </div>

          <i class="small">Ngubah data peminjaman. Di halaman ini buat ubah semua data peminjaman. Kalo di halaman rincian itu buat konfirmasi pengembalian buku aja.</i>

        </div>

      </form>

    </div>
  </div>

<?= $this->endSection() ?>