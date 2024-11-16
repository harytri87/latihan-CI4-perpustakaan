<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="card container my-4">
    <div class="card-body">
      <?= $this->include('layout/inc/alert.php') ?>

      <!-- Data Profil   -->
      <div class="row">
        <div class="col-10 col-lg-11">
          <h5 class="card-title mb-3">Profil</h5>
          
          <div class="row">
            <div class="col-4 col-md-2">Nama</div>
            <div class="col">: <?= esc($pengguna['pengguna_nama']) ?></div>
          </div>
          
          <div class="row">
            <div class="col-4 col-md-2">Username</div>
            <div class="col">: <?= esc($pengguna['pengguna_username']) ?></div>
          </div>
          
          <div class="row">
            <div class="col-4 col-md-2">Email</div>
            <div class="col">: <?= esc($pengguna['pengguna_email']) ?></div>
          </div>
          
          <div class="row">
            <div class="col-4 col-md-2">Status</div>
            <div class="col">: <?= esc($pengguna['grup_nama']) . " - " . esc($pengguna['pengguna_status']) ?></div>
          </div>
        </div>

        <div class="col">
          <div class="foto-profil mb-3">
            <img class="foto-profil" src="<?= esc($pengguna['pengguna_foto']) !== null ? base_url('images/profil/') . esc($pengguna['pengguna_foto']) : base_url('images/profil/foto-profil-default.png') ?>">
          </div>
        </div>
      </div>

      <!-- Tombol -->
       <!-- Atau tombolnya dipindahin ke navbar dropdown profil -->
      <div class="row mt-3 justify-content-center">
          <a href="#" class="btn btn-sm btn-primary me-2 mt-1" style="width: 88px;">
            Ubah Data
            <!-- Bisa buat semua, ngelink ke CRUD (ubah) pengguna tapi kalo bukan admin, ga bisa ngubah status sama grup level -->
          </a>
          <a href="#" class="btn btn-sm btn-primary me-2 mt-1" style="width: 72px;">
            Wishlist
            <!-- Masih di halaman yg sama, table daftar wishlist -->
          </a>
          <a href="#" class="btn btn-sm btn-primary me-2 mt-1" style="width: 152px;">
            Riwayat Peminjaman
            <!-- Masih di halaman yg sama, table daftar peminjaman -->
          </a>
          <a href="#" class="btn btn-sm btn-primary me-2 mt-1" style="width: 168px;">
            Tambahkan Peminjaman
            <!-- Nanti ini ke CRUD (tambah) wishlist ngirim tanda tanya di linknya buat ngisi otomatis kolom username -->
          </a>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>