<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? esc($title) : 'Perpustakaan'; ?></title>
  <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('bootstrap-icons/font/bootstrap-icons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
  
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

</body>
</html>