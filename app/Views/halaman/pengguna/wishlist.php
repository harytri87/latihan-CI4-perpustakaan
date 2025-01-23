<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?php $session = session() ?>

  <div class="row container-fluid">
    <!-- Sidebar -->
    <nav class="col-2 col-md-1 navbar mx-2 align-items-start">
      <div class="sticky-top mt-3 ms-2">
        <button class="navbar-toggler bg-primary-subtle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Wislists</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              
              <?php if ($wishlist_list !== []) : 
                $no = 1;  
              ?>
                <?php if (esc($halaman) === 'pengguna') : ?>
                  <!-- Khusus Pegawai/Admin -->
                  <li class="nav-item">
                    <a class="nav-link" href="#panduan">Panduan Pegawai</a>
                  </li>
                <?php endif ?>

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
              
              <!-- Data Profil -->
              <div class="row table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Nama</td>
                      <td>:</td>
                      <td>
                        <?= esc($pengguna['pengguna_nama']) ?>
                      </td>
                    </tr>
                    
                    <tr>
                      <td>Username</td>
                      <td>:</td>
                      <td>
                        <?= esc($pengguna['pengguna_username']) ?>
                      </td>
                    </tr>
                    
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td>
                        <?= esc($pengguna['pengguna_email']) ?>
                      </td>
                    </tr>
                    
                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td>
                        <?= esc($pengguna['grup_nama']) . " - " . esc($pengguna['pengguna_status']) ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Foto Profil -->
            <div class="col">
              <div class="foto-profil mb-3">
                <img class="foto-profil" src="<?= esc($pengguna['pengguna_foto']) !== null ? base_url('images/profil/') . esc($pengguna['pengguna_foto']) : base_url('images/profil/foto-profil-default.png') ?>">
              </div>
            </div>
          </div>

          <!-- Tombol -->
          <div class="row mt-3 justify-content-center">
            <?php if (esc($halaman) === 'pengguna') : ?>
              <a href="<?= route_to('penggunaRincian', esc($pengguna['pengguna_username'])) ?>" class="btn btn-sm btn-primary me-2 mt-1" style="width: 88px;">
                Kembali
              </a>
            <?php else : ?>
              <a href="<?= route_to('profilRincian', $session->get('username')) ?>" class="btn btn-sm btn-primary me-2 mt-1" style="width: 88px;">
                Kembali
              </a>
            <?php endif ?>
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
              <?php if (esc($halaman) === 'pengguna') : ?>
                <!-- Dari halaman CRUD bisa nambah wishlist pengguna -->
                <div class="col">
                  <a href="<?= route_to('wishlistTambahForm') ?>?u=<?= esc($pengguna['pengguna_username']) ?>" class="btn btn-primary float-end">Tambah WIshlist</a>
                </div>
              <?php endif ?>
            </div>

            <?php if (esc($halaman) === 'pengguna') : ?>
              <!-- Khusus Pegawai/Admin -->
              <div class="border border-primary-subtle rounded pt-2 px-2 mb-4">
                <b>Untuk mengkonfirmasi pengajuan peminjaman buku:</b>
                <ol>
                  <li>
                    Ubah label buku sesuai buku yang akan dipinjam<br>
                    <i>(Label di buku fisik. Ini web latihan jadi ga ada buku fisik. Cek <a href="<?= route_to('nomorSeriIndex') ?>">daftar label buku</a>)</i>
                  </li>
                  <li>
                    Ubah status dari "wishlist" ke "konfirmasi". <br>
                    <i>(Biarkan status "wishlist" bila buku tidak jadi dipinjam)</i>
                  </li>
                  <li>
                    Bila semua buku yang akan dipinjam sudah dicek, tekan tombol "konfirmasi" di paling bawah.
                  </li>
                </ol>
              </div>
            <?php endif ?>

            <?= form_open(route_to('penggunaUbahWishlist', esc($pengguna['pengguna_username']))) ?>
              <input type="hidden" name="_method" value="PUT"/>
              
              <!-- Username Pengguna -->
              <div class="form-floating mb-2">
                <input type="hidden" name="pengguna_username" id="wishlistJudulInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="Username Pengguna" value="<?= old('pengguna_username') !== null ? old('pengguna_username') : esc($wishlist_item['pengguna_username']) ?>">
                <!-- <label for="wishlistJudulInput">Username Pengguna</label> -->
              </div>

              <?php foreach ($wishlist_list as $wishlist_item) : ?>
                <!-- Wishlist Item -->
                <div class="row my-3 mx-2 p-1 border rounded" id="wishlist-<?= $no++ ?>">
                  <!-- Sampul Buku -->
                  <div class="col-md-4">
                    <div class="sampul-preview">
                      <img class="card-img sampul mt-1" src="<?= base_url('images/buku/') . esc($wishlist_item['buku_foto']) ?>" alt="<?= esc($wishlist_item['buku_foto']) ?>">
                    </div>
                  </div>
                  
                  <!-- Data buku -->
                  <div class="col">
                    <!-- Judul Buku -->
                    <div class="form-floating mb-2">
                      <input type="text" name="buku_judul[]" id="wishlistJudulInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="Judul Buku" disabled value="<?= old('buku_judul') !== null ? old('buku_judul') : esc($wishlist_item['buku_judul']) ?>">
                      <label for="wishlistJudulInput">Judul Buku</label>
                    </div>

                    <!-- Penulis Buku -->
                    <div class="form-floating mb-2">
                      <input type="text" name="buku_penulis[]" id="wishlistPenulisInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="Penulis Buku" disabled value="<?= old('buku_penulis') !== null ? old('buku_penulis') : esc($wishlist_item['buku_penulis']) ?>">
                      <label for="wishlistPenulisInput">Penulis Buku</label>
                    </div>
                    
                    <?php if (esc($halaman) === 'pengguna') : ?>
                      <!-- Dari halaman CRUD -->
                      <!-- ID Wishlist -->
                      <div class="form-floating mb-2">
                        <input type="hidden" name="wishlist_id[]" id="wishlistJudulInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="ID WIshlist" value="<?= old('wishlist_id') !== null ? old('wishlist_id') : esc($wishlist_item['wishlist_id']) ?>">
                        <!-- <label for="wishlistJudulInput">ID WIshlist</label> -->
                      </div>

                      <!-- ID Pengguna -->
                      <div class="form-floating mb-2">
                        <input type="hidden" name="pengguna_id[]" id="wishlistJudulInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="ID Pengguna" value="<?= old('pengguna_id') !== null ? old('pengguna_id') : esc($wishlist_item['pengguna_id']) ?>">
                        <!-- <label for="wishlistJudulInput">ID Pengguna</label> -->
                      </div>
                      
                      <!-- Label Buku -->
                      <div class="form-floating mb-2">
                        <input type="text" name="seri_kode[]" id="wishlistKodeInput" autocomplete="off" list="wishlist_kode_list" class="form-control" placeholder="Label Buku" maxlength="14" required value="<?= old('seri_kode') !== null ? old('seri_kode') : esc($wishlist_item['seri_kode']) ?>">
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

                        echo form_dropdown("status[]", $pilihan_status, old('status') !== null ? old('status') : esc($wishlist_item['status']), $hiasan);
                        ?>
                        <label for="floatingStatusInput">Status</label>
                      </div>
                    <?php endif ?>
                  </div>
                </div>
              <?php endforeach ?>

              <?php if (esc($halaman) === 'pengguna') : ?>
                <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
                  <button type="submit" class="btn btn-primary btn-block">Konfirmasi Pengajuan</button>
                </div>
                    
                <p class="text-center"><a href="<?= route_to('penggunaRincian', esc($pengguna['pengguna_username'])) ?>">Batal</a></p>
              <?php endif ?>
            </form>
          <?php else : ?>
            <h4>Wishlists Kosong</h4>
          <?php endif ?>

        </div>
      </div>

    </div>
  </div>

<?= $this->endSection() ?>