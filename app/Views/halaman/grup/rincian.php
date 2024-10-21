<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?= $this->include('layout/inc/alert.php') ?>

  <h2><?= esc($grup['grup_nama']) ?></h2>
  <p><?= esc($grup['grup_keterangan']) ?></p>

<?= $this->endSection() ?>