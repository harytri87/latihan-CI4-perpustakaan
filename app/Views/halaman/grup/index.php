<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?= $this->include('layout/inc/alert.php') ?>

  <div class="card container my-4">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col">
          <h4>Grup</h4>
        </div>
        <div class="col">
          <a href="<?= route_to('grupTambahForm') ?>" class="btn btn-primary float-end">Tambah</a>
        </div>
      </div>

      <div class="row table-responsive">
            
        <?php if ($grup_list !== []): 
          $no = 1 + (5 * ($pager->getCurrentPage() - 1));
        ?>
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th class="text-center">#</th>
                <th>Nama Grup</th>
                <th>Keterangan</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($grup_list as $grup_item): ?>

                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= esc($grup_item['grup_nama']) ?></td>
                  <td><?= esc($grup_item['grup_keterangan']) ?></td>
                  <td class="text-center" style="width: 21%;">
                    <abbr title="ubah data">
                      <a href="<?= route_to('grupUbahForm', esc($grup_item['grup_id'])) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    </abbr>

                    <!-- Button trigger modal -->
										<!-- Fungsi & modalnya di layout/layout_utama.php -->
                    <abbr title="hapus data">
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData" data-bs-nama="<?= esc($grup_item['grup_nama']) ?>" data-bs-url="<?= url_to('grupHapus', esc($grup_item['grup_id'])) ?>">
												<i class="bi bi-trash"></i>
											</button>
                    </abbr>
                  </td>
                </tr>

              <?php endforeach ?>
            </tbody>
          </table>

          <div class="col">
						<i class="fs-6 fw-lighter">Menampilkan <?=empty($grup_list) ? 0 : 1 + (5 * ($pager->getCurrentPage() - 1))?> - <?=$no-1?> dari <?=$pager->getTotal()?> data</i>
          </div>

          <div class="col">
							<?= $pager->links() ?>
          </div>

        <?php else: ?>
						<h4>Data grup tidak ditemukan</h4>
        <?php endif ?>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>