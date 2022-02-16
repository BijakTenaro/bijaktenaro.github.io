<?php

namespace App\Controllers;

use App\Models\BeritaModel;

class User extends BaseController
{
    protected $beritaModel;
    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }
    public function index()
    {
        // $berita = $this->beritaModel->findAll();

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $berita = $this->beritaModel->search($keyword);
        } else {
            $berita = $this->beritaModel;
        }

        $data = [
            'title' => 'Daftar Berita',
            // 'berita' => $this->beritaModel->getBerita()
            'berita' => $berita->paginate(10, 'berita'),
            'pager' => $this->beritaModel->pager
        ];


        return view('berita/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Berita',
            'berita' => $this->beritaModel->getBerita($slug)
        ];

        // jika berita tidak ada di tabel
        if (empty($data['berita'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita ' . $slug . ' tidak ditemukan.');
        }

        return view('berita/detail', $data);
    }
}
