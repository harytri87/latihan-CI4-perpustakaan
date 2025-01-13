<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="card container my-4">
    <div class="card-body">

      <?= $this->include('layout/inc/alert.php') ?>
      
      <div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4>Peminjaman</h4>
        </div>
        <div class="col-9">
          <form action="" method="get" class="d-lg-flex justify-content-between" role="search">
              <!-- Cari sesuai keyword -->
              <input class="form-control me-2 mb-2" type="search" name="cari" id="cari" placeholder="Cari kode peminjaman / nama / email anggota" value="<?= $cari_keyword = esc($cari_keyword) ?? "" ?>" aria-label="Cari peminjaman">

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
          <a href="<?= route_to('peminjamanTambahForm') ?>" class="btn btn-primary float-end">Tambah</a>
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
                <th class="align-middle">Nama Peminjam</th>
                <th class="align-middle">Email Peminjam</th>
                <th>Judul Buku</th>
                <th class="align-middle">Status</th>
                <th class="align-middle text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($peminjaman_list as $peminjaman_item): ?>

                <?php
                  $sisaHari = esc($peminjaman_item['sisa_hari']) >= 0 ? "sisa " . esc($peminjaman_item['sisa_hari']) . " hari" : 'telat ' . substr(esc($peminjaman_item['sisa_hari']), 1) . " hari";
                  
                  $max_length = 20;
                ?>
                
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= esc($peminjaman_item['peminjaman_kode']) ?></td>
                  <td><?= esc($peminjaman_item['pengguna_nama']) ?></td>
                  <td><?= esc($peminjaman_item['pengguna_email']) ?></td>
                  <td>
                    <abbr class="text-decoration-none" title="<?= esc($peminjaman_item['buku_judul']) ?>">
                      <a class="text-reset text-decoration-none" href="<?= route_to('bukuRincian', esc($peminjaman_item['slug'])) ?>">
                        <?= $tampil = mb_strlen($peminjaman_item['buku_judul']) > $max_length ? mb_substr($peminjaman_item['buku_judul'], 0, $max_length) . '...' : $peminjaman_item['buku_judul']; ?>
                      </a>
                    </abbr>
                  </td>
                  <td>
                    <?= esc($peminjaman_item['pengembalian_status']) !== null ?
                      esc($peminjaman_item['pengembalian_status']) :
                      $sisaHari ?>
                  </td>
                  <td class="text-center">

                    <a href="<?= route_to('peminjamanRincian', esc($peminjaman_item['peminjaman_id'])) ?>" class="btn btn-primary btn-sm">Rincian</a>

                    <abbr class="text-decoration-none" title="ubah data">
                      <a href="<?= route_to('peminjamanUbahForm', esc($peminjaman_item['peminjaman_id'])) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    </abbr>

                    <!-- Button trigger modal -->
										<!-- Fungsi & modalnya di layout/layout_utama.php -->
                    <abbr class="text-decoration-none" title="hapus data">
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData" data-bs-nama="nomor <?= $no - 1; ?>" data-bs-url="<?= url_to('peminjamanHapus', esc($peminjaman_item['peminjaman_id'])) ?>">
												<i class="bi bi-trash"></i>
											</button>
                    </abbr>
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
						<h4>Data peminjaman tidak ditemukan</h4>
        <?php endif ?>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>