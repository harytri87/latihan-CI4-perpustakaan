<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12">
    <div class="card-body">
      <h5 class="card-title mb-3">Ubah Data Wishlist</h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <!-- form_open() udah sekalian sama csrf kalo di Filters.php csrf-nya di uncomment-->
      <?= form_open(route_to('wishlistUbahAction', esc($wishlist['wishlist_id']))) ?>
        <input type="hidden" name="_method" value="PUT"/>

        <!-- Email -->
        <div class="form-floating mb-2">
          <input type="email" name="pengguna_email" id="wishlistEmailInput" autocomplete="off" list="wishlist_email_list" class="form-control" placeholder="Email" maxlength="100" required value="<?= old('pengguna_email') !== null ? old('pengguna_email') : esc($wishlist['pengguna_email']) ?>">
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
          <input type="hidden" name="pengguna_username" id="wishlistUsernameInput" class="form-control" placeholder="Username" value="<?= old('pengguna_username') !== null ? old('pengguna_username') : esc($wishlist['pengguna_username']) ?>">
          <!-- <label for="wishlistUsernameInput">Username</label> -->
        </div>

        <!-- Judul -->
        <div class="form-floating mb-2">
          <input type="text" name="buku_judul" id="wishlistJudulInput" autocomplete="off" list="wishlist_buku_list" class="form-control" placeholder="Judul" maxlength="100" required value="<?= old('buku_judul') !== null ? old('buku_judul') : esc($wishlist['buku_judul']) ?>">
          <label for="wishlistJudulInput">Judul Buku</label>

          <datalist id="wishlist_buku_list">
            <?php foreach (esc($buku_list) as $isbn => $buku) : ?>
              <option value="<?= $buku[0] ?>"
              data-isbn-wishlist="<?= $isbn ?>"
              data-foto-wishlist="<?= base_url('images/buku/') . $buku[1] ?>">
                <?= $buku[0] ?>
              </option>
            <?php endforeach ?>
          </datalist>
        </div>

        <!-- ISBN -->
        <div class="form-floating mb-2">
          <input type="hidden" name="isbn" id="wishlistISBNInput" class="form-control" placeholder="ISBN" minlength="13" maxlength="13" value="<?= old('isbn') !== null ? old('isbn') : esc($wishlist['isbn']) ?>">
          <!-- <label for="wishlistISBNInput">ISBN</label> -->
        </div>

        <!-- Gambar Sampul -->
        <div class="sampul-preview mb-2" id="fotoDivWishlist">
          <img class="sampul" src="<?= base_url('images/buku/') . $wishlist['buku_foto'] ?>" id="fotoImgWishlist">
        </div>

        <!-- Status -->
        <div class="form-floating mb-2">
          <?php
          $pilihan_status = [
            "wishlist"   => "Wishlist",
            "konfirmasi" => "Konfirmasi"
          ];

          $hiasan = [
            "class" => "form-control",
            "id"    => "floatingStatusInput"
          ];

          echo form_dropdown("status", $pilihan_status, old('status') !== null ? old('status') : esc($wishlist['status']), $hiasan);
          ?>
          <label for="floatingStatusInput">Status</label>
        </div>

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Ubah</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('wishlistIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>