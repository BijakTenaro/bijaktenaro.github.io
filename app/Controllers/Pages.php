<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Jelajah | Jelajahi Berita Terkini'
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About',
        ];
        return view('pages/about', $data);
    }
}
