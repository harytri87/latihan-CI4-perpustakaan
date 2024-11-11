<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12">
    <div class="card-body">
      <h5 class="card-title mb-3">Ubah Kategori <?= esc($kategori['kategori_nama']) ?></h5>
      
      <?= $this->include('layout/inc/alert.php') ?>

      <?= form_open(route_to('kategoriUbahAction', esc($kategori['kategori_id']))) ?>
        <input type="hidden" name="_method" value="PUT"/>
        <!-- Kode -->
        <div class="form-floating mb-2">
          <input type="number" name="kategori_kode" id="floatingKodeInput" class="form-control" placeholder="Kode Kategori" required minlength="3" maxlength="20" value="<?= old('kategori_kode') !== null ? old('kategori_kode') : esc($kategori['kategori_kode']) ?>">
          <label for="floatingKodeInput">Kode Kategori</label>
        </div>

        <!-- Nama -->
        <div class="form-floating mb-2">
          <input type="text" name="kategori_nama" id="floatingNamaInput" class="form-control" placeholder="Nama" required maxlength="100" value="<?= old('kategori_nama') !== null ? old('kategori_nama') : esc($kategori['kategori_nama']) ?>">
          <label for="floatingNamaInput">Nama</label>
        </div>

        <!-- Rincian -->
        <div class="form-floating mb-2">
          <input type="text" name="kategori_rincian" id="floatingRincianInput" class="form-control" placeholder="Rincian" required maxlength="255" value="<?= old('kategori_rincian') !== null ? old('kategori_rincian') : esc($kategori['kategori_rincian']) ?>">
          <label for="floatingRincianInput">Rincian</label>
        </div>
        
        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Ubah Data</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('kategoriIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>