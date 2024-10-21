<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-lg-5 col-md-7">
      <div class="card-body">
        <h5 class="card-title mb-5">Daftar</h5>

        <?= $this->include('layout/inc/alert.php') ?>

        <form action="<?= route_to('authDaftarAction') ?>" method="post">
          <!-- Email -->
          <div class="form-floating mb-3">
            <input type="email" name="email" id="floatingEmailInput" class="form-control" inputmode="email" autocomplete="email" placeholder="Email" required maxlength="100">
            <label for="floatingEmailInput">Email</label>
          </div>
        
          <!-- Password -->
          <div class="form-floating mb-3">
            <input type="password" name="password" id="floatingPasswordInput" class="form-control" inputmode="password" autocomplete="current-password" placeholder="Password" required maxlength="100">
            <label for="floatingPasswordInput">Password</label>
          </div>

          <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
          </div>

          <p class="text-center">Sudah punya akun? <a href="<?= route_to('authLoginForm') ?>">Login</a></p>
        </form>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>