<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12">
    <div class="card-body">
      <h5 class="card-title mb-3"><?= esc($judul_form) ?></h5>

      <?= $this->include('layout/inc/alert.php') ?>

      <?php 
        $session = session(); 
      ?>

      <!-- form_open() udah sekalian sama csrf kalo di Filters.php csrf-nya di uncomment-->
      <?php //dd(form_open_multipart(route_to('penggunaTambahAction'))) ?>

      <?php if (esc($halaman) === 'anggota') : ?>
        <!-- Dari halaman daftar -->
        <?= form_open_multipart(route_to('authDaftarAction', esc($halaman))) ?>
      <?php else : ?>
        <!-- Dari halaman CRUD -->
        <?= form_open_multipart(route_to('penggunaTambahAction', esc($halaman))) ?>
      <?php endif ?>

        <!-- Nama -->
        <div class="form-floating mb-2">
          <input type="text" name="pengguna_nama" id="floatingNamaInput" class="form-control" placeholder="Nama" required maxlength="100" value="<?= set_value('pengguna_nama') ?>">
          <label for="floatingNamaInput">Nama</label>
        </div>

        <!-- Email -->
        <div class="form-floating mb-2">
          <input type="email" name="pengguna_email" id="floatingEmailInput" class="form-control" placeholder="Email" required maxlength="100" value="<?= set_value('pengguna_email') ?>">
          <label for="floatingEmailInput">Email</label>
        </div>

        <!-- Username -->
        <div class="form-floating mb-2">
          <input type="text" name="pengguna_username" id="floatingUsernameInput" class="form-control" placeholder="Username" required maxlength="100" value="<?= set_value('pengguna_username') ?>">
          <label for="floatingUsernameInput">Username</label>
        </div>
        
        <!-- Password -->
        <div class="form-floating mb-2">
          <input type="password" name="pengguna_password" id="floatingPasswordInput" class="form-control" placeholder="Password" required maxlength="100">
          <label for="floatingPasswordInput">Password</label>
        </div>
        
        <!-- Ulangi Password -->
        <div class="form-floating mb-2">
          <input type="password" name="password_ulang" id="floatingPasswordUlangInput" class="form-control" placeholder="Password" required maxlength="100">
          <label for="floatingPasswordUlangInput">Ulangi Password</label>
        </div>
        
        <!-- Level -->
        <?php if ($session->get('grup') === 'Admin') : ?>
          <!-- Admin bisa pilih semua grup -->
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
        <?php else : ?>
          <!-- Non admin default ngisi level grup anggota -->
          <div class="form-floating mb-2">
            <input type="hidden" name="grup_id" id="floatingGrupInput" class="form-control" placeholder="Level Grup" value="3"> <!-- grup_id buat anggota di table grup -->
            <!-- <label for="floatingGrupInput">Level Grup</label> -->
          </div>
        <?php endif ?>
        
        <!-- Foto Profil -->
        <div class="form-floating mb-2">
          <input type="file" name="pengguna_foto" id="floatingFotoInput" class="form-control" placeholder="Foto Profil" accept="image/*" onchange="
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
        
        <?php if (esc($halaman) === 'anggota') : ?>
          <!-- Dari halaman daftar -->
        <p class="text-center"><a href="<?= route_to('authLoginForm') ?>">Batal</a></p>
        <?php else : ?>
          <!-- Dari halaman CRUD -->
        <p class="text-center"><a href="<?= route_to('penggunaIndex') ?>">Batal</a></p>
        <?php endif ?>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>