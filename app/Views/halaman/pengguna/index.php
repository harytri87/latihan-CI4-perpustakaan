<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?= $this->include('layout/inc/alert.php') ?>

  <div class="card container my-4">
    <div class="card-body">
      <div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4>Pengguna</h4>
        </div>
        <div class="col-9">
          <form action="" method="get" class="d-flex" role="search">
              <input class="form-control me-2" type="search" name="cari" placeholder="Cari nama / email pengguna" aria-label="Cari pengguna">
              <button class="btn btn-primary" type="submit">Cari</button>
          </form>
        </div>
        <div class="col">
          <a href="<?= route_to('penggunaTambahForm') ?>" class="btn btn-primary float-end">Tambah</a>
        </div>
      </div>

      <div class="row table-responsive">
            
        <?php if ($pengguna_list !== []): 
          $no = 1 + ($penomoran * ($pager->getCurrentPage() - 1));
        ?>
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th class="text-center">#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pengguna_list as $pengguna_item): ?>

                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= esc($pengguna_item['pengguna_nama']) ?></td>
                  <td><?= esc($pengguna_item['pengguna_email']) ?></td>
                  <td><?= esc($pengguna_item['grup_nama']) . " - " . esc($pengguna_item['pengguna_status']) ?></td>
                  <td class="text-center" style="width: 21%;">
                    <a href="<?= route_to('penggunaRincian', esc($pengguna_item['pengguna_username'])) ?>" class="btn btn-primary btn-sm">Rincian</a>

                    <abbr title="ubah data">
                      <a href="<?= route_to('penggunaUbahForm', esc($pengguna_item['pengguna_username'])) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    </abbr>

                    <!-- Button trigger modal -->
										<!-- Fungsi & modalnya di layout/layout_utama.php -->
                    <abbr title="hapus data">
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData" data-bs-nama="<?= esc($pengguna_item['pengguna_nama']) ?>" data-bs-url="<?= url_to('penggunaHapus', esc($pengguna_item['pengguna_id'])) ?>">
												<i class="bi bi-trash"></i>
											</button>
                    </abbr>
                  </td>
                </tr>

              <?php endforeach ?>
            </tbody>
          </table>

          <div class="col">
						<i class="fs-6 fw-lighter">Menampilkan <?=empty($pengguna_list) ? 0 : 1 + ($penomoran * ($pager->getCurrentPage() - 1))?> - <?=$no-1?> dari <?=$pager->getTotal()?> data</i>
          </div>

          <div class="col">
							<?= $pager->links() ?>
          </div>

        <?php else: ?>
						<h4>Data pengguna tidak ditemukan</h4>
        <?php endif ?>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>