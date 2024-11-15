<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="card container my-4">
    <div class="card-body">

      <?= $this->include('layout/inc/alert.php') ?>

      <div class="row mb-3">
        <div class="col">
          <h4>Pengguna <?= esc($pengguna['pengguna_nama']) ?></h4>
          <p>BELUM BERES. NANTI MAU DITAMBAHIN RINCIAN BUKU APA AJA YANG UDAH/LAGI DIPINJEM</p>
        </div>
      </div>

      <div class="row table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?= esc($pengguna['pengguna_nama']) ?></td>
                <td><?= esc($pengguna['pengguna_email']) ?></td>
                <td><?= esc($pengguna['grup_nama']) . " - " . esc($pengguna['pengguna_status']) ?></td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>