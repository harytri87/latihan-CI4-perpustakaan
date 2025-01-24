<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PeminjamanModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Dompdf\Dompdf;

class LaporanController extends BaseController
{
	public function strukPeminjaman($peminjaman_id)
	{
	$session = session();
	$peminjamanModel = new PeminjamanModel();
	$data = [
		'peminjaman' => $peminjamanModel->getSatuPeminjaman($peminjaman_id),
		'title'      => 'Struk Peminjaman | Perpustakaan'
	];

	if ($data['peminjaman'] === null) {
		throw new PageNotFoundException('Tidak dapat menemukan data peminjaman: ' . $peminjaman_id);
	}

	$data['title'] = "Struk Peminjaman " . $data['peminjaman']['peminjaman_kode'] . " | Perpustakaan";
	$namaFile = "Struk Peminjaman " . $data['peminjaman']['peminjaman_kode'] . ".pdf";

	$html = view('halaman/peminjaman/struk', $data);

	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);

	// konversi mm ke points
	$width = 120 * 2.83465;
	$height = 96 * 2.83465;
	// x1, y1 = 0, 0 (posisi kiri atas halaman).
	// x2, y2 = lebar dan tinggi halaman dalam points.
	$customPaper = [0, 0, $width, $height];
	$dompdf->setPaper($customPaper, 'portrait');

	$dompdf->render();

	// Output file PDF (I = inline, D = download)
	$dompdf->stream($namaFile, ['Attachment' => false]);
	}
}
