<?php

namespace App\Controllers;

use App\Models\BeritaModel;

class Berita extends BaseController
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

    public function create()
    {
        // session();
        $data = [
            'title' => 'Tambah Berita Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('berita/create', $data);
    }

    public function save()
    {
        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[berita.judul]',
                'errors' => [
                    'required' => '{field} berita harus diisi,',
                    'is_unique' => '{field} berita sudah ada.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Bukan file gambar.',
                    'mime_in' => 'Bukan file gambar.'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('/berita/create')->withInput()->with('validation', $validation);
            return redirect()->to('/berita/create')->withInput();
        }

        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // jika tidak upload gambar
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();
            // pindah file ke folder img (public)
            $fileSampul->move('img', $namaSampul);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->beritaModel->save([
            'judul' => $this->request->getVar('judul'),
            'sampul' => $namaSampul,
            'detail' => $this->request->getVar('detail'),
            'slug' => $slug
        ]);

        session()->setFlashdata('pesan', 'Berita berhasil ditambah!');

        return redirect()->to('/berita');
    }

    public function delete($id)
    {
        // cari gambar berdasar id
        $berita = $this->beritaModel->find($id);

        // cek jika gambar default.jpg
        if ($berita['sampul'] != 'default.jpg') {
            // hapus gambar
            unlink('img/' . $berita['sampul']);
        }

        $this->beritaModel->delete($id);
        session()->setFlashdata('pesan', 'Berita berhasil dihapus!');
        return redirect()->to('/berita');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Edit Berita',
            'validation' => \Config\Services::validation(),
            'berita' => $this->beritaModel->getBerita($slug)
        ];

        return view('berita/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $beritaLama = $this->beritaModel->getBerita($this->request->getVar('slug'));
        if ($beritaLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[berita.judul]';
        }

        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} berita harus diisi,',
                    'is_unique' => '{field} berita sudah ada.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar.',
                    'is_image' => 'Bukan file gambar.',
                    'mime_in' => 'Bukan file gambar.'
                ]
            ]
        ])) {
            return redirect()->to('/berita/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random 
            $namaSampul = $fileSampul->getRandomName();
            // pindah gambar
            $fileSampul->move('img', $namaSampul);
            // hapus file lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->beritaModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'sampul' => $namaSampul,
            'detail' => $this->request->getVar('detail'),
            'slug' => $slug
        ]);

        session()->setFlashdata('pesan', 'Berita berhasil diupdate!');

        return redirect()->to('/berita');
    }
}
