<?php

function validasiProfil()
{
  // Aturan validasi foto profil

  $validationRule = [
    'pengguna_foto' => [
      // 'label' => 'Foto Profil',	// ini kalo ga pake data 'errors' bakal kepake
      'rules' => [
        'is_image[pengguna_foto]',
        'mime_in[pengguna_foto,image/jpg,image/jpeg,image/png,image/webp]',
        'max_size[pengguna_foto,400]',
        'max_dims[pengguna_foto,1080,1080]',
      ],
      'errors' => [
        'is_image'    => 'Harap pilih gambar foto profil',
        'mime_in'     => 'File gambar tidak didukung',
        'max_size'    => 'File gambar maksimal 400 KB',
        'max_dims'    => 'Resolusi gambar maksimal 1080x1080 pixel'
      ]
    ],
  ];

  return $validationRule;
}

function cekUploadFoto($foto)
{
  // Cek foto profil

  if ($foto != "") {
    // Mindahin foto
    $foto->move(ROOTPATH . 'public/images/profil/', $foto->getRandomName());
    if ($foto->hasMoved()) {
      // Berhasil mindahin foto, ambil namanya buat isi database
      return $foto->getName();
    } else {
      // Gagal
      return redirect()->route('penggunaTambahForm')->with('error', 'Gagal upload foto profil')->withInput();
    }
  }
}

function validasiSampul($adaFoto = false)
{
  // Aturan validasi foto sampul buku

  $validationRule = [
    'buku_foto' => [
      'rules' => [
        'is_image[buku_foto]',
        'mime_in[buku_foto,image/jpg,image/jpeg,image/png,image/webp]',
        'max_size[buku_foto,5000]',
        'max_dims[buku_foto,2700,4880]',
      ],
      'errors' => [
        'is_image' => 'Foto sampul hanya boleh berupa gambar',
        'mime_in'  => 'File gambar tidak didukung',
        'max_size' => 'File gambar maksimal 5 MB',
        'max_dims' => 'Resolusi gambar maksimal 2700x4880 pixel',
        'uploaded' => 'Harap pilih foto sampul'
      ]
    ],
  ];

  if ($adaFoto == true) {
    array_push($validationRule['buku_foto']['rules'], 'uploaded[buku_foto]');
  }

  return $validationRule;
}

function cekUploadSampul($foto)
{
  // Cek foto sampul

  // Mindahin foto
  $foto->move(ROOTPATH . 'public/images/buku/', $foto->getRandomName());
  if ($foto->hasMoved()) {
    // Berhasil mindahin foto, ambil namanya buat isi database
    $fotoNama = $foto->getName();
    return $fotoNama;
  } else {
    // Gagal
    return redirect()->route('adminBukuUbahForm')->with('error', 'Gagal upload foto sampul')->withInput();
  }
}