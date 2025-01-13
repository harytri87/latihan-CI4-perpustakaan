<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\PeminjamanModel;
use App\Models\WishlistModel;
use App\Models\BukuModel;
use App\Models\NomorSeriModel;
use App\Models\PenggunaModel;
use CodeIgniter\I18n\Time;

class PeminjamanController extends BaseController
{
	public function index()
	{
		// Menampilkan semua data peminjaman

		$cariKeyword = $this->request->getVar('cari');
		$cariStatus = $this->request->getVar('status');

		$peminjamanModel = new PeminjamanModel();
		$data = [
			'peminjaman_list' => $peminjamanModel->getPeminjaman($cariKeyword, $cariStatus),
			'pager'         	=> $peminjamanModel->pager,
			'title'         	=> 'Data Peminjaman | Perpustakaan',
			'penomoran'     	=> 20,	// samain sama paginate() di model getPeminjaman()
			'cari_keyword'  	=> $cariKeyword,
			'cari_status'   	=> $cariStatus,
		];

		return view('halaman/peminjaman/index', $data);
	}

	public function show($peminjaman_id)
	{
		// Menampilkan rincian peminjaman sesuai kode peminjaman

		$username = $this->request->getVar('u');
		$peminjamanModel = new PeminjamanModel();
		$penggunaModel = new PenggunaModel();
		$data = [
			'peminjaman' => $peminjamanModel->getSatuPeminjaman($peminjaman_id),
			'title'      => 'Rincian Peminjaman | Perpustakaan'
		];

		if ($data['peminjaman'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data peminjaman: ' . $peminjaman_id);
		}

		$data['title'] = "Peminjaman " . $data['peminjaman']['peminjaman_kode'] . " | Perpustakaan";

		// Kalo ke halaman rincian peminjaman dari halaman rincian pengguna
    if (isset($username)) {
      $pengguna = $penggunaModel->getPengguna($username);
      if ($pengguna !== null) {
        $data['username'] = $pengguna['pengguna_username'];
      }
    }

		return view('halaman/peminjaman/rincian', $data);
	}

	public function new()
	{
    // Form tambah peminjaman baru

		$username = $this->request->getVar('u');

    $nomorSeriModel = new NomorSeriModel();
    $penggunaModel = new PenggunaModel();
    $dataNomorSeri = $nomorSeriModel->getNomorSeri("", "tersedia")->findAll();
    $dataPengguna = $penggunaModel->getAktifBukanAdmin();
    $seriList = [];
    $penggunaList = [];

    // Daftar buku buat option datalist
    foreach ($dataNomorSeri as $seri) {
      $seriList[$seri['isbn']] = [$seri['buku_judul'], $seri['buku_foto'], $seri['seri_kode']];
    }

    // Daftar pengguna buat option datalist
		 // Cuma anggota & pegawai aktif (non admin)
    foreach ($dataPengguna as $pengguna) {
      $penggunaList[$pengguna['pengguna_username']] = $pengguna['pengguna_email'];
    }

		$data = [
			'buku_list'       => $seriList,
			'pengguna_list'   => $penggunaList,
      'email_preset'    => '',
      'username_preset' => '',
			'title'           => 'Tambah Data Peminjaman Baru | Perpustakaan'
		];
    
    // Kalo admin mau nambahin peminjaman dari rincian CRUD pengguna
    if (isset($username)) {
      $pengguna = $penggunaModel->getPengguna($username);
      if ($pengguna !== null) {
        $data['email_preset'] = $pengguna['pengguna_email'];
        $data['username_preset'] = $pengguna['pengguna_username'];
      }
    }

		return view('halaman/peminjaman/tambah', $data);
	}

	public function create()
	{
    // Proses memasukan data peminjaman baru

		$peminjamanModel = new PeminjamanModel();
    $bukuModel = new BukuModel();
    $seriModel = new NomorSeriModel();
    $penggunaModel = new PenggunaModel();
		$dataPost = $this->request->getPost();
		$buku = $bukuModel->getBuku($dataPost['isbn']);
    $seri = $seriModel->satuNomorSeri($dataPost['seri_kode']);
    $pengguna = $penggunaModel->getPengguna($dataPost['pengguna_username']);
    $notif = [];

    // Cek ketersediaan
    if ($pengguna === null) {
      $notif[0] = 'Data anggota tidak ditemukan';
    }
		
    if ($buku === null) {
      $notif[1] = 'Judul buku tidak sesuai';
    }

		if ($dataPost['buku_judul'] !== '' && $dataPost['isbn'] === '') {
			$adaBuku = $bukuModel->cekAda($dataPost['buku_judul']);

			if ($adaBuku === 0) {
				$notif[1] = 'Judul buku tidak sesuai';
			}
		}

    if ($seri === null) {
      $notif[2] = 'Label buku tidak sesuai';
    } else {
			if ($seri['status_buku'] !== 'tersedia') {
				$notif[2] = 'Label buku sedang tidak tersedia';
			}
		}

    if ($notif !== []) {
			if (isset($dataPost['redirect'])) {
        $redirect = "?u=" . $dataPost['pengguna_username'];

        return redirect()
          ->to(route_to('peminjamanTambahForm') . $redirect)->with('errors', $notif)->withInput();
      } else {
      	return redirect()->route('peminjamanTambahForm')->with('errors', $notif)->withInput();
      }
    }

    // Cek buku yang sama udah ada di peminjamannya belum
    $cekDuplikat = $peminjamanModel->cekDuplikat($pengguna['pengguna_id'], $dataPost['isbn']);

    if ($cekDuplikat > 0) {
			if (isset($dataPost['redirect'])) {
        $redirect = "?u=" . $dataPost['pengguna_username'];

        return redirect()
          ->to(route_to('peminjamanTambahForm') . $redirect)
          ->with('errors', ['Setiap anggota hanya dapat meminjam satu buku yang sama'])
          ->withInput();
      } else {
        return redirect()->route('peminjamanTambahForm')->with('errors', ['Setiap anggota hanya dapat meminjam satu buku yang sama'])->withInput();
      }
    }
		
		$tanggalPeminjaman = Time::parse($dataPost['peminjaman_tanggal']);
		$tanggalPeminjamanBaru = $tanggalPeminjaman->toLocalizedString('yyyy-MM-dd HH:mm:ss');
		$tanggalKode = $tanggalPeminjaman->toLocalizedString('ddMMyyyy');

    // Data yang bakal disimpen
    $data = [
			'peminjaman_kode' => $pengguna['pengguna_id'] . "-" . $tanggalKode,
			'peminjaman_durasi' => $dataPost['peminjaman_durasi'],
			'peminjaman_tanggal' => $tanggalPeminjamanBaru,
      'seri_id' => $seri['seri_id'],
      'pengguna_id' => $pengguna['pengguna_id'],
      'peminjaman_status' => 'dipinjam'
    ];

    if ($peminjamanModel->save($data) === false) {
			// Gagal input data
			if (isset($dataPost['redirect'])) {
        $redirect = "?u=" . $dataPost['pengguna_username'];

        return redirect()
          ->to(route_to('peminjamanTambahForm') . $redirect)
          ->with('errors', $peminjamanModel->errors())
          ->withInput();
      } else {
				return redirect()->route('peminjamanTambahForm')->with('errors', $peminjamanModel->errors())->withInput();
      }
    }

    // Berhasil input data
    // Ubah status di table nomor_seri
		if ($seriModel->update($seri['seri_id'], ['status_buku' => 'dipinjam']) === false) {
			// Kalo gagal ubah, hapus lagi data peminjaman yang baru diiunput di atas
			if ($peminjamanModel->delete(['seri_id' => $seri['seri_id'], 'pengguna_id' => $pengguna['pengguna_id']]) === false) {
				
			if (isset($dataPost['redirect'])) {
        $redirect = "?u=" . $dataPost['pengguna_username'];

        return redirect()
          ->to(route_to('peminjamanTambahForm') . $redirect)
          ->with('errors', ['Terjadi kesalahan. Mohon ulangi prosesnya dari awal'])
          ->withInput();
      } else {
				return redirect()->route('peminjamanTambahForm')->with('errors', ['Terjadi kesalahan. Mohon ulangi prosesnya dari awal'])->withInput();
      }
			}
		}

    // Berhasil semua
    if (isset($dataPost['redirect'])) {
      return redirect()->route('penggunaRincian', [$dataPost['pengguna_username']])->with('message', 'Data peminjaman berhasil ditambahkan!');
    } else {
			return redirect()->route('peminjamanIndex')->with('message', 'Data peminjaman berhasil ditambahkan!');
    }
	}

	public function edit($peminjaman_id)
	{
		// Tampilan form ubah data peminjaman

		$peminjamanModel = new PeminjamanModel();
    $nomorSeriModel = new NomorSeriModel();
    $penggunaModel = new PenggunaModel();
    $dataNomorSeri = $nomorSeriModel->getNomorSeri("", "tersedia")->findAll();
    $dataPengguna = $penggunaModel->getAktifBukanAdmin();
    $seriList = [];
    $penggunaList = [];

		$data = [
			'peminjaman' 		=> $peminjamanModel->getSatuPeminjaman($peminjaman_id),
			'title'      		=> 'Ubah Data Peminjaman | Perpustakaan',
			'seri_list'     => [],
			'pengguna_list' => []
		];

		if ($data['peminjaman'] === null) {
			throw new PageNotFoundException('Tidak dapat menemukan data peminjaman: ' . $peminjaman_id);
		}

		// Daftar buku buat option datalist
    foreach ($dataNomorSeri as $seri) {
      $seriList[$seri['isbn']] = [$seri['buku_judul'], $seri['buku_foto'], $seri['seri_kode']];
    }

    // Daftar pengguna buat option datalist
    foreach ($dataPengguna as $pengguna) {
      $penggunaList[$pengguna['pengguna_username']] = [$pengguna['pengguna_email'], $pengguna['pengguna_nama']];
    }

		$data['seri_list'] = $seriList;
		$data['pengguna_list'] = $penggunaList;
		$data['title'] = "Peminjaman " . $data['peminjaman']['peminjaman_kode'] . " | Perpustakaan";

		return view('halaman/peminjaman/ubah', $data);
	}

	public function update($peminjaman_id)
	{
		// Proses ubah data peminjaman

    $waktu = new Time();
		$peminjamanModel = new PeminjamanModel();
    $bukuModel = new BukuModel();
    $seriModel = new NomorSeriModel();
    $penggunaModel = new PenggunaModel();
		$dataPost = $this->request->getPost();
		$peminjaman = $peminjamanModel->getSatuPeminjaman($peminjaman_id);
    $notif = [];
		$dendaPerHari = 1000;
		$dendaRusak = 40000;
		$jumlahDendaTelat = 0;
		$jumlahDendaRusak = 0;
		$keteranganTelat = "";
		$keteranganRusak = "";

		// Controller yang sama dipake 2 di halaman yang beda
		// Beda halaman sama beda bentuk form-nya jadi pusing

		if (isset($dataPost['isbn']) && isset($dataPost['seri_kode']) && isset($dataPost['pengguna_username'])) {
			$buku = $bukuModel->getBuku($dataPost['isbn']);
			$seri = $seriModel->satuNomorSeri($dataPost['seri_kode']);
			$pengguna = $penggunaModel->getPengguna($dataPost['pengguna_username']);

			// Cek ketersediaan
			if ($peminjaman === null) {
				$notif[0] = 'Data peminjaman tidak ditemukan';
			}

			if ($pengguna === null) {
				$notif[1] = 'Data anggota tidak ditemukan';
			}

			if ($buku === null) {
				$notif[2] = 'Judul buku tidak sesuai';
			}
	
			if ($dataPost['buku_judul'] !== '' && $dataPost['isbn'] === '') {
				$adaBuku = $bukuModel->cekAda($dataPost['buku_judul']);
	
				if ($adaBuku === 0) {
					$notif[2] = 'Judul buku tidak sesuai';
				}
			}

			if ($seri === null) {
				$notif[3] = 'Label buku tidak sesuai';
			} else {
				if ($seri['status_buku'] !== 'tersedia') {
					if ($seri['seri_id'] !== $peminjaman['seri_id']) {
						$notif[3] = 'Label buku sedang tidak tersedia';
					}
				}
			}

			if ($notif !== []) {
				return redirect()->route('peminjamanUbahForm', [$peminjaman_id])->with('errors', $notif)->withInput();
			}

			// Cek buku yang sama udah ada di peminjamannya belum
			if ($pengguna['pengguna_id'] !== $peminjaman['pengguna_id']) {
				// Data peminjam diubah
				$cekDuplikat = $peminjamanModel->cekDuplikat($pengguna['pengguna_id'], $dataPost['isbn']);

				if ($cekDuplikat > 0) {
					return redirect()->route('peminjamanUbahForm', [$peminjaman_id])->with('errors', ['Setiap anggota hanya dapat meminjam satu buku yang sama'])->withInput();
				}
			} else {
				$seriSementara = $seriModel->find($peminjaman['seri_id']);
				if ($dataPost['isbn'] !== $seriSementara['isbn']) {
					// Data peminjam tetap sama tapi data buku yang dipinjam diubah
					// Cek data buku yang barunya duplikat ga
					$cekDuplikat = $peminjamanModel->cekDuplikat($pengguna['pengguna_id'], $dataPost['isbn']);

					if ($cekDuplikat > 0) {
						return redirect()->route('peminjamanUbahForm', [$peminjaman_id])->with('errors', ['Setiap anggota hanya dapat meminjam satu buku yang sama'])->withInput();
					}
				}
			}
			// Kalo data peminjam & data judul buku tetep sama (/cuma ngubah label), ga usah cek duplikat. Jadi ga ada if else lain

			// Cek apa peminjam & tanggalnya juga ikut diubah
			$tanggalPeminjaman = Time::parse($dataPost['peminjaman_tanggal']);
			$tanggalPeminjamanBaru = $tanggalPeminjaman->toLocalizedString('yyyy-MM-dd HH:mm:ss');

			if ($pengguna['pengguna_id'] !== $peminjaman['pengguna_id']
					|| $peminjaman['peminjaman_tanggal'] !== $tanggalPeminjamanBaru) {
				$tanggal = $tanggalPeminjaman->toLocalizedString('ddMMyyyy');
				$dataPost['peminjaman_kode'] = $pengguna['pengguna_id'] . "-" . $tanggal;
				$dataPost['pengguna_id'] = $pengguna['pengguna_id'];
			}

			// Data yang bakal disimpen ($dataPost + beberapa yang di bawah)
			$dataPost['seri_id'] = $seri['seri_id'];
			$dataPost['peminjam_id'] = $pengguna['pengguna_id'];
		} else {
			$seri = $seriModel->find($peminjaman['seri_id']);
			$pengguna = $penggunaModel->find($peminjaman['pengguna_id']);
		}

    // Data yang bakal disimpen ($dataPost + beberapa yang di bawah)
			// Semuanya baru diubah kalo buku udah dikembaliin / pengembalian_tanggal diisi

		// Data pengembalian tanggal
		if ($dataPost['pengembalian_tanggal'] === "") {
			// Biar yang dikirim bener NULL, default POST itu ga bisa null & malah ngisi 0000-00-00 di database
			$dataPost['pengembalian_tanggal'] = null;

			// Kalo lupa ngubah status pengembalian pas ngehapus data tanggal pengembalian
			$dataPost['peminjaman_status'] = 'dipinjam';
			$dataPost['pengembalian_status'] = null;
		} else {
			// Kalo lupa ngubah status peminjaman pas nput data tanggal pengembalian
			$dataPost['peminjaman_status'] = 'selesai';

			// Cek telat ga
			if (isset($dataPost['peminjaman_durasi']) && isset($dataPost['peminjaman_tanggal'])) {
				// Dari halaman ubah
				$durasi = $dataPost['peminjaman_durasi'];
				$tanggalPeminjaman = Time::parse($dataPost['peminjaman_tanggal']);
			} else {
				// Dari halaman rincian
				$durasi = $peminjaman['peminjaman_durasi'];
				$tanggalPeminjaman = Time::parse($peminjaman['peminjaman_tanggal']);
			}

			$tanggalPengembalian = Time::parse($dataPost['pengembalian_tanggal']);
			$tenggat = Time::parse("$tanggalPeminjaman+$durasi days");
			$beda = $tenggat->difference($tanggalPengembalian);

			if ($beda->getDays() > 0) {
				// Jumlah denda & keterangannya
				$jumlahDendaTelat = $dendaPerHari * $beda->getDays();
				$keteranganTelat = "Telat " . $beda->getDays() . " hari, denda " . formatRupiah($jumlahDendaTelat) . ".";

				if ($dataPost['pengembalian_status'] === "tepat waktu") {
					if (isset($dataPost['redirect'])) {
						// Ke halaman rincian
						return redirect()->route('peminjamanRincian', [$peminjaman_id])->with('errors', ['Status Pengembalian tidak sesuai'])->withInput();
					} else {
						// Ke halaman ubah
						return redirect()->route('peminjamanUbahForm', [$peminjaman_id])->with('errors', ['Status Pengembalian tidak sesuai'])->withInput();
					}
				}
			}

			// Data pengembalian status
			if ($dataPost['pengembalian_status'] === "") {
				// Kalo lupa ngubah status pengembalian pas input data tanggal pengembalian
				$dataPost['pengembalian_status'] = null;
			}

			if ($dataPost['pengembalian_status'] === "rusak") {
				// Rusak, isi denda & keterangan
				$jumlahDendaRusak = $dendaRusak;
				$keteranganRusak = "Rusak, denda " . formatRupiah($jumlahDendaRusak) . ".";
			}

			// Data denda
			if (isset($dataPost['denda']) && $dataPost['denda'] !== "0" && $dataPost['denda'] !== "") {
				// Dari halaman ubah & dendanya udah diisi manual atau bukan "0"
				$dataPost['denda'] = $dataPost['denda'];
			} else {
				// Dendanya 0 atau ga diisi
				$dataPost['denda'] = $jumlahDendaTelat + $jumlahDendaRusak;
			}

			// Data keterangan
			if (isset($dataPost['keterangan']) && $dataPost['keterangan'] !== "") {
				// Dari halaman ubah & keterangannya udah diisi manual atau bukan ""
				$dataPost['keterangan'] = $dataPost['keterangan'];
			} else {
				// Keterangannya "" atau ga diisi
				if ($keteranganTelat === "" && $keteranganRusak === "") {
					$dataPost['keterangan'] = "-";
				} else {
					$dataPost['keterangan'] = $keteranganTelat . " " . $keteranganRusak;
				}
			}
		}


    // Ubah data peminjaman
    if ($peminjamanModel->update($peminjaman_id, $dataPost) === false) {
			// Kalo gagal ubah
			if (isset($dataPost['redirect'])) {
				// Ke halaman rincian
				return redirect()->route('peminjamanRincian', [$peminjaman_id])->with('errors', $peminjamanModel->errors())->withInput();
			} else {
				// Ke halaman ubah
				return redirect()->route('peminjamanUbahForm', [$peminjaman_id])->with('errors', $peminjamanModel->errors())->withInput();
			}
    }

    // Berhasil ubah data peminjaman
		if ($seri['seri_id'] !== $peminjaman['seri_id']) {
			// Berarti dari halaman ubah & seri_kodenya diganti
			// Seri yang sebelumnya harus balik ke tersedia
			if ($seriModel->update($peminjaman['seri_id'], ['status_buku' => 'tersedia']) === false) {
				return redirect()->route('peminjamanIndex')->with('errors', ['Terjadi kesalahan (Status seri-1).']);
			}
		}

		// Terus ada 2 kemungkinan, dari halaman rincian atau dari halaman ubah tapi seri_kode ga diubah
		// Biar aman, cek data peminjaman yang udah diubah
		$peminjaman = $peminjamanModel->getSatuPeminjaman($peminjaman_id);

		if ($peminjaman['peminjaman_status'] === "selesai") {
			if ($peminjaman['pengembalian_status'] === "rusak") {
				// buku dikembaliin rusak
				if ($seriModel->update($peminjaman['seri_id'], ['status_buku' => 'rusak']) === false) {
					return redirect()->route('peminjamanIndex')->with('errors', ['Terjadi kesalahan (Status seri-2).']);
				}
			} else {
				// Buku dikembaliin normal, harus ubah ke status "tersedia"
				if ($seriModel->update($peminjaman['seri_id'], ['status_buku' => 'tersedia']) === false) {
					return redirect()->route('peminjamanIndex')->with('errors', ['Terjadi kesalahan (Status seri-3).']);
				}
			}
		} else {
			// Buku belum dikembaliin, harus ubah ke status "dipinjam"
			if ($seriModel->update($peminjaman['seri_id'], ['status_buku' => 'dipinjam']) === false) {
				return redirect()->route('peminjamanIndex')->with('errors', ['Terjadi kesalahan (Status seri-4).']);
			}
		}

		// Selesai
		if (isset($dataPost['redirect'])) {
			// Dari halaman rincian balik ke rincian yang sama
			return redirect()->route('peminjamanRincian', [$peminjaman_id])->with('message', 'Konfirmasi pengembalian buku berhasil!');
		} else {
			// Dari halaman ubah ke index peminjaman
    	return redirect()->route('peminjamanIndex')->with('message', 'Data peminjaman berhasil diubah!');
		}
	}


	public function delete($peminjaman_id)
  {
    // Menghapus data peminjaman

    $peminjamanModel = new PeminjamanModel();
    $seriModel = new NomorSeriModel();
		$peminjaman = $peminjamanModel->find($peminjaman_id);

		// Cek ketersediaan data
    if (! $peminjaman) {
      return redirect()->route('peminjamanIndex')->with('error', 'Data peminjaman tidak tersedia.');
    }

		// Ubah status seri jadi "tersedia" sebelum dihapus
		if ($seriModel->update($peminjaman['seri_id'], ['status_buku' => 'tersedia']) === false) {
			return redirect()->route('peminjamanIndex')->with('errors', $seriModel->errors());
		}

		// Hapus data peminjaman
		if ($peminjamanModel->delete($peminjaman_id) === false) {
			// Gagal hapus data peminjaman, jadi pastiin seri status masih "dipinjam"
			if ($seriModel->update($peminjaman['seri_id'], ['status_buku' => 'dipinjam']) === false) {
				return redirect()->route('peminjamanIndex')->with('errors', $seriModel->errors());
			}

			return redirect()->route('peminjamanIndex')->with('errors', $peminjamanModel->errors());
		}

		return redirect()->route('peminjamanIndex')->with('message', 'Data peminjaman berhasil dihapus!');
  }
}
