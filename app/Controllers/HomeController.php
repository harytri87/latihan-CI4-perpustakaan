<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        // return view('welcome_message');
        return view('halaman/index');
    }
}
