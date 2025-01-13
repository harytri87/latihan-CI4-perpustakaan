<div class="row mb-3 justify-content-between">
  <div class="col-12 mb-3">
    <h4>Daftar Label Buku</h4>
  </div>
  <form action="" method="get" class="d-sm-flex justify-content-between" role="search">
    <?php if ($aksi == "seriController") : ?>
      <!-- Cari sesuai keyword -->
      <input class="form-control me-2 mb-2" type="search" name="cari" id="cari" placeholder="Cari kode label / ISBN / judul " value="<?= $cari_keyword = esc($cari_keyword) ?? "" ?>" aria-label="Cari buku">
    <?php endif ?>

    <!-- cari sesuai status -->
    <?php
    $pilihan_status = [
      ""         => "-- Status --",
      "gudang"   => "gudang",
      "tersedia" => "tersedia",
      "dipinjam" => "dipinjam",
      "rusak"    => "rusak",
      "hilang"   => "hilang"
    ];

    $hiasan = [
      "class" => "form-control me-2 mb-2",
      "style" => "width: 40%"
    ];

    echo form_dropdown("status", $pilihan_status, $cari_status = esc($cari_status) ?? "", $hiasan);
    ?>

    <button class="btn btn-primary mb-2" type="submit">Cari</button>

    
    <?php if ($aksi == "bukuController") : ?>
      <!-- Button trigger modal tambah data -->
      <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah"
      data-title="Tambah Data Buku: <?= esc($buku['buku_judul']) ?>"
      data-bs-judulBuku="<?= esc($buku['buku_judul']) ?>"
      data-bs-isbnBuku="<?= esc($buku['isbn']) ?>"
      data-bs-url="<?= url_to('nomorSeriTambahAction') ?>">
        Tambah Data
      </button>
    <?php endif ?>
  </form>
</div>

<div class="row table-responsive">
  <?php if ($nomor_seri_list !== []) :
    $no = 1 + ($penomoran * ($pager->getCurrentPage() - 1));
  ?>
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-primary">
        <tr>
          <th class="align-middle text-center">#</th>
          <!--  seri_kode jadi label, harusnya tablenya juga label  -->
          <th class="align-middle">Label</th>
          <th class="align-middle">ISBN</th>
          <th class="align-middle">Judul</th>
          <th class="align-middle">Status</th>
          <th class="align-middle text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($nomor_seri_list as $nomor_seri_item): ?>

          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= esc($nomor_seri_item['seri_kode']) ?></td>
            <td><?= esc($nomor_seri_item['isbn']) ?></td>
            <td><?= esc($nomor_seri_item['buku_judul']) ?></td>
            <td><?= esc($nomor_seri_item['status_buku']) ?></td>
            <td class="text-center">
              
              <?php if ($aksi == "seriController") : ?>
                <a href="<?= route_to('adminBukuRincian', esc($nomor_seri_item['slug'])) ?>" class="btn btn-primary btn-sm">Rincian</a>
              <?php endif ?>

              <!-- Button trigger modal ubah -->
              <!-- Fungsi & modalnya di-include di bawah dari ubah.php -->
              <abbr class="text-decoration-none" title="ubah data">
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbah" data-title="Ubah Data Buku: <?= esc($nomor_seri_item['buku_judul']) ?>"
                data-bs-judulBuku="<?= esc($nomor_seri_item['buku_judul']) ?>"
                data-bs-statusBuku="<?= esc($nomor_seri_item['status_buku']) ?>"
                <?php 
                  if ($aksi == 'bukuController') {
                    $urlKembali = '?slug='. esc($nomor_seri_item['slug']);
                  } else {
                    $urlKembali = '';
                  }
                ?>
                data-bs-url="<?= url_to('nomorSeriUbahAction', esc($nomor_seri_item['seri_id'])) . $urlKembali ?>">
                <i class="bi bi-pencil-fill"></i>
                </button>
              </abbr>

              <!-- Button trigger modal hapus -->
              <!-- Fungsi & modalnya di layout/layout_utama.php -->
               
              <?php if ($aksi == 'seriController') : ?>
                <abbr class="text-decoration-none" title="hapus data">
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusData"
                    data-bs-nama="<?= esc($nomor_seri_item['seri_kode']) ?>"
                    data-bs-url="<?= url_to('nomorSeriHapus', esc($nomor_seri_item['seri_id'])) ?>">
                    <i class="bi bi-trash"></i>
                  </button>
                </abbr>
              <?php endif ?>
            </td>
          </tr>

        <?php endforeach ?>
      </tbody>
    </table>

    <div class="col">
      <i class="fs-6 fw-lighter">Menampilkan <?= empty($nomor_seri_list) ? 0 : 1 + ($penomoran * ($pager->getCurrentPage() - 1)) ?> - <?= $no - 1 ?> dari <?= $pager->getTotal() ?> data</i>
    </div>

    <div class="col">
      <?= $pager->links() ?>
    </div>

  <?php else: ?>
    <h4>Data buku tidak ditemukan</h4>
  <?php endif ?>
</div>

<?= $this->include('halaman/nomorSeri/tambah.php') ?>
<?= $this->include('halaman/nomorSeri/ubah.php') ?>

