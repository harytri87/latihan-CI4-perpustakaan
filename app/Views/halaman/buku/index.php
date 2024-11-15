<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="card container my-4">
    <div class="card-body">

      <?= $this->include('layout/inc/alert.php') ?>
      
      <div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4>Buku</h4>
        </div>
        <div class="col-9">
          <form action="" method="get" class="d-lg-flex justify-content-between" role="search">
              <input class="form-control me-2 mb-2" type="search" name="cari" id="cari" placeholder="Cari ISBN / Judul / Penulis" value="<?= $cari_keyword = esc($cari_keyword) ?? "" ?>" aria-label="Cari buku">
              <select class="form-control me-2 mb-2" name="kategori" id="kategori">
                <option value="">-- Kategori --</option>
                <?php if ($kategori_list !== []) : ?>
                  <?php foreach ($kategori_list as $kategori_item) : ?>
                    <option value="<?= esc($kategori_item['kategori_kode']) ?>" <?= set_select('kategori', esc($kategori_item['kategori_kode']), esc($kategori_item['kategori_kode']) == esc($cari_kategori) ? true : "") ?>>
                      <?= esc($kategori_item['kategori_nama']) ?>
                    </option>
                  <?php endforeach ?>
                <?php endif ?>
              </select>
              <button class="btn btn-primary mb-2" type="submit">Cari</button>
          </form>
        </div>
        <div class="col">
          <a href="<?= route_to('adminBukuTambahForm') ?>" class="btn btn-primary float-end">Tambah</a>
        </div>
      </div>

      <div class="row table-responsive">
            
        <?php if ($buku_list !== []) : 
          $no = 1 + ($penomoran * ($pager->getCurrentPage() - 1));
        ?>
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th class="align-middle text-center">#</th>
                <th class="align-middle">ISBN</th>
                <th class="align-middle">Judul</th>
                <th class="align-middle">Penulis</th>
                <th class="align-middle">Kategori</th>
                <th class="align-middle">Jumlah</th>
                <th class="align-middle text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($buku_list as $buku_item): ?>

                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= esc($buku_item['isbn']) ?></td>
                  <td><?= esc($buku_item['buku_judul']) ?></td>
                  <td><?= esc($buku_item['buku_penulis']) ?></td>
                  <td><?= esc($buku_item['kategori_nama']) ?></td>
                  <td><?= esc($buku_item['jumlah_buku']) ?> buku</td>
                  <td class="text-center">
                    <a href="<?= route_to('adminBukuRincian', esc($buku_item['slug'])) ?>" class="btn btn-primary btn-sm">Rincian</a>

                    <abbr title="ubah data">
                      <a href="<?= route_to('adminBukuUbahForm', esc($buku_item['slug'])) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    </abbr>

                    <!-- Button trigger modal -->
										<!-- Fungsi & modalnya di layout/layout_utama.php -->
                    <abbr title="hapus data">
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData" data-bs-nama="<?= esc($buku_item['buku_judul']) ?>" data-bs-url="<?= url_to('adminBukuHapus', esc($buku_item['buku_id'])) ?>">
												<i class="bi bi-trash"></i>
											</button>
                    </abbr>
                  </td>
                </tr>

              <?php endforeach ?>
            </tbody>
          </table>

          <div class="col">
						<i class="fs-6 fw-lighter">Menampilkan <?=empty($buku_list) ? 0 : 1 + ($penomoran * ($pager->getCurrentPage() - 1))?> - <?=$no-1?> dari <?=$pager->getTotal()?> data</i>
          </div>

          <div class="col">
							<?= $pager->links() ?>
          </div>

        <?php else: ?>
						<h4>Data buku tidak ditemukan</h4>
        <?php endif ?>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>