<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="row container-fluid">
    <!-- Sidebar -->
    <nav class="col-2 col-md-1 navbar mx-2 align-items-start">
      <div class="sticky-top mt-3 ms-2">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Wislists</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              
            <!-- Khusus Pegawai/Admin -->
            <li class="nav-item">
              <a class="nav-link" href="#panduan">Panduan Pegawai</a>
            </li>
              
              <?php if ($wishlist_list !== []) : 
                $no = 1;  
              ?>
                <?php foreach ($wishlist_list as $wishlist_item) :
                ?>
                  <li class="nav-item">
                    <a class="nav-link" href="#wishlist-<?= $no++; ?>"><?= esc($wishlist_item['buku_judul']) ?></a>
                  </li>
                <?php endforeach ?>
              <?php else : ?>
                <li class="nav-item">
                  <a class="nav-link disabled" aria-disabled="true">Kosong</a>
                </li>
              <?php endif ?>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="col">
      <!-- Data Profil   -->
      <div class="row card my-4" id="profil">
        <div class="card-body">
          <?= $this->include('layout/inc/alert.php') ?>
          <div class="row">
            <div class="col-10 col-lg-11">
              <h5 class="card-title mb-3">Profil</h5>
              
              <div class="row">
                <div class="col-4 col-md-2">Nama</div>
                <div class="col">: <?= esc($pengguna['pengguna_nama']) ?></div>
              </div>
              
              <div class="row">
                <div class="col-4 col-md-2">Username</div>
                <div class="col">: <?= esc($pengguna['pengguna_username']) ?></div>
              </div>
              
              <div class="row">
                <div class="col-4 col-md-2">Email</div>
                <div class="col">: <?= esc($pengguna['pengguna_email']) ?></div>
              </div>
              
              <div class="row">
                <div class="col-4 col-md-2">Status</div>
                <div class="col">: <?= esc($pengguna['grup_nama']) . " - " . esc($pengguna['pengguna_status']) ?></div>
              </div>
            </div>

            <div class="col">
              <div class="foto-profil mb-3">
                <img class="foto-profil" src="<?= esc($pengguna['pengguna_foto']) !== null ? base_url('images/profil/') . esc($pengguna['pengguna_foto']) : base_url('images/profil/foto-profil-default.png') ?>">
              </div>
            </div>
          </div>

          <!-- Tombol -->
          <div class="row mt-3 justify-content-center">
              <a href="<?= route_to('penggunaRincian', esc($pengguna['pengguna_username'])) ?>" class="btn btn-sm btn-primary me-2 mt-1" style="width: 88px;">
                Kembali
              </a>
          </div>
        </div>
      </div>

      <!-- Data Wishlists -->
      <div class="row card my-4" id="panduan">
        <div class="card-body">
          <?php if ($wishlist_list !== []) : 
            $no = 1;  
          ?>

            <div class="row mb-3 justify-content-between">
              <div class="col">
                <h4>Wishlists</h4>
              </div>
              <div class="col">
                <a href="<?= route_to('wishlistTambahForm') ?>?u=<?= esc($pengguna['pengguna_username']) ?>" class="btn btn-primary float-end">Tambah</a>
              </div>
            </div>

            <!-- Khusus Pegawai/Admin -->
            <div class="border border-primary-subtle rounded pt-2 px-2 mb-4">
              <b>Untuk mengkonfirmasi pengajuan peminjaman buku:</b>
              <ol>
                <li>
                  Ubah label buku sesuai buku yang akan dipinjam
                </li>
                <li>
                  Ubah status dari "wishlist" ke "konfirmasi". <br>
                  <i>(Biarkan status "wishlist" bila buku tidak jadi dipinjam)</i>
                </li>
                <li>
                  Bila semua buku yang akan dipinjam sudah dicek, tekan tombol "konfirmasi"
                </li>
              </ol>
            </div>

            <!-- Ini nanti dites dulu hasil data yg dikirimnya gimana kalo banyak input yang namanya sama -->
            <?= form_open(route_to('peminjamanTambahAction')) ?>
            <?php foreach ($wishlist_list as $wishlist_item) :
              $max_length = 25;
            ?>
            <!-- Wishlist Item -->

            <div class="row my-3 mx-2 p-1 border rounded" id="wishlist-<?= $no++ ?>">
              <div class="col-md-4">
                <div class="sampul-preview">
                  <img class="card-img sampul mt-1" src="<?= base_url('images/buku/') . esc($wishlist_item['buku_foto']) ?>" alt="<?= esc($wishlist_item['buku_foto']) ?>">
                </div>
              </div>

              <div class="col">
                <!-- Judul Buku -->
                <div class="form-floating mb-2">
                  <input type="text" name="buku_judul" id="wishlistJudulInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="Judul Buku" disabled value="<?= old('buku_judul') !== null ? old('buku_judul') : esc($wishlist_item['buku_judul']) ?>">
                  <label for="wishlistJudulInput">Judul Buku</label>
                </div>
                
                <!-- Label Buku -->
                <div class="form-floating mb-2">
                  <input type="text" name="seri_kode" id="wishlistKodeInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="Label Buku" maxlength="14" required value="<?= old('seri_kode') !== null ? old('seri_kode') : esc($wishlist_item['seri_kode']) ?>">
                  <label for="wishlistKodeInput">Label Buku</label>
                </div>

                <!-- Status -->
                <div class="form-floating mb-2">
                  <?php
                  $pilihan_status = [
                    "wishlist"   => "Wishlist",
                    "konfirmasi" => "Konfirmasi"
                  ];

                  $hiasan = [
                    "class" => "form-control",
                    "id"    => "floatingStatusInput"
                  ];

                  echo form_dropdown("status", $pilihan_status, old('status') !== null ? old('status') : esc($wishlist_item['status']), $hiasan);
                  ?>
                  <label for="floatingStatusInput">Status</label>
                </div>
              </div>
            </div>
              
          <?php endforeach ?>

          <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
            <button type="submit" class="btn btn-primary btn-block">Konfirmasi Pengajuan</button>
          </div>
              
          <p class="text-center"><a href="<?= route_to('penggunaRincian', esc($pengguna['pengguna_username'])) ?>">Batal</a></p>
          </form>
        <?php else : ?>
          <h4>Wishlists Kosong</h4>
        <?php endif ?>

        </div>
      </div>

    </div>
  </div>

<?= $this->endSection() ?>