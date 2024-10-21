<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? esc($title) : 'Perpustakaan'; ?></title>
  <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('bootstrap-icons/font/bootstrap-icons.min.css') ?>">
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
              Apakah yakin ingin menghapus?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include('inc/footer.php') ?>

  <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

  <!-- JS buat ngehapus data pake Bootstrap modal -->
  <script type="text/javascript">
    const hapusData = document.getElementById('hapusData')
    if (hapusData) {
      hapusData.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const nama = button.getAttribute('data-bs-nama')
        const urlHapus = button.getAttribute('data-bs-url')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.
        // ga pake Ajax sih, langsung lewat form di modalnya

        // Update the modal's content.
        const modalTitle = hapusData.querySelector('.modal-title')
        const modalContentForm = hapusData.querySelector('.modal-dialog form')

        modalTitle.textContent = `Hapus Data ${nama}`
        document.getElementById('formHapus').action = urlHapus
      })
    }
  </script>
</body>
</html>