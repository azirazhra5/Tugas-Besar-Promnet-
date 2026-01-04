<?php
require 'function.php';

if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit;
}

$user = $_SESSION['user'];

// ambil produk dari database
$produk = query("SELECT * FROM produk ORDER BY id_produk DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Beranda</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
body { padding-top: 80px; }

.hero {
  position: relative;
  color: white;
  background:
    linear-gradient(rgba(159,125,63,0.75), rgba(159,125,63,0.75))
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white fixed-top border-bottom">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="dist/assets/img/logo.png" height="80">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="#product">Product</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>

        <!-- DROPDOWN USER -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center"
             href="#"
             data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i>
            <?= htmlspecialchars($user['username']); ?>
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow">
            <!-- INFO USER -->
            <li class="px-3 py-2">
              <div class="fw-bold">
                <?= htmlspecialchars($user['username']); ?>
              </div>
              <div class="text-muted small">
                <?= htmlspecialchars($user['email']); ?>
              </div>
            </li>

            <li><hr class="dropdown-divider"></li>

            <!-- LOGOUT -->
            <li>
              <a class="dropdown-item text-danger" href="logout_user.php">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
              </a>
            </li>
          </ul>
        </li>
        <!-- END DROPDOWN -->

      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="fw-bold">Baked with Love, Shared and Joy!</h1>
        <h5>Welcome, <?= htmlspecialchars($user['username']); ?> 👋</h5>
        <a href="#product" class="btn btn-warning mt-3">Buy Now</a>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCT -->
<section id="product" class="py-5" style="background:#f3e5d8;">
  <div class="container">
    <h2 class="fw-bold text-center mb-4">Product</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($produk as $p): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img
            src="dist/assets/img/<?= htmlspecialchars($p['gambar']); ?>"
            class="card-img-top"
            style="height:220px;object-fit:cover"
            onerror="this.src='dist/assets/img/default.png'">

          <div class="card-body text-center">
  <h5 class="card-title"><?= htmlspecialchars($p['nama_produk']); ?></h5>

  <p class="small text-muted mb-2">
    <?= htmlspecialchars($p['deskripsi']); ?>
  </p>

  <p class="fw-semibold">
    Rp <?= number_format($p['harga']); ?>
  </p>
</div>


          <div class="card-footer bg-white border-0 text-center">
            <a href="keranjang.php?id=<?= $p['id_produk']; ?>"
               class="btn btn-warning w-100">
              <i class="bi bi-cart-plus"></i> Tambah Keranjang
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-5">
  <div class="container">
    <h2 class="fw-bold text-center mb-4">Contact Us</h2>
    <div class="row">
      <div class="col-md-6">
        <input class="form-control mb-2" placeholder="Email">
        <textarea class="form-control mb-2" rows="3" placeholder="Pesan"></textarea>
        <button class="btn btn-warning">Submit</button>
      </div>
      <div class="col-md-6">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2030.3734010371063!2d107.45647258413267!3d-6.49593946818396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690d0078203ac1%3A0x6a290b56eb65aa58!2sEat%20me%20snack!5e0!3m2!1sid!2sid!4v1767404364334!5m2!1sid!2sid"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center p-3">
  © <?= date('Y'); ?> Cookieraa
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
