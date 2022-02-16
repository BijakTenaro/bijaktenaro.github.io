<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">JelajahSite</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                    <!-- <a class="nav-link" href="/pages/trending">Trending</a> -->
                    <a class="nav-link" href="/pages/about">About</a>
                    <?php if (in_groups('admin')) : ?>
                        <a class="nav-link" href="/berita">Edit</a>
                    <?php endif; ?>
                    <?php if (in_groups('user')) : ?>
                        <a class="nav-link" href="/user">Berita</a>
                    <?php endif; ?>
                </div>
                <?php if (logged_in()) : ?>
                    <a class="nav-link" href="/logout">Logout</a>
                <?php else :  ?>
                    <a class="nav-link" href="/login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>