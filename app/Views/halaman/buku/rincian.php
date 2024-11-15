<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

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
          <div class="row mb-2">
            <div class="col-lg-2 col-3">
              Jumlah
            </div>
            <div class="col-lg-10 col-9">
              : <?= esc($buku['jumlah_buku']) ?> buku total
            </div>
          </div>
        </div>
      </div>

      <!-- Tombol -->
       <div class="row mb-3 justify-content-center">
        <a href="<?= route_to('adminBukuUbahForm', esc($buku['slug'])) ?>" class="btn btn-primary btn-sm me-2" style="width: 120px;">
          Ubah Data Buku
        </a>

        <!-- Ini harus bikin controller baru kayaknya, yang nerima pengguna_id & seri_id terus masukin data ke wishlist -->
        <?php if ($jumlah_tersedia > 0) : ?>
          <a href="#" class="btn btn-primary btn-sm me-2" style="width: 144px;">
            Masukan ke Wishlist
          </a>
        <?php else : ?>
          <a href="#" class="btn btn-secondary btn-sm me-2" style="width: 144px; pointer-events: none;">
            Masukan ke Wishlist
          </a>
        <?php endif ?>
       </div>
    </div>
  </div>

  <!-- Tampilan table label buku -->
  <div class="card container my-4">
    <div class="card-body">
        <?= $this->include('halaman/nomorSeri/table.php') ?>
    </div>
  </div>

<?= $this->endSection() ?>