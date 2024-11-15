<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="card container my-4">
    <div class="card-body">
      
      <?= $this->include('layout/inc/alert.php') ?>

      <?= $this->include('halaman/nomorSeri/table.php') ?>
      
    </div>
  </div>

<?= $this->endSection() ?>