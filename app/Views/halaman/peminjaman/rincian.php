<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <?php $session = session(); ?>

  <div class="card container my-4">
    <div class="card-body">
      <?= $this->include('layout/inc/alert.php') ?>

      <!-- Anggota biasa boleh kesini, tapi hapusin tombol / link yang berhubungan sama admin -->
       <!-- Eh atau bikin routes baru aja, kayak rincian buku tapi pake controller yang asli -->

      <?php
        use CodeIgniter\I18n\Time;

        $waktu = new Time();

        $sisaHari = esc($peminjaman['sisa_hari']) >= 0 ? "sisa " . esc($peminjaman['sisa_hari']) . " hari" : 'telat ' . substr(esc($peminjaman['sisa_hari']), 1) . " hari";
      ?>

      <?= form_open(route_to('peminjamanUbahAction', esc($peminjaman['peminjaman_id']))) ?>
        <input type="hidden" name="_method" value="PUT"/>

        <!-- Buat bedain redirect backnya ke halaman ini atau halaman ubah -->
          <div class="form-floating mb-2">
            <input type="hidden" name="redirect" id="floatingRedirectInput" class="form-control" placeholder="Redirect" minlength="13" maxlength="13" value="rincian">
            <!-- <label for="floatingRedirectInput">Redirect</label> -->
          </div>

        <!-- Data Peminjaman -->
        <div class="row">

          <!-- Foto Sampul Buku -->
          <div class="col-md-4 mb-3">
            <div class="my-3 sampul-rinci" id="fotoDiv">
              <img class="sampul" src="<?= base_url('images/buku/') . esc($peminjaman['buku_foto']) ?>" alt="<?= esc($peminjaman['buku_judul']) ?>">
            </div>
          </div>

          <!-- Data -->
          <div class="col-lg-8">
            <div class="table-responsive">
              <table class="table table-hover">
                <tbody>
                  <!-- Nama Peminjam -->
                  <tr>
                    <td class="align-middle">Nama Peminjam</td>
                    <td class="align-middle text-center">:</td>
                    <td><?= esc($peminjaman['pengguna_nama']) ?></td>
                  </tr>
                  
                  <!-- Email Peminjam -->
                  <tr>
                    <td class="align-middle">Email Peminjam</td>
                    <td class="align-middle text-center">:</td>
                    <td><?= esc($peminjaman['pengguna_email']) ?></td>
                  </tr>
                  
                  <!-- Judul Buku -->
                  <tr>
                    <td class="align-middle">Judul Buku</td>
                    <td class="align-middle text-center">:</td>
                    <td><?= esc($peminjaman['buku_judul']) ?></td>
                  </tr>
                  
                  <!-- seri_kode / Label Buku -->
                  <tr>
                    <td class="align-middle">Label Buku</td>
                    <td class="align-middle text-center">:</td>
                    <td><?= esc($peminjaman['seri_kode']) ?></td>
                  </tr>
                  
                  <!-- Durasi Peminjaman -->
                  <tr>
                    <td class="align-middle">Durasi Peminjaman</td>
                    <td class="align-middle text-center">:</td>
                    <td><?= esc($peminjaman['peminjaman_durasi']) ?> hari</td>
                  </tr>
                  
                  <!-- Tanggal Peminjaman -->
                  <tr>
                    <td class="align-middle">Tanggal Peminjaman</td>
                    <td class="align-middle text-center">:</td>
                    <td><?= esc($peminjaman['peminjaman_tanggal']) ?></td>
                  </tr>
                  
                  <!-- Tanggal Pengembalian -->
                  <?php if (esc($peminjaman['pengembalian_tanggal']) !== null) : ?>
                    <tr>
                      <td class="align-middle">Tanggal Pengembalian</td>
                      <td class="align-middle text-center">:</td>
                      <td><?= esc($peminjaman['pengembalian_tanggal']) ?></td>
                    </tr>
                  <?php else : ?>
                    <!-- Kalo konfirmasi pengembalian, tanggalnya harus tanggal sekarang -->
                     <!-- Jadi disembunyiin biar ga bisa diubah -->
                    <tr style="display: none;">
                      <td colspan="3">
                        <div class="form-floating">
                          <input type="text" name="pengembalian_tanggal" id="pengembalianTanggalInput" autocomplete="off" class="form-control" placeholder="Tanggal Pengembalian" required value="<?= $waktu ?>">
                          <label for="pengembalianTanggalInput">Tanggal Pengembalian</label>
                        </div>
                      </td>
                    </tr>
                  <?php endif ?>
                  
                  <!-- Status Peminjaman -->
                  <tr>
                    <td class="align-middle">Status Peminjaman</td>
                    <td class="align-middle text-center">:</td>
                    <td>
                      <?= esc($peminjaman['pengembalian_status']) !== null ?
                        "selesai - " . esc($peminjaman['pengembalian_status'])
                        : esc($peminjaman['peminjaman_status']) . " - " . $sisaHari
                      ?>
                    </td>
                  </tr>

                  <!-- Status Pengembalian -->
                  <?php if (!isset($halaman) && esc($peminjaman['pengembalian_tanggal']) === null) : ?>
                    <!-- Cuma bisa diliat dari halaman CRUD buat konfirmasi status pengembalian kalo belum dikembaliin -->
                    <tr>
                      <td class="align-middle">Status Pengembalian</td>
                      <td class="align-middle text-center">:</td>
                      <td>
                        <div class="form-floating">
                          <?php
                          $pilihan_status = [
                            ""            => "-- Status Pengembalian --",
                            "tepat waktu" => "tepat waktu",
                            "terlambat"   => "terlambat",
                            "rusak"       => "rusak"
                          ];

                          $hiasan = [
                            "class" => "form-control",
                            "id"    => "floatingStatusPengembalianInput"
                          ];

                          echo form_dropdown("pengembalian_status", $pilihan_status, set_value('pengembalian_status'), $hiasan, 'required'); ?>
                          <label for="floatingStatusPengembalianInput">Status</label>
                        </div>
                      </td>
                    </tr>
                  <?php endif ?>
                  
                  <?php if (esc($peminjaman['pengembalian_tanggal']) !== null) : ?>
                    <!-- Buku udah dikembaliin, tampilin keterangan & dendanya -->
                    <tr>
                      <td class="align-middle">Denda</td>
                      <td class="align-middle text-center">:</td>
                      <td><?= formatRupiah(esc($peminjaman['denda'])) ?></td>
                    </tr>

                    <tr>
                      <td class="align-middle">Keterangan</td>
                      <td class="align-middle text-center">:</td>
                      <td><?= esc($peminjaman['keterangan']) ?></td>
                    </tr>
                  <?php endif ?>
                </tbody>
              </table>
            </div>
          </div>

          <?php if ($session->get('grup') !== 'Anggota') : ?>
            <!-- Tombol -->
            <div class="d-grid col-12 col-lg-5 col-md-7 mx-auto m-3">
              <?php if (esc($peminjaman['pengembalian_tanggal']) === null) : ?>
                <i class="text-center">Pastikan label buku, tanggal pengembalian dan status pengembalian sudah sesuai</i>
                <button type="submit" class="btn btn-primary my-3">Konfirmasi Pengembalian</button>
              <?php else : ?>
                <a class="btn btn-primary my-3" href="<?= route_to('peminjamanUbahForm', esc($peminjaman['peminjaman_id'])) ?>">Ubah Data</a>
              <?php endif ?>

              <?php if (isset($username)) : ?>
                <p class="text-center"><a href="<?= route_to('penggunaRincian', esc($username)) ?>">Kembali</a></p>
              <?php else : ?>
                <p class="text-center"><a href="<?= route_to('peminjamanIndex') ?>">Kembali</a></p>
              <?php endif ?>
            </div>

            <i class="small">Kalo buku belum dikembalikan, bisa ngubah data peminjaman. Tapi di halaman ini buat konfirmasi pengembalian buku aja. Kalo di halaman ubah itu buat ubah semua data peminjaman.</i>
          <?php else : ?>
            <p class="text-center"><a href="<?= route_to('profilRincian', $session->get('username')) ?>">Kembali</a></p>
          <?php endif ?>
        </div>

      </form>

    </div>
  </div>

<?= $this->endSection() ?>