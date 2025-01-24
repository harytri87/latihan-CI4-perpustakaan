<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?php $session = session(); ?>

  <div class="card container my-4">
    <div class="card-body">
      <?= $this->include('layout/inc/alert.php') ?>

      <!--Profil   -->
      <div class="row">
        <div class="col-10 col-lg-11">
          <h5 class="card-title mb-3">Profil</h5>
          
          <!-- Data Profil -->
          <div class="row table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td>
                    <?= esc($pengguna['pengguna_nama']) ?>
                  </td>
                </tr>
                
                <tr>
                  <td>Username</td>
                  <td>:</td>
                  <td>
                    <?= esc($pengguna['pengguna_username']) ?>
                  </td>
                </tr>
                
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>
                    <?= esc($pengguna['pengguna_email']) ?>
                  </td>
                </tr>
                
                <tr>
                  <td>Status</td>
                  <td>:</td>
                  <td>
                    <?= esc($pengguna['grup_nama']) . " - " . esc($pengguna['pengguna_status']) ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Foto Profil -->
        <div class="col">
          <div class="foto-profil mb-3">
            <img class="foto-profil" src="<?= esc($pengguna['pengguna_foto']) !== null ? base_url('images/profil/') . esc($pengguna['pengguna_foto']) : base_url('images/profil/foto-profil-default.png') ?>">
          </div>
        </div>
      </div>

      <!-- Tombol -->
      <div class="row mt-3 justify-content-center">
        <?php if (esc($halaman) === 'profil') : ?>
          <a href="<?= route_to('profilUbahForm', $session->get('username')) ?>" class="btn btn-sm btn-primary me-2" style="width: 88px;">
            Ubah Data
          </a>

          <a href="<?= route_to('profilWishlist', $session->get('username')) ?>" class="btn btn-sm btn-primary" style="width: 72px;">
            Wishlist
          </a>
        <?php else : ?>
          <a href="<?= route_to('penggunaWishlist', esc($pengguna['pengguna_username'])) ?>" class="btn btn-sm btn-primary" style="width: 72px;">
            Wishlist
          </a>
        <?php endif ?>
      </div>
    </div>
  </div>

  <!-- Riwayat Peminjaman -->
  <div class="card container my-4">
    <div class="card-body">
      
			<div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4>Riwayat Peminjaman</h4>
        </div>
        <!-- Pencarian -->
        <div class="col-9">
          <form action="" method="get" class="d-lg-flex justify-content-between" role="search">
              <!-- Cari sesuai keyword -->
              <input class="form-control me-2 mb-2" type="search" name="cari" id="cari" placeholder="Cari kode peminjaman / judul buku" value="<?= $cari_keyword = esc($cari_keyword) ?? "" ?>" aria-label="Cari peminjaman">

              <!-- cari sesuai status -->
              <?php
              $pilihan_status = [
                ""            => "-- Status --",
                "dipinjam"    => "dipinjam",
                "telat"       => "dipinjam - telat",
                "tepat waktu" => "selesai - tepat waktu",
                "terlambat"   => "selesai - terlambat",
                "rusak"       => "selesai - rusak"
              ];

              $hiasan = [
                "class" => "form-control me-2 mb-2",
                "style" => "width: 40%"
              ];

              echo form_dropdown("status", $pilihan_status, $cari_status = esc($cari_status) ?? "", $hiasan);
              ?>
              
              <button class="btn btn-primary mb-2" type="submit">Cari</button>
          </form>
        </div>
        <div class="col">
          <?php if (esc($halaman) === 'pengguna') : ?>
            <a href="<?= route_to('peminjamanTambahForm') ?>?u=<?= esc($pengguna['pengguna_username']) ?>" class="btn btn-primary float-end">Tambah Peminjaman</a>
          <?php endif ?>
        </div>
      </div>

      <div class="row table-responsive">
            
        <?php if ($peminjaman_list !== []) : 
          $no = 1 + ($penomoran * ($pager->getCurrentPage() - 1));
        ?>
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th class="align-middle text-center">#</th>
                <th class="align-middle">Kode</th>
                <th class="align-middle">Judul Buku</th>
                <th class="align-middle">Status</th>
                <th class="align-middle text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($peminjaman_list as $peminjaman_item): ?>

                <?php
                  $sisaHari = esc($peminjaman_item['sisa_hari']) >= 0 ? "sisa " . esc($peminjaman_item['sisa_hari']) . " hari" : 'telat ' . substr(esc($peminjaman_item['sisa_hari']), 1) . " hari";
                ?>
                
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= esc($peminjaman_item['peminjaman_kode']) ?></td>
                  <td><?= esc($peminjaman_item['buku_judul']) ?></td>
                  <td>
                    <?= esc($peminjaman_item['pengembalian_status']) !== null ?
                      esc($peminjaman_item['pengembalian_status']) :
                      $sisaHari ?>
                  </td>
                  <td class="text-center">
                    <?php if (esc($halaman) === 'profil') : ?>
                      <!-- Dari halaman profil -->
                      <a href="<?= route_to('profilPeminjamanRinci', $session->get('username'), esc($peminjaman_item['peminjaman_id'])) ?>" class="btn btn-primary btn-sm">Rincian</a>
                    <?php else : ?>
                      <!-- Dari halaman CRUD -->
                  	  <a href="<?= route_to('peminjamanRincian', esc($peminjaman_item['peminjaman_id'])) ?>?u=<?= esc($pengguna['pengguna_username']) ?>" class="btn btn-primary btn-sm">Rincian</a>
                    <?php endif ?>
                  </td>
                </tr>

              <?php endforeach ?>
            </tbody>
          </table>

          <div class="col">
						<i class="fs-6 fw-lighter">Menampilkan <?=empty($peminjaman_list) ? 0 : 1 + ($penomoran * ($pager->getCurrentPage() - 1))?> - <?=$no-1?> dari <?=$pager->getTotal()?> data</i>
          </div>

          <div class="col">
							<?= $pager->links() ?>
          </div>

        <?php else: ?>
						<h4>Data peminjaman tidak ditemukan/kosong</h4>
        <?php endif ?>
      </div>
    
    </div>
  </div>

<?= $this->endSection() ?>