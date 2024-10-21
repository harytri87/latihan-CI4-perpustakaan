<?php

namespace App\Libraries;

// Ini dibikin dulu aja buat contoh. Gatau nanti dipake atau ga
class CIAuth
{
  // Set session
  public static function setCIAuth($result)
  {
    $session = session();
    $array = ['logged_in' => true];
    $userData = $result;
    $session->set('userdata', $userData);
    $session->set($array);
  }

  // manggil id user yg login
  public static function id()
  {
    $session = session();
    if ($session->has('logged_in')) {
      if ($session->has('userdata')) {
        return $session->get('userdata')['id'];
      } else {
        return null;
      }
    } else {
      return null;
    }
  }

  // Cek udh login belum
  public static function check()
  {
    $session = session();
    return $session->has('logged_in');
  }

  // Ngehapus session login & data user
  public static function forget()
  {
    $session = session();
    $session->remove('logged_in');
    $session->remove('userdata');
  }

  // Manggil data user yg login
  public static function user()
  {
    $session = session();
    if ($session->has('logged_in')) {
      if ($session->has('userdata')) {
        return $session->get('userdata');
      } else {
        return null;
      }
    } else {
      return null;
    }
  }
}