<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Daftar Berita</h1>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Berita" name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php if (in_groups('admin')) : ?>
                <a href="/berita/create" class="btn btn-primary mb-3">Tambah Berita Baru</a>
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan'); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <table class="table">
                    <thead>
                        <!-- <tr>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr> -->
                    </thead>
                    <tbody>
                        <?php foreach ($berita as $b) : ?>
                            <tr>
                                <td><img src="/img/<?= $b['sampul']; ?>" alt="" class="sampul"></td>
                                <td><?= $b['judul']; ?></td>
                                <td><a href="/berita/<?= $b['slug']; ?>" class="btn btn-success">Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $pager->links('berita', 'berita_pagination'); ?>
                    </div>
        </div>
    </div>
    <?= $this->endSection(); ?>