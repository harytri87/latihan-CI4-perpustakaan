<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?php $session = session(); ?>

  <!-- Tampilan rincian buku -->
  <div class="card container my-4">
    <div class="card-body">
      
      <?= $this->include('layout/inc/alert.php') ?>

      <!-- Judul buku -->
      <div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4><?= esc($buku['buku_judul']) ?></h4>
        </div>
      </div>

      <div class="row mb-3 justify-content-between">
        <!-- Foto sampul buku -->
        <div class="col-md-4 mb-3">
          <div class="sampul-rinci" id="fotoDiv">
            <img class="sampul" src="<?= base_url('images/buku/') . esc($buku['buku_foto']) ?>" alt="<?= esc($buku['buku_judul']) ?>">
          </div>
        </div>

        <!-- Rincian buku -->
        <div class="col-md-8 mb-3">
          <div class="row mb-2 pt-3">
            <div class="col-lg-2 col-3">
              ISBN
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($buku['isbn']) ?>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2 col-3">
              Judul
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($buku['buku_judul']) ?>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2 col-3">
              Penulis
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($buku['buku_penulis']) ?>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2 col-3">
              Terbit
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($buku['buku_terbit']) ?>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2 col-3">
              Kategori
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($buku['kategori_nama']) ?>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2 col-3">
              Sinopsis
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($buku['buku_sinopsis']) ?>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-2 col-3">
              Jumlah
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($jumlah_tersedia) ?> buku tersedia
            </div>
          </div>
          
          <?php if ($halaman === 'data') : ?>
            <div class="row mb-2">
              <div class="col-lg-2 col-3">
                Jumlah
              </div>
              <div class="col-lg-10 col-9">
                : <?= esc($buku['jumlah_buku']) ?> buku total
              </div>
            </div>
          <?php endif ?>
        </div>
      </div>

      <!-- Tombol -->
      <div class="row mb-3 justify-content-center">
        <?php if (esc($halaman) === 'data') : ?>
          <!-- Dari halaman CRUD -->
          <a href="<?= route_to('adminBukuUbahForm', esc($buku['slug'])) ?>" class="btn btn-primary btn-sm me-2" style="width: 120px;">
            Ubah Data Buku
          </a>
        <?php endif ?>

        <?php if (esc($halaman) === 'buku') : ?>
          <!-- Dari halaman utama, ada tombol buat wishlist -->
          <!-- Form buat ngirim data ngisi table wishlist -->
          <?= form_open(route_to('bukuRincianWishlist', esc($buku['slug']))) ?>
            <!-- Username -->
            <div class="form-floating mb-2">
              <input type="hidden" name="pengguna_username" id="wishlistUsernameInput" class="form-control" placeholder="Username" value="<?= $username = $session->get('username') ?? "" ?>">
              <!-- <label for="wishlistUsernameInput">Username</label> -->
            </div>

            <!-- ISBN -->
            <div class="form-floating mb-2">
              <input type="hidden" name="isbn" id="wishlistISBNInput" class="form-control" placeholder="ISBN" minlength="13" maxlength="13" value="<?= esc($buku['isbn']) ?>">
              <!-- <label for="wishlistISBNInput">ISBN</label> -->
            </div>

            <!-- Tombol -->
            <?php if ($jumlah_tersedia > 0 && $boleh_wishlist === true) : ?>
              <div class="d-grid col-5 col-lg-3 col-md-4 mx-auto m-3">
                <button type="submit" class="btn btn-primary btn-sm">Masukan ke wishlist</button>
              </div>
            <?php elseif ($boleh_wishlist === false) : ?>
              <div class="d-grid col-5 col-lg-3 col-md-4 mx-auto m-3">
                <a href="#" class="btn btn-secondary btn-sm" style="pointer-events: none;">
                  Sudah ada di wishlist
                </a>
              </div>
            <?php else : ?>
              <div class="d-grid col-5 col-lg-3 col-md-4 mx-auto m-3">
                <a href="#" class="btn btn-secondary btn-sm" style="pointer-events: none;">
                  Masukan ke wishlist
                </a>
              </div>
            <?php endif ?>
          </form>
        <?php endif ?>
       </div>
    </div>
  </div>

  <!-- Tampilan table label buku -->
  <?php if ($halaman === 'data') : ?>
    <!-- Cuma bisa diliat dari halaman CRUD -->
    <div class="card container my-4">
      <div class="card-body">
          <?= $this->include('halaman/nomorSeri/table.php') ?>
      </div>
    </div>
  <?php endif ?>

<?= $this->endSection() ?>