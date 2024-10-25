<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12 col-lg-5 col-md-7">
    <div class="card-body">
      <h5 class="card-title mb-5">Tambah Pengguna Baru</h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <!-- form_open() udah sekalian sama csrf kalo di Filters.php csrf-nya di uncomment-->
      <?php //dd(form_open_multipart(route_to('penggunaTambahAction'))) ?>
      <?= form_open_multipart(route_to('penggunaTambahAction')) ?>
        <!-- Nama -->
        <div class="form-floating mb-2">
          <input type="text" name="pengguna_nama" id="floatingNamaInput" class="form-control" placeholder="Nama" required  minlength="4" maxlength="100" value="<?= set_value('pengguna_nama') ?>">
          <label for="floatingNamaInput">Nama</label>
        </div>

        <!-- Email -->
        <div class="form-floating mb-2">
          <input type="email" name="pengguna_email" id="floatingEmailInput" class="form-control" placeholder="Email" required minlength="8" maxlength="100" value="<?= set_value('pengguna_email') ?>">
          <label for="floatingEmailInput">Email</label>
        </div>

        <!-- Username -->
        <div class="form-floating mb-2">
          <input type="text" name="pengguna_username" id="floatingUsernameInput" class="form-control" placeholder="Username" required minlength="4" maxlength="100" value="<?= set_value('pengguna_username') ?>">
          <label for="floatingUsernameInput">Username</label>
        </div>
        
        <!-- Password -->
        <div class="form-floating mb-2">
          <input type="password" name="pengguna_password" id="floatingPasswordInput" class="form-control" placeholder="Password" required minlength="8" maxlength="100">
          <label for="floatingPasswordInput">Password</label>
        </div>
        
        <!-- Ulangi Password -->
        <div class="form-floating mb-2">
          <input type="password" name="password_ulang" id="floatingPasswordUlangInput" class="form-control" placeholder="Password" required minlength="8" maxlength="100">
          <label for="floatingPasswordUlangInput">Ulangi Password</label>
        </div>
        
        <!-- Level -->
        <div class="form-floating mb-2">
          <select name="grup_id" id="floatingGrupInput" class="form-control">
            <?php foreach ($grup_list as $grup_item) : ?>
              <option value="<?= (int)esc($grup_item['grup_id']) ?>" <?= set_select('grup_id', esc($grup_item['grup_id'])) ?>>
                <?= esc($grup_item['grup_nama']) ?>
              </option>
            <?php endforeach ?>
          </select>
          <label for="floatingGrupInput">Grup Level</label>
        </div>
        
        <!-- Foto Profil -->
        <div class="form-floating mb-2">
          <input type="file" name="pengguna_foto" id="floatingFotoInput" class="form-control" placeholder="Foto Profil" onchange="
            document.getElementById('fotoImg').src = window.URL.createObjectURL(this.files[0])
            document.getElementById('fotoDiv').style.display = 'block'
          ">
          <label for="floatingFotoInput">Foto Profil (opsional)</label>
        </div>
        
        <div class="foto-preview" id="fotoDiv" style="display: none;">
          <img class="foto-profil" src="/" id="fotoImg">
        </div>

        <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block">Tambahkan</button>
        </div>
            
        <p class="text-center"><a href="<?= route_to('penggunaIndex') ?>">Batal</a></p>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>