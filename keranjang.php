<?php
require 'function.php';

if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $produk = query("SELECT * FROM produk WHERE id_produk=$id")[0];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $_SESSION['cart'][$id] = [
            'id_produk' => $produk['id_produk'],
            'nama'      => $produk['nama_produk'],
            'harga'     => $produk['harga'],
            'gambar'    => $produk['gambar'],
            'qty'       => 1
        ];
    }

    header("Location: keranjang.php");
    exit;
}


if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $qty = (int)$qty;

        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
    }

    header("Location: keranjang.php");
    exit;
}

if (isset($_GET['hapus'])) {
    unset($_SESSION['cart'][$_GET['hapus']]);
    header("Location: keranjang.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Keranjang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  background:#f3e5d8;
}

h3{
  color:#6d4c41;
}

.table{
  border-radius:14px;
  overflow:hidden;
}

.table-light{
  background:#efdfcf;
}

input[type=number]{
  width:70px;
  margin:auto;
}

.btn-coklat{
  background:#9f7d3f;
  border:#9f7d3f;
  color:white;
}

.btn-coklat:hover{
  background:#8a6a32;
  border:#8a6a32;
  color:white;
}

.btn-hapus{
  background:#b05a4a;
  border:#b05a4a;
  color:white;
}

.btn-hapus:hover{
  background:#94483b;
  border:#94483b;
}
</style>
</head>

<body>
<div class="container py-5">
<h3 class="mb-4 text-center">🛒 Keranjang Belanja</h3>

<?php if (empty($_SESSION['cart'])): ?>
  <div class="alert alert-warning text-center">Keranjang kosong</div>
<?php else: ?>

<form method="post">
<table class="table align-middle bg-white shadow-sm">
<thead class="table-light">
<tr>
  <th>Produk</th>
  <th>Harga</th>
  <th class="text-center">Qty</th>
  <th>Subtotal</th>
  <th></th>
</tr>
</thead>
<tbody>

<?php $total = 0; ?>
<?php foreach ($_SESSION['cart'] as $c): ?>
<?php
$subtotal = $c['harga'] * $c['qty'];
$total += $subtotal;
?>

<tr>
<td>
  <img src="dist/assets/img/<?= $c['gambar'] ?>" width="60" class="rounded me-2">
  <?= $c['nama'] ?>
</td>

<td>Rp <?= number_format($c['harga']) ?></td>

<td class="text-center">
  <input type="number"
         name="qty[<?= $c['id_produk'] ?>]"
         value="<?= $c['qty'] ?>"
         min="1"
         class="form-control text-center">
</td>

<td>Rp <?= number_format($subtotal) ?></td>

<td>
  <a href="?hapus=<?= $c['id_produk'] ?>"
     class="btn btn-sm btn-hapus"
     onclick="return confirm('Hapus produk ini?')">
     ✖
  </a>
</td>
</tr>

<?php endforeach; ?>
</tbody>
</table>

<div class="d-flex justify-content-between align-items-center">
  <h5>Total: <strong>Rp <?= number_format($total) ?></strong></h5>

  <div>
    <button type="submit" name="update" class="btn btn-coklat me-2">
      Update Keranjang
    </button>

    <a href="checkout.php" class="btn btn-coklat btn-lg">
      Checkout
    </a>
  </div>
</div>
</form>

<?php endif; ?>
</div>
</body>
</html>
