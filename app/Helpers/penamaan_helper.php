<?php

// Kayaknya semua pake formatJudul() aja. Nama orang juga ada yang pake Al-

function formatNama($nama)
{
  // Semua input jadiin huruf kecil, takutnya ada 1 huruf kapital yang nyempil di tengah kata
  $hasil = ucwords(strtolower($nama));

  return $hasil;
}

function formatJudul($judul)
{
  $tetep_kecil = array("dari", "dan", "di", "ke", "dengan", "bin", "binti");

  // Semua input jadiin huruf kecil, takutnya ada 1 huruf kapital yang nyempil di tengah kata
  $kecil = strtolower($judul);
  $pisahKata = explode(" ", $kecil);
  $satuinKata = array();

  // Ngeformat setiap kata yang udh dipisah
  foreach ($pisahKata as $kata) {
    if (in_array($kata, $tetep_kecil)) {
      // yg ada di list, tetep kecil
      $kata = strtolower($kata);
    }
    else if (str_contains($kata, "Al-") or str_contains($kata, "al-") or str_contains($kata, "AL-")) {
      // Sedikit pengecualian, kayak Al-Qur'an, nama tokoh Islam atau nama tempat.
      // Kalo pake in_array kayak yg di atas, itu harus full serupa katanya, ga bisa "like"
      $pisahGaris = explode("-", $kata);
      $pertama = ucfirst($pisahGaris[0]);
      $kedua = ucfirst($pisahGaris[1]);
      $array = array($pertama, $kedua);

      $kata = join("-", $array);
    }
    else {
      // sisanya huruf kapital pertama
      $kata = ucfirst($kata);
    }

    // setiap perulangan, kata yg udh diformat dikumpulin
    $satuinKata[] = $kata;
  }

  // pastiin kata pertama tetep kapital walau ada di list $tetep_kecil.
  $hasil = ucfirst(join(" ", $satuinKata));
  return $hasil;
}

function tigaHurufPenulis($penulis)
{
  // Ngambil 3 huruf pertama dari nama penulis

  $penulisBuku = str_replace(' ', '', $penulis);
  $resultPenulis = strtoupper(substr($penulisBuku, 0, 3));

  return $resultPenulis;
}

function inisialJudul($judul)
{
  // Ngambil inisial judul buku
  
  $expr = '/(?<=\s|^)\w/iu';
  preg_match_all($expr, $judul, $matches);
  $resultJudul = strtolower(implode('', $matches[0]));

  return $resultJudul;
}