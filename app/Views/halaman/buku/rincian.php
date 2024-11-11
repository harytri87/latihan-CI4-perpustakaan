<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?= $this->include('layout/inc/alert.php') ?>

  <div class="card container my-4">
    <div class="card-body">
      <div class="row mb-3 justify-content-between">
        <div class="col-12 mb-3">
          <h4><?= esc($buku['buku_judul']) ?></h4>
          NANTI MAU DIUBAH TAMPILANNYA JADI CARD BUKU TERUS DI BAWAHNYA DAFTAR NOMOR SERINYA.
          Tombol tambah di jumlah itu nanti muncul popup buat nambahin jumlah bukunya & otomatis nambah ke table nomor_seri sesuai jumlah yang dimasukin
        </div>
      </div>

      <div class="row table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-primary">
            <tr>
              <th class="align-middle">ISBN</th>
              <th class="align-middle">Judul</th>
              <th class="align-middle">Penulis</th>
              <th class="align-middle">Terbit</th>
              <th class="align-middle">Kategori</th>
              <th class="align-middle">Sinopsis</th>
              <th class="align-middle">Gambar Sampul</th>
              <th class="align-middle">Jumlah</th>
            </tr>
          </thead>
          <tbody id="table">
            <tr>
              <td><?= esc($buku['isbn']) ?></td>
              <td><?= esc($buku['buku_judul']) ?></td>
              <td><?= esc($buku['buku_penulis']) ?></td>
              <td><?= esc($buku['buku_terbit']) ?></td>
              <td><?= esc($buku['kategori_nama']) ?></td>
              <td><?= esc($buku['buku_sinopsis']) ?></td>
              <td>
                <img src="<?= base_url('images/profil/') . esc($buku['buku_foto']) ?>" alt="<?= esc($buku['buku_judul']) ?>">
              </td>
              <td>
                <?= esc($buku['jumlah_buku']) ?> buku
                <button>Tambah</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>