<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-11">
          <h5 class="card-title mb-3">Ubah Data <?= esc($pengguna['pengguna_nama']) ?></h5>
        </div>
        <div class="col">
          <div class="foto-profil mb-3">
            <img class="foto-profil" src="<?= esc($pengguna['pengguna_foto']) !== null ? base_url('images/profil/') . esc($pengguna['pengguna_foto']) : base_url('images/profil/foto-profil-default.png') ?>">
          </div>
        </div>
      </div>
      

      <?= $this->include('layout/inc/alert.php') ?>

      <?= form_open_multipart(route_to('penggunaUbahAction', esc($pengguna['pengguna_id']))) ?>
        <input type="hidden" name="_method" value="PUT"/>
        <!-- Nama -->
        <div class="form-floating mb-2">
          <input type="text" name="pengguna_nama" id="floatingNamaInput" class="form-control" placeholder="Nama" required maxlength="100" value="<?= old('pengguna_nama') !== null ? old('pengguna_nama') : esc($pengguna['pengguna_nama']) ?>">
          <label for="floatingNamaInput">Nama</label>
        </div>

        <!-- Email -->
        <div class="form-floating mb-2">
          <input type="email" name="pengguna_email" id="floatingEmailInput" class="form-control" placeholder="Email" required maxlength="100" value="<?= old('pengguna_email') !== null ? old('pengguna_email') : esc($pengguna['pengguna_email']) ?>">
          <label for="floatingEmailInput">Email</label>
        </div>

        <!-- Username -->
        <div class="form-floating mb-2">
          <input type="text" name="pengguna_username" id="floatingUsernameInput" class="form-control" placeholder="Username" required maxlength="100" value="<?= old('pengguna_username') !== null ? old('pengguna_username') : esc($pengguna['pengguna_username']) ?>">
          <label for="floatingUsernameInput">Username</label>
        </div>
        <!-- Password -->
        <div class="form-floating mb-2">
          <input type="password" name="pengguna_password" id="floatingPasswordInput" class="form-control" maxlength="100">
          <label for="floatingPasswordInput">Password, biarkan kosong jika tidak ingin diubah</label>
        </div>
        
        <!-- Ulangi Password -->
        <div class="form-floating mb-2">
          <input type="password" name="password_ulang" id="floatingPasswordUlangInput" class="form-control" maxlength="100">
          <label for="floatingPasswordUlangInput">Ulangi Password, biarkan kosong jika tidak ingin diubah</label>
        </div>
        
        <!-- Level -->
        <div class="form-floating mb-2">
          <select name="grup_id" id="floatingGrupInput" class="form-control">
            <?php foreach ($grup_list as $grup_item) : ?>
              <option value="<?= esc($grup_item['grup_id']) ?>" <?= set_select('grup_id', esc($grup_item['grup_id']), esc($grup_item['grup_id']) === esc($pengguna['grup_id']) ? true : "") ?>>
                <?= esc($grup_item['grup_nama']) ?>
              </option>
            <?php endforeach ?>
          </select>
          <label for="floatingGrupInput">Grup Level</label>
        </div>
        
        <!-- Foto Profil -->
        <div class="form-floating mb-2">
          <input type="file" name="pengguna_foto" id="floatingFotoInput" class="form-control" placeholder="Foto Profil" accept="image/*" onchange="
            document.getElementById('fotoImg').src = window.URL.createObjectURL(this.files[0])
            document.getElementById('fotoDiv').style.display = 'block'
          ">
          <label for="floatingFotoInput">Foto Profil (opsional)</label>
        </div>
        
        <div class="foto-preview" id="fotoDiv" style="display: none;">
          <img class="foto-profil" src="" id="fotoImg">
        </div>
        

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Ubah Data</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('penggunaIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>