<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12">
    <div class="card-body">
      <h5 class="card-title mb-5">Ubah Data Buku <?= esc($buku['buku_judul']) ?></h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <?= form_open_multipart(route_to('adminBukuUbahAction', esc($buku['buku_id']))) ?>
        <input type="hidden" name="_method" value="PUT"/>
        <!-- ISBN -->
        <div class="form-floating mb-2">
          <input type="number" name="isbn" id="floatingISBNInput" class="form-control" placeholder="ISBN" minlength="13" maxlength="13" required value="<?= $isbn = old('isbn') ?? esc($buku['isbn']) ?>">
          <label for="floatingISBNInput">ISBN</label>
        </div>

        <!-- Judul -->
        <div class="form-floating mb-2">
          <input type="text" name="buku_judul" id="floatingJudulInput" class="form-control" placeholder="Judul" maxlength="100" required value="<?= $buku_judul = old('buku_judul') ?? esc($buku['buku_judul']) ?>">
          <label for="floatingJudulInput">Judul</label>
        </div>

        <!-- Penulis -->
        <div class="form-floating mb-2">
          <input type="text" name="buku_penulis" id="floatingPenulisInput" class="form-control" placeholder="Penulis" maxlength="100" required value="<?= $buku_penulis = old('buku_penulis') ?? esc($buku['buku_penulis']) ?>">
          <label for="floatingPenulisInput">Penulis</label>
        </div>

        <!-- Tahun Terbit -->
        <div class="form-floating mb-2">
          <input type="number" name="buku_terbit" id="floatingTahunTerbitInput" class="form-control" placeholder="Tahun Terbit" minlength="4" maxlength="4" value="<?= $buku_terbit = old('buku_terbit') ?? esc($buku['buku_terbit']) ?>" required>
          <label for="floatingTahunTerbitInput">Tahun Terbit</label>
        </div>

        <!-- Sinopsis -->
        <div class="form-floating mb-2">
          <textarea name="buku_sinopsis" id="floatingSinopsisInput" class="form-control" placeholder="Sinopsis" rows="4" required style="height:100%;"><?= $buku_sinopsis = old('buku_sinopsis') ?? esc($buku['buku_sinopsis']) ?></textarea>
          <label for="floatingSinopsisInput">Sinopsis</label>
        </div>

        <!-- Kategori -->
        <div class="form-floating">
          <select class="form-select" name="kategori_id" id="floatingSelect">
            <?php foreach ($kategori_list as $kategori_item) : ?>
              <option value="<?= (int)esc($kategori_item['kategori_id']) ?>" <?= set_select('kategori_id', esc($kategori_item['kategori_id']), esc($kategori_item['kategori_id']) === esc($buku['kategori_id']) ? true : "") ?>>
                <?= esc($kategori_item['kategori_nama']) ?>
              </option>
            <?php endforeach ?>
          </select>
          <label for="floatingSelect">Kategori Buku</label>
        </div>

        <!-- Gambar Sampul -->
        <div class="form-floating mb-2">
          <input type="file" name="buku_foto" id="floatingFotoInput" class="form-control" placeholder="Foto Sampul" accept="image/*" onchange="
            document.getElementById('fotoImg').src = window.URL.createObjectURL(this.files[0])
          ">
          <label for="floatingFotoInput">Foto Sampul</label>
        </div>
        
        <div class="sampul-preview" id="fotoDiv">
          <img class="sampul" src="<?= base_url('images/buku/') . esc($buku['buku_foto']) ?>" id="fotoImg" alt="<?= esc($buku['buku_foto']) ?>">
        </div>

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Ubah Data</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('adminBukuIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>