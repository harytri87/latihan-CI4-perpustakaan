<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12 col-lg-5 col-md-7">
    <div class="card-body">
      <h5 class="card-title mb-5">Ubah Data Grup</h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <form action="<?= route_to('grupUbahAction', esc($grup['grup_id'])) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT"/>
        <!-- Nama Grup -->
        <div class="form-floating mb-2">
          <input type="nama" name="grup_nama" id="floatingNamaInput" class="form-control" placeholder="Nama Grup" required maxlength="100" value="<?= old('grup_nama') !== null ? old('grup_nama') : esc($grup['grup_nama']) ?>">
          <label for="floatingNamaInput">Nama Grup</label>
        </div>

        <!-- Keterangan Grup -->
        <div class="form-floating mb-2">
          <input type="nama" name="grup_keterangan" id="floatingKeteranganInput" class="form-control" placeholder="Keterangan Grup" required maxlength="100" value="<?= old('grup_keterangan') !== null ? old('grup_keterangan') : esc($grup['grup_keterangan']) ?>">
          <label for="floatingKeteranganInput">Keterangan Grup</label>
        </div>

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Ubah</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('grupIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>