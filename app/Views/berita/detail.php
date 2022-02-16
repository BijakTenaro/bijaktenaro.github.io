<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Berita</h2>
            <div class="card mb-3">
                <img src="/img/<?= $berita['sampul']; ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $berita['judul']; ?></h5>
                    <p class="card-text"><?= $berita['detail']; ?></p>
                    <?php if (in_groups('admin')) : ?>
                        <a href="/berita/edit/<?= $berita['slug']; ?>" class="btn btn-warning">Edit</a>

                        <form action="/berita/<?= $berita['id']; ?>" method="post" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Delete</button>
                        </form>
                    <?php endif; ?>
                    <p class="card-text"><small class="text-muted"><a href="/berita">kembali ke daftar berita</a></small></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>