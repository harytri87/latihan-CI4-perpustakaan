<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? esc($title) : 'Perpustakaan'; ?></title>
  <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('bootstrap-icons/font/bootstrap-icons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
  <?php include('inc/navbar.php') ?>

  <section style="min-height: 84vh;">
    <?= $this->renderSection('content') ?>

    <!-- Modal -->
    <div class="modal fade" id="hapusData" tabindex="-1" aria-labelledby="hapusDataLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="" method="post" id="formHapus">
          <?= csrf_field() ?>
          <input type="hidden" name="_method" value="DELETE">
          <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="hapusDataLabel">Hapus Grup</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Apakah yakin ingin menghapus? Termasuk semua data terkaitnya
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <?php include('inc/footer.php') ?>

  <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

  <!-- JS buat ngehapus data pake Bootstrap modal -->
  <script type="text/javascript">
    // Mendengarkan event 'show.bs.modal' untuk masing-masing modal
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
      button.addEventListener('click', function (event) {
        // Mengambil data dari tombol yang diklik
        const title = button.getAttribute('data-title');
        const nama = button.getAttribute('data-bs-nama');
        const judulBuku = button.getAttribute('data-bs-judulBuku');
        const statusBuku = button.getAttribute('data-bs-statusBuku');
        const isbnBuku = button.getAttribute('data-bs-isbnBuku');
        const urlAksi = button.getAttribute('data-bs-url');
        const targetModalId = button.getAttribute('data-bs-target').substring(1); // ID modal yang sesuai

        // Menentukan modal berdasarkan ID target
        const modal = document.getElementById(targetModalId);
        const modalTitle = modal.querySelector('.modal-title');
        const textJudul = modal.querySelector('#floatingJudulInput');
        const formAksi = modal.querySelector('form');

        // Mengubah konten utama modal

        // Mengubah konten input sesuai dengan data dari masing-masing tombol
        if (targetModalId === 'modalTambah') {
          // Jika modal tambah, set isbn

          const textISBN = modal.querySelector('#floatingISBNInput');
          textISBN.value = isbnBuku;
          modalTitle.textContent = title;
          textJudul.value = judulBuku;
          formAksi.action = urlAksi;

        } else if (targetModalId === 'modalUbah') {
          // Jika modal ubah, set status default sesuai yg di database

          const textStatus = modal.querySelector('#floatingSelect');
          textStatus.value = statusBuku;
          modalTitle.textContent = title;
          textJudul.value = judulBuku;
          formAksi.action = urlAksi;

        } else if (targetModalId === 'hapusData') {
          // Jika modal hapus, set judul doang, id udh dari url di atas
          modalTitle.textContent = `Hapus Data: ${nama}`;
          formAksi.action = urlAksi;
        }
      });
    });


    // Referensi elemen input dan datalist buat Wishlist
    // Variabelnya ditambahin kata "wishlist" biar ga tabrakan sama script lain
    // User
    const emailInputWishlist = document.getElementById('wishlistEmailInput');
    const usernameInputWishlist = document.getElementById('wishlistUsernameInput');
    const emailListWishlist = document.getElementById('wishlist_email_list');
    // Buku
    const judulBukuInputWishlist = document.getElementById('wishlistJudulInput');
    const isbnBukuInputWishlist = document.getElementById('wishlistISBNInput');
    const bukuListWishlist = document.getElementById('wishlist_buku_list');
    // Foto
    const fotoDivWishlist = document.getElementById('fotoDivWishlist');
    const fotoImgWishlist = document.getElementById('fotoImgWishlist');

    // Event saat user memilih dari emailList
    emailInputWishlist.addEventListener('input', function () {
      const options = emailListWishlist.options;
      let found = false;

      for (let i = 0; i < options.length; i++) {
        if (options[i].value === this.value) {
          // Masukkan data kode buku ke hidden input
          usernameInputWishlist.value = options[i].getAttribute('data-username-wishlist');
          found = true;
          break;
        }
      }

      if (!found) {
        usernameInputWishlist.value = '';
      }
    });

    // Event saat user memilih dari bukuList
    judulBukuInputWishlist.addEventListener('input', function () {
      const options = bukuListWishlist.options;
      let found = false;

      for (let i = 0; i < options.length; i++) {
        if (options[i].value === this.value) {
          // Masukkan data kode buku ke hidden input
          isbnBukuInputWishlist.value = options[i].getAttribute('data-isbn-wishlist');
          fotoImgWishlist.src = options[i].getAttribute('data-foto-wishlist');
          fotoDivWishlist.style.display = 'block';

          found = true;
          break;
        }
      }

      if (!found) {
        isbnBukuInputWishlist.value = '';
        fotoImgWishlist.src = '/';
        fotoDivWishlist.style.display = 'none';
      }
    });
  </script>
</body>
</html>