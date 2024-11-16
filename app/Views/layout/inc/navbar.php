<nav class="navbar navbar-expand-lg bg-primary-subtle">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Perpustakaan</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end gap-1" id="navbarSupportedContent">
      <?php
        if (isset($cari_keyword)) {
          $cari_keyword = esc($cari_keyword);
        } else {
          $cari_keyword = null;
        }
      ?>
      <form action="<?= route_to('index') ?>" method="get" class="d-flex col-lg-7 mx-auto" role="search">
          <input class="form-control me-2" type="search" name="cari" placeholder="Cari judul buku / penulis buku / ISBN" aria-label="Cari buku" value="<?= $cari_keyword ?>">
          <button class="btn btn-outline-primary" type="submit">Cari</button>
      </form>
      <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
              <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
      </ul>
    </div>
  </div>
</nav>