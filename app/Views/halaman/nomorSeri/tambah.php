<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" method="post" id="modalForm">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Modal 1</h5>
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
              <option value="">-- Pilih Status --</option>
              <option value="gudang">gudang</option>
              <option value="tersedia">tersedia</option>
              <option value="dipinjam">dipinjam</option>
              <option value="rusak">rusak</option>
              <option value="hilang">hilang</option>
            </select>
            <label for="floatingSelect">Status</label>
          </div>

          <!-- Jumlah -->
          <div class="form-floating mb-2">
            <input type="number" name="jumlah_buku" id="floatingJumlahInput" class="form-control" placeholder="Jumlah" value="">
            <label for="floatingJumlahInput">Jumlah</label>
          </div>

          <!-- ISBN -->
          <div class="form-floating mb-2">
            <input type="hidden" name="isbn" id="floatingISBNInput" class="form-control" placeholder="ISBN" value="/">
            <!-- <label for="floatingISBNInput">ISBN</label> -->
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Tambahkan</button>
        </div>
      </div>
    </form>
  </div>
</div>