<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12 col-lg-5 col-md-7">
    <div class="card-body">
      <h5 class="card-title mb-5">Tambah Grup Baru</h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <?= form_open(route_to('grupTambahAction')) ?>
        <!-- Nama Grup -->
        <div class="form-floating mb-2">
          <input type="text" name="grup_nama" id="floatingNamaInput" class="form-control" placeholder="Nama Grup" required maxlength="100" value="<?= set_value('grup_nama') ?>">
          <label for="floatingNamaInput">Nama Grup</label>
        </div>

        <!-- Keterangan Grup -->
        <div class="form-floating mb-2">
          <input type="text" name="grup_keterangan" id="floatingKeteranganInput" class="form-control" placeholder="Keterangan Grup" required maxlength="100" value="<?= set_value('grup_keterangan') ?>">
          <label for="floatingKeteranganInput">Keterangan Grup</label>
        </div>

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Tambahkan</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('grupIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>