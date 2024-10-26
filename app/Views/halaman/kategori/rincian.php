<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?= $this->include('layout/inc/alert.php') ?>

  <div class="card container my-4">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col">
          <h4>Kategori <?= esc($kategori['kategori_nama']) ?></h4>
        </div>
      </div>

      <div class="row table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
              <tr>
                <th>Nama</th>
                <th>Rincian</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?= esc($kategori['kategori_nama']) ?></td>
                <td><?= esc($kategori['kategori_rincian']) ?></td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>