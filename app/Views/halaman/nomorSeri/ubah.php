<!-- Modal Ubah Data -->
<div class="modal fade" id="modalUbah" tabindex="-1" aria-labelledby="modalUbahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" method="post" id="modalForm">
      <?= csrf_field() ?>
      <input type="hidden" name="_method" value="PUT">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUbahLabel">Modal 1</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Judul -->
          <div class="form-floating mb-2">
            <input type="text" name="buku_judul" id="floatingJudulInput" class="form-control" placeholder="Judul" disabled value="/">
            <label for="floatingJudulInput">Judul</label>
          </div>

          <!-- Status -->
          <div class="form-floating mb-2">
            <select class="form-select" name="status_buku" id="floatingSelect">
              <option value="gudang">gudang</option>
              <option value="tersedia">tersedia</option>
              <option value="dipinjam">dipinjam</option>
              <option value="rusak">rusak</option>
              <option value="hilang">hilang</option>
            </select>
            <label for="floatingSelect">Status</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Ubah</button>
        </div>
      </div>
    </form>
  </div>
</div>