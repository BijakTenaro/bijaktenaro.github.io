<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'sampul', 'detail', 'slug'];

    public function getBerita($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }

    public function search($keyword)
    {
        return $this->table('berita')->like('judul', $keyword);
    }
}
