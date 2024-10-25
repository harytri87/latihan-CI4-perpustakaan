
<!-- Semua jenis pesan -->
<?php if (session()->getFlashdata('message') !== null) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-body">
      <?= session()->getFlashdata('message') ?>
    </div>
  </div>
<?php endif ?>

<!-- Semua jenis errors -->
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

<!-- Errornya cuma 1 -->
<?php if (session()->getFlashdata('error') !== null) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <div class="alert-body">
        <?= session()->getFlashdata('error') ?>
      </div>
  </div>
<?php endif ?>

<!--
	yang di atas kalo controllernya return redirect()
	yang di bawah contoh Kalo di controllernya return view
-->

<?php 
	// if (! empty($errors)) {
	// 	foreach ($errors as $field => $error) {
	// 		esc($error);
	// 	}
	// }
?>