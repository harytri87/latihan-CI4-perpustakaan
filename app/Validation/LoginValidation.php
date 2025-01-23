<?php

namespace App\Validation;

use App\Models\PenggunaModel;

class LoginValidation
{
    public function validateUser(string $str, string $fields, array $data)
    {
        // Cek buat login
        
        $model = new PenggunaModel();
        $user = $model->getPengguna($data['pengguna_email']);

        if (!$user) {
            // Email ga ada yg cocok
            return false;
        }

        // cek password: true / false
        return password_verify($data['pengguna_password'], $user['pengguna_password']);
    }
}
