<?php
require '../function.php';
if (!isset($_SESSION['admin'])) { header("Location: login_admin.php"); exit; }
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: pesanan.php"); exit; }

$id = (int)$_GET['id'];

$pesanan = mysqli_query($conn, "
SELECT 
pesanan.id_pesanan,
pesanan.tanggal,
pesanan.no_hp,
pesanan.alamat,
pesanan.pembayaran,
pesanan.total,
pesanan.status,
user.username
FROM pesanan
JOIN user ON pesanan.id_user = user.id
WHERE pesanan.id_pesanan = $id
LIMIT 1
");
$dataPesanan = mysqli_fetch_assoc($pesanan);
$detail = getPesananDetail($id);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#fff3e0; }
.content{ padding:40px; }
.card{ background:#fff3e0; border-radius:15px; }
</style>
</head>
<body>

<div class="content">
<div class="card p-4">
<h5 class="mb-3">Detail Pesanan #<?= $dataPesanan['id_pesanan']; ?></h5>

<table class="table table-bordered mb-4">
<tr><th>Nama</th><td><?= htmlspecialchars($dataPesanan['username']); ?></td></tr>
<tr><th>Tanggal</th><td><?= $dataPesanan['tanggal']; ?></td></tr>
<tr><th>No HP</th><td><?= $dataPesanan['no_hp']; ?></td></tr>
<tr><th>Alamat</th><td><?= htmlspecialchars($dataPesanan['alamat']); ?></td></tr>
<tr><th>Pembayaran</th><td><?= $dataPesanan['pembayaran']; ?></td></tr>
<tr><th>Status</th><td><?= ucfirst($dataPesanan['status']); ?></td></tr>
<tr><th>Total</th><td>Rp <?= number_format($dataPesanan['total']); ?></td></tr>
</table>

<table class="table table-bordered align-middle">
<thead class="table-dark">
<tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
</thead>
<tbody>
<?php if(!empty($detail)): ?>
<?php foreach($detail as $d): ?>
<tr>
<td><?= htmlspecialchars($d['nama_produk']); ?></td>
<td>Rp <?= number_format($d['harga']); ?></td>
<td><?= $d['qty']; ?></td>
<td>Rp <?= number_format($d['subtotal']); ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="4" class="text-center">Detail pesanan tidak ditemukan</td></tr>
<?php endif; ?>
</tbody>
</table>

<a href="pesanan.php" class="btn btn-secondary btn-sm">Kembali</a>
</div>
</div>
</body>
</html>
