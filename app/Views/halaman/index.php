<?= $this->extend('layout/layout_utama') ?>

<?= $this->section('content') ?>

  <div class="container-fluid mb-4 mt-2">

    <?= $this->include('layout/inc/alert.php') ?>

    <?php if ($buku_list !== []) : 
      $no = 1 + ($penomoran * ($pager->getCurrentPage() - 1));
    ?>

      <div class="row justify-content-center">

        <?php foreach ($buku_list as $buku_item):
          $no++;
          $max_length = 25;
        ?>
          <div class="col-6 col-md-4 col-lg-3 mt-3" style="max-width: 320px;">
            <div class="card">
              <div class="sampul-preview">
                <img class="card-img sampul mt-1" src="<?= base_url('images/buku/') . esc($buku_item['buku_foto']) ?>" alt="<?= esc($buku_item['buku_foto']) ?>">
              </div>
              <div class="card-body">
                <h5 class="card-title text-center">
                  <abbr class="text-decoration-none" title="<?= esc($buku_item['buku_judul']) ?>">
                    <a class="text-reset text-decoration-none" href="<?= route_to('bukuRincian', esc($buku_item['slug'])) ?>">
                      <?= $tampil = mb_strlen($buku_item['buku_judul']) > $max_length ? mb_substr($buku_item['buku_judul'], 0, $max_length) . '...' : $buku_item['buku_judul']; ?>
                    </a>
                  </abbr>
                </h5>
              </div>
            </div>
          </div>
        <?php endforeach ?>

      </div>

      <div class="row mx-sm-4 mt-3">
        <div class="col">
          <i class="fs-6 fw-lighter">Menampilkan <?=empty($buku_list) ? 0 : 1 + ($penomoran * ($pager->getCurrentPage() - 1))?> - <?=$no-1?> dari <?=$pager->getTotal()?> data</i>
        </div>

        <div class="col">
            <?= $pager->links() ?>
        </div>
      </div>
      <?php else: ?>
          <h4>Data buku tidak ditemukan</h4>
      <?php endif ?>

  </div>


<?= $this->endSection() ?>