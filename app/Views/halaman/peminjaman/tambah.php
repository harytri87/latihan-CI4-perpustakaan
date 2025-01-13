<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12">
    <div class="card-body">
      <h5 class="card-title mb-5">Tambah Data Peminjaman Baru</h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <?= form_open(route_to('peminjamanTambahAction')) ?>
        <!-- Semua id di input, label & datalist biarin namanya "wishlist" biar ga nambah/ubah lagi javascript di layout_utama.php -->

        <!-- Email -->
        <div class="form-floating mb-2">
          <input type="email" name="pengguna_email" id="wishlistEmailInput" autocomplete="off" list="wishlist_email_list" class="form-control" placeholder="Email" maxlength="100" required value="<?= old('pengguna_email') !== null ? old('pengguna_email') : esc($email_preset) ?>">
          <label for="wishlistEmailInput">Email Anggota</label>
          <datalist id="wishlist_email_list">
            <?php
            foreach (esc($pengguna_list) as $username => $email) {
              echo "<option value=\"$email\" data-username-wishlist=\"$username\">$email</option>";
            }
            ?>
          </datalist>
        </div>

        <!-- Username -->
        <div class="form-floating mb-2">
          <input type="hidden" name="pengguna_username" id="wishlistUsernameInput" class="form-control" placeholder="Username" value="<?= old('pengguna_username') !== null ? old('pengguna_username') : esc($username_preset) ?>">
          <!-- <label for="wishlistUsernameInput">Username</label> -->
        </div>

        <!-- Judul -->
        <div class="form-floating mb-2">
          <input type="text" name="buku_judul" id="wishlistJudulInput" autocomplete="off" list="wishlist_buku_list" class="form-control" placeholder="Judul" maxlength="100" required value="<?= set_value('buku_judul') ?>">
          <label for="wishlistJudulInput">Judul Buku</label>
          <datalist id="wishlist_buku_list">
            <?php foreach (esc($buku_list) as $isbn => $buku) : ?>
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
          <input type="hidden" name="isbn" id="wishlistISBNInput" class="form-control" placeholder="ISBN" minlength="13" maxlength="13" value="<?= set_value('isbn') ?>">
          <!-- <label for="wishlistISBNInput">ISBN</label> -->
        </div>

        <!-- Nomor Seri Buku -->
        <div class="form-floating mb-2">
          <input type="text" name="seri_kode" id="wishlistLabelBukuInput" class="form-control" placeholder="*Label Buku" minlength="12" maxlength="20" required value="<?= set_value('seri_kode') ?>">
          <label for="wishlistLabelBukuInput">*Label Buku</label>
        </div>

        <!-- Gambar Sampul -->
        <div class="sampul-preview mb-2" id="fotoDivWishlist" style="display: none;">
          <img class="sampul" src="/" id="fotoImgWishlist">
        </div>

        <!-- Tanggal Peminjaman -->
        <?php
          use CodeIgniter\I18n\Time;
          $waktu = new Time();
        ?>

        <?php if (esc($username_preset) === '') : ?>
          <div class="form-floating mb-2">
            <input type="datetime-local" name="peminjaman_tanggal" id="peminjamanTanggalInput" autocomplete="off" class="form-control" placeholder="Tanggal peminjaman" required value="<?= set_value('peminjaman_tanggal') ?>">
            <label for="peminjamanTanggalInput">Tanggal peminjaman</label>
          </div>
        <?php else : ?>
          <div class="form-floating mb-2">
            <input type="hidden" name="peminjaman_tanggal" id="peminjamanTanggalInput" autocomplete="off" class="form-control" placeholder="Tanggal peminjaman" required value="<?= $waktu ?>">
            <!-- <label for="peminjamanTanggalInput">Tanggal peminjaman</label> -->
          </div>
        <?php endif ?>

        <!-- Durasi Peminjaman -->
        <div class="form-floating mb-2">
          <input type="number" name="peminjaman_durasi" id="wishlistLabelBukuInput" class="form-control" placeholder="Durasi Peminjaman (jumlah hari)" required value="<?= set_value('peminjaman_durasi') ?>">
          <label for="wishlistLabelBukuInput">Durasi Peminjaman (jumlah hari)</label>
        </div>

        <?php if (esc($username_preset) !== '') : ?>
          <!-- Redirect -->
          <div class="form-floating mb-2">
            <input type="hidden" name="redirect" id="floatingRedirectInput" class="form-control" placeholder="Redirect" minlength="13" maxlength="13" value="pengguna">
            <!-- <label for="floatingRedirectInput">Redirect</label> -->
          </div>
        <?php endif ?>
        
        <p>
          <i>*Pastikan label yang dimasukan sesuai dengan label buku yang akan dipinjam.</i>
          <br>
          <i>Bila ada notif "sedang tidak tersedia", data status buku tersebut masih "dipinjam".</i>
          <br>
          <i>(Label di buku fisik. Ini web latihan jadi ga ada buku fisik. Cek <a href="<?= route_to('nomorSeriIndex') ?>" target="_blank">daftar label buku</a>)</i>
        </p>

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Tambahkan</button>

          <p class="text-center"><a href="<?= route_to('peminjamanIndex') ?>">Batal</a></p>
        </div>
        
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>