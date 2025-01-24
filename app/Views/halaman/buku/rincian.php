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
          <div class="table-responsive">
            <table class="table table-hover">
              <tbody>
                <!-- ISBN -->
                <tr>
                  <td>ISBN</td>
                  <td>:</td>
                  <td><?= esc($buku['isbn']) ?></td>
                </tr>

                <!-- Judul -->
                <tr>
                  <td>Judul</td>
                  <td>:</td>
                  <td><?= esc($buku['buku_judul']) ?></td>
                </tr>
                
                <!-- Penulis -->
                <tr>
                  <td>Penulis</td>
                  <td>:</td>
                  <td><?= esc($buku['buku_penulis']) ?></td>
                </tr>
                
                <!-- Terbit -->
                <tr>
                  <td>Terbit</td>
                  <td>:</td>
                  <td><?= esc($buku['buku_terbit']) ?></td>
                </tr>
                
                <!-- Kategori -->
                <tr>
                  <td>Kategori</td>
                  <td>:</td>
                  <td><?= esc($buku['kategori_nama']) ?></td>
                </tr>
                
                <!-- Sinopsis -->
                <tr>
                  <td>Sinopsis</td>
                  <td>:</td>
                  <td><?= esc($buku['buku_sinopsis']) ?></td>
                </tr>
                
                <!-- Jumlah tersedia -->
                <tr>
                  <td>Jumlah</td>
                  <td>:</td>
                  <td><?= esc($jumlah_tersedia) ?> buku tersedia</td>
                </tr>
                
                <!-- Jumlah total -->
                <?php if ($halaman === 'data') : ?>
                  <tr>
                    <td>Jumlah</td>
                    <td>:</td>
                    <td><?= esc($buku['jumlah_buku']) ?> buku total</td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>
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
              <div class="d-grid col-5 col-lg-3 col-md-4 mx-auto">
                <button type="submit" class="btn btn-primary btn-sm">Masukan ke wishlist</button>
              </div>
            <?php elseif ($boleh_wishlist === false) : ?>
              <div class="d-grid col-5 col-lg-3 col-md-4 mx-auto">
                <a href="#" class="btn btn-secondary btn-sm" style="pointer-events: none;">
                  Sudah ada di wishlist
                </a>
              </div>
            <?php else : ?>
              <div class="d-grid col-5 col-lg-3 col-md-4 mx-auto">
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