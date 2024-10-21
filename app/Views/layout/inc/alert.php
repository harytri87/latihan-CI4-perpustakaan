<!-- Semua jenis pesan -->
<?php if (session('message') !== null) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-body">
      <?= session('message') ?>
    </div>
  </div>
<?php endif ?>

<!-- Semua jenis error -->
<?php if (session()->getFlashdata('errors') !== null) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
      <div class="alert-body">
        <?= esc($error) ?>
      </div>
    <?php endforeach ?>
  </div>
<?php endif ?>