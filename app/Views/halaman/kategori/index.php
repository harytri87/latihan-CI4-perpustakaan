<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?= $this->include('layout/inc/alert.php') ?>

  <div class="card container my-4">
    <div class="card-body">
      <div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4>Kategori</h4>
        </div>
        <div class="col-9">
          <form action="" method="get" class="d-flex" role="search">
              <input class="form-control me-2" type="search" name="cari" placeholder="Cari kategori" aria-label="Cari kategori">
              <button class="btn btn-primary" type="submit">Cari</button>
          </form>
        </div>
        <div class="col">
          <a href="<?= route_to('kategoriTambahForm') ?>" class="btn btn-primary float-end">Tambah</a>
        </div>
      </div>

      <div class="row table-responsive">
            
        <?php if ($kategori_list !== []): 
          $no = 1 + ($penomoran * ($pager->getCurrentPage() - 1));
        ?>
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th class="text-center">#</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Rincian</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($kategori_list as $kategori_item): ?>

                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= esc($kategori_item['kategori_kode']) ?></td>
                  <td><?= esc($kategori_item['kategori_nama']) ?></td>
                  <td><?= esc($kategori_item['kategori_rincian']) ?></td>
                  <td class="text-center" style="width: 21%;">
                    <abbr title="ubah data">
                      <a href="<?= route_to('kategoriUbahForm', esc($kategori_item['kategori_link'])) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    </abbr>

                    <!-- Button trigger modal -->
										<!-- Fungsi & modalnya di layout/layout_utama.php -->
                    <abbr title="hapus data">
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData" data-bs-nama="<?= esc($kategori_item['kategori_nama']) ?>" data-bs-url="<?= url_to('kategoriHapus', esc($kategori_item['kategori_id'])) ?>">
												<i class="bi bi-trash"></i>
											</button>
                    </abbr>
                  </td>
                </tr>

              <?php endforeach ?>
            </tbody>
          </table>

          <div class="col">
						<i class="fs-6 fw-lighter">Menampilkan <?=empty($kategori_list) ? 0 : 1 + ($penomoran * ($pager->getCurrentPage() - 1))?> - <?=$no-1?> dari <?=$pager->getTotal()?> data</i>
          </div>

          <div class="col">
							<?= $pager->links() ?>
          </div>

        <?php else: ?>
						<h4>Data kategori tidak ditemukan</h4>
        <?php endif ?>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>