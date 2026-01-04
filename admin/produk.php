<?php
require '../function.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$produk = query("SELECT * FROM produk ORDER BY id_produk DESC");
$adminName = $_SESSION['admin_username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{background:#f5e6d3;font-family:Arial}
.sidebar{width:260px;height:100vh;background:linear-gradient(180deg,#6d4c41,#8d6e63);position:fixed;color:white;padding:20px}
.sidebar a{color:white;text-decoration:none;display:block;padding:10px;border-radius:8px;margin-bottom:5px}
.sidebar a:hover{background:rgba(255,255,255,.2)}
.content{margin-left:280px;padding:25px}
.card-custom{background:#fff3e0;border:none;border-radius:15px;box-shadow:0 4px 8px rgba(0,0,0,.1)}
.btn-brown{background:#6d4c41;color:white}
.btn-brown:hover{background:#5d4037}
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

<div class="card card-custom p-4 mb-4 d-flex justify-content-between align-items-center flex-row">
    <div>
        <h5 class="mb-1">Manajemen Produk</h5>
        <strong><?= $adminName ?></strong>
        <p class="mb-0 text-muted">Administrator Cookieraa</p>
    </div>
    <a href="tambah_produk.php" class="btn btn-brown btn-sm">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </a>
</div>

<div class="card card-custom p-4">
<table class="table align-middle">
<thead>
<tr>
    <th>Gambar</th>
    <th>Nama</th>
    <th>Deskripsi</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>
<?php foreach($produk as $p): ?>
<tr>
    <td>
        <img src="../dist/assets/img/<?= htmlspecialchars($p['gambar']) ?>"
             width="60" height="60"
             class="rounded border"
             style="object-fit:cover"
             onerror="this.src='../dist/assets/img/default.png'">
    </td>
    <td><?= htmlspecialchars($p['nama_produk']) ?></td>
    <td><small><?= strlen($p['deskripsi']) > 80 ? substr($p['deskripsi'],0,80).'...' : $p['deskripsi'] ?></small></td>
    <td>Rp <?= number_format($p['harga']) ?></td>
    <td><?= $p['stok'] ?></td>
    <td>
        <a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i>
        </a>
        <a href="hapus_produk.php?id=<?= $p['id_produk'] ?>"
           onclick="return confirm('Yakin hapus produk?')"
           class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i>
        </a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

</div>
</body>
</html>
