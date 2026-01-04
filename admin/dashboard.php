<?php
require '../function.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$totalProduk   = query("SELECT COUNT(*) total FROM produk")[0]['total'];
$totalPesanan  = query("SELECT COUNT(*) total FROM pesanan")[0]['total'];
$produkTerbaru = query("SELECT * FROM produk ORDER BY id_produk DESC LIMIT 5");

$adminName = $_SESSION['admin_username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{background:#f5e6d3;font-family:Arial}
.sidebar{width:260px;height:100vh;background:linear-gradient(180deg,#6d4c41,#8d6e63);position:fixed;color:white;padding:20px}
.sidebar a{color:white;text-decoration:none;display:block;padding:10px;border-radius:8px;margin-bottom:5px}
.sidebar a:hover{background:rgba(255,255,255,.2)}
.content{margin-left:280px;padding:25px}
.card-custom{background:#fff3e0;border:none;border-radius:15px;box-shadow:0 4px 8px rgba(0,0,0,.1)}
.stat-card{background:#fff;border-radius:15px;padding:20px;text-align:center}
</style>
</head>

<body>

<div class="sidebar">
    <h4 class="mb-4">🍪 Cookieraa</h4>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="produk.php"><i class="bi bi-box-seam"></i> Produk</a>
    <a href="pesanan.php"><i class="bi bi-cart-check"></i> Pesanan</a>
    <a href="logout_admin.php" class="text-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

<div class="content">

<div class="card card-custom p-4 mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h5>Selamat Datang 👋</h5>
        <strong><?= $adminName ?></strong>
        <p class="text-muted mb-0">Administrator Cookieraa</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="stat-card">
            <i class="bi bi-box-seam fs-1"></i>
            <h3><?= $totalProduk ?></h3>
            <p>Total Produk</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card">
            <i class="bi bi-cart-check fs-1"></i>
            <h3><?= $totalPesanan ?></h3>
            <p>Total Pesanan</p>
        </div>
    </div>
</div>

<div class="card card-custom p-4">
<h5 class="mb-3">Produk Terbaru</h5>
<table class="table align-middle">
<thead>
<tr>
    <th>Gambar</th>
    <th>Nama</th>
    <th>Harga</th>
    <th>Stok</th>
</tr>
</thead>
<tbody>
<?php foreach($produkTerbaru as $p): ?>
<tr>
    <td>
        <img src="../dist/assets/img/<?= htmlspecialchars($p['gambar']) ?>"
             width="60" height="60"
             class="rounded border"
             style="object-fit:cover"
             onerror="this.src='../dist/assets/img/default.png'">
    </td>
    <td><?= htmlspecialchars($p['nama_produk']) ?></td>
    <td>Rp <?= number_format($p['harga']) ?></td>
    <td><?= $p['stok'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

</div>
</body>
</html>
