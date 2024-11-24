<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="card container my-4">
    <div class="card-body">

      <?= $this->include('layout/inc/alert.php') ?>
      
      <div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4>Wishlist</h4>
        </div>
        <div class="col-9">
          <form action="" method="get" class="d-lg-flex justify-content-between" role="search">
              <!-- Cari sesuai keyword -->
              <input class="form-control me-2 mb-2" type="search" name="cari" id="cari" placeholder="Cari ISBN / Judul / Email" value="<?= $cari_keyword = esc($cari_keyword) ?? "" ?>" aria-label="Cari wishlist">

              <!-- cari sesuai status -->
              <?php
              $pilihan_status = [
                ""         => "-- Status --",
                "wishlist"   => "wishlist",
                "pengajuan" => "pengajuan"
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
          <a href="<?= route_to('wishlistTambahForm') ?>" class="btn btn-primary float-end">Tambah</a>
        </div>
      </div>

      <div class="row table-responsive">
            
        <?php if ($wishlist_list !== []) : 
          $no = 1 + ($penomoran * ($pager->getCurrentPage() - 1));
        ?>
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th class="align-middle text-center">#</th>
                <th class="align-middle">Email</th>
                <th class="align-middle">ISBN</th>
                <th class="align-middle">Judul</th>
                <th class="align-middle text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($wishlist_list as $wishlist_item): ?>

                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= esc($wishlist_item['pengguna_email']) ?></td>
                  <td><?= esc($wishlist_item['isbn']) ?></td>
                  <td><?= esc($wishlist_item['buku_judul']) ?></td>
                  <td class="text-center">
                    <abbr class="text-decoration-none" title="ubah data">
                      <a href="<?= route_to('wishlistUbahForm', esc($wishlist_item['wishlist_id'])) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    </abbr>

                    <!-- Button trigger modal -->
										<!-- Fungsi & modalnya di layout/layout_utama.php -->
                    <abbr class="text-decoration-none" title="hapus data">
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData" data-bs-nama="nomor <?= $no - 1; ?>" data-bs-url="<?= url_to('wishlistHapus', esc($wishlist_item['wishlist_id'])) ?>">
												<i class="bi bi-trash"></i>
											</button>
                    </abbr>
                  </td>
                </tr>

              <?php endforeach ?>
            </tbody>
          </table>

          <div class="col">
						<i class="fs-6 fw-lighter">Menampilkan <?=empty($wishlist_list) ? 0 : 1 + ($penomoran * ($pager->getCurrentPage() - 1))?> - <?=$no-1?> dari <?=$pager->getTotal()?> data</i>
          </div>

          <div class="col">
							<?= $pager->links() ?>
          </div>

        <?php else: ?>
						<h4>Data wishlist tidak ditemukan</h4>
        <?php endif ?>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>