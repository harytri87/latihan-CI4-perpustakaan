<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12">
    <div class="card-body">
      <h5 class="card-title mb-3">Tambah Buku Baru</h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <!-- form_open() udah sekalian sama csrf kalo di Filters.php csrf-nya di uncomment-->
      <?= form_open_multipart(route_to('adminBukuTambahAction')) ?>
        <!-- ISBN -->
        <div class="form-floating mb-2">
          <input type="number" name="isbn" id="floatingISBNInput" class="form-control" placeholder="ISBN" minlength="13" maxlength="13" required value="<?= set_value('isbn') ?>">
          <label for="floatingISBNInput">ISBN</label>
        </div>

        <!-- Judul -->
        <div class="form-floating mb-2">
          <input type="text" name="buku_judul" id="floatingJudulInput" class="form-control" placeholder="Judul" maxlength="100" required value="<?= set_value('buku_judul') ?>">
          <label for="floatingJudulInput">Judul</label>
        </div>

        <!-- Penulis -->
        <div class="form-floating mb-2">
          <input type="text" name="buku_penulis" id="floatingPenulisInput" class="form-control" placeholder="Penulis" maxlength="100" required value="<?= set_value('buku_penulis') ?>">
          <label for="floatingPenulisInput">Penulis</label>
        </div>

        <!-- Tahun Terbit -->
        <div class="form-floating mb-2">
          <input type="number" name="buku_terbit" id="floatingTahunTerbitInput" class="form-control" placeholder="Tahun Terbit" minlength="4" maxlength="4" required value="<?= set_value('buku_terbit') ?>">
          <label for="floatingTahunTerbitInput">Tahun Terbit</label>
        </div>

        <!-- Sinopsis -->
        <div class="form-floating mb-2">
          <textarea name="buku_sinopsis" id="floatingSinopsisInput" class="form-control" placeholder="Sinopsis" rows="4" required style="height:100%;"><?= set_value('buku_sinopsis') ?></textarea>
          <label for="floatingSinopsisInput">Sinopsis</label>
        </div>

        <!-- Kategori -->
        <div class="form-floating mb-2">
          <select class="form-select" name="kategori_id" id="floatingSelect">
            <option>-- Pilih Kategori --</option>
              <?php if ($kategori_list !== []) : ?>
                <?php foreach ($kategori_list as $kategori_item) : ?>
                  <option value="<?= (int)esc($kategori_item['kategori_id']) ?>" <?= set_select('kategori_id', esc($kategori_item['kategori_id'])) ?>>
                    <?= esc($kategori_item['kategori_nama']) ?>
                  </option>
                <?php endforeach ?>
              <?php endif ?>
          </select>
          <label for="floatingSelect">Kategori Buku</label>
        </div>

        <!-- Gambar Sampul -->
        <div class="form-floating mb-2">
          <input type="file" name="buku_foto" id="floatingFotoInput" class="form-control" placeholder="Foto Sampul" accept="image/*" required onchange="
            document.getElementById('fotoImg').src = window.URL.createObjectURL(this.files[0])
            document.getElementById('fotoDiv').style.display = 'block'
          ">
          <label for="floatingFotoInput">Foto Sampul</label>
        </div>
        
        <div class="sampul-preview" id="fotoDiv" style="display: none;">
          <img class="sampul" src="/" id="fotoImg">
        </div>

        <!-- Jumlah Buku -->
        <div class="form-floating mb-2">
          <input type="number" name="jumlah_buku" id="floatingJumlahBukuInput" class="form-control" placeholder="Jumlah Buku" required value="<?= set_value('jumlah_buku') ?>">
          <label for="floatingJumlahBukuInput">Jumlah Buku</label>
        </div>

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Tambahkan</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('adminBukuIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>