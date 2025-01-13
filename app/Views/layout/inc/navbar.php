<nav class="navbar navbar-expand-lg bg-primary-subtle">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= route_to('index') ?>">Perpustakaan</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end gap-1" id="navbarSupportedContent">
      <?php
        if (isset($nav_cari_keyword)) {
          $nav_cari_keyword = esc($nav_cari_keyword);
        } else {
          $nav_cari_keyword = null;
        }
      ?>
      <form action="<?= route_to('index') ?>" method="get" class="d-flex col-lg-8 mx-auto" role="search">
        <!-- Cari keyword -->
        <input class="form-control me-2 mt-2 mt-lg-0" type="search" name="cari_buku" id="cari_buku" placeholder="Cari Judul / Penulis / ISBN" value="<?= $nav_cari_keyword = esc($nav_cari_keyword) ?? "" ?>" aria-label="Cari buku">
        
        <!-- Cari kategori -->
         <!-- Belum beres, ada di catatan latihan perpustakaan -->
        
        <button class="btn btn-primary mt-2 mt-lg-0" type="submit">Cari</button>
      </form>
      <ul class="navbar-nav">
          <!-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li> -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Data
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= route_to('kategoriIndex') ?>">Kategori</a></li>
              <li><a class="dropdown-item" href="<?= route_to('adminBukuIndex') ?>">Buku</a></li>
              <li><a class="dropdown-item" href="<?= route_to('nomorSeriIndex') ?>">Label Buku</a></li>
              <li><a class="dropdown-item" href="<?= route_to('grupIndex') ?>">Grup Pengguna</a></li>
              <li><a class="dropdown-item" href="<?= route_to('penggunaIndex') ?>">Pengguna</a></li>
              <li><a class="dropdown-item" href="<?= route_to('wishlistIndex') ?>">Wishlist</a></li>
              <li><a class="dropdown-item" href="<?= route_to('peminjamanIndex') ?>">Peminjaman</a></li>
              <!-- <li>
              <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li> -->
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href=<?= route_to('authLoginForm') ?>>Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= route_to('index') ?>">Home</a>
          </li>
      </ul>
    </div>
  </div>
</nav>