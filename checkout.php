<?php
require 'function.php';

if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
    header("Location: beranda.php");
    exit;
}

$id_user = $_SESSION['user']['id'];
$cart    = $_SESSION['cart'];
$total   = 0;

foreach ($cart as $item) {
    $total += $item['harga'] * $item['qty'];
}

$errors = [];
$success = false;

if (isset($_POST['checkout'])) {
    $alamat = trim($_POST['alamat']);
    $no_hp  = trim($_POST['no_hp']);
    $pembayaran = $_POST['pembayaran'] ?? '';

    if (!$alamat) $errors[] = "Alamat wajib diisi.";
    if (!$no_hp) $errors[] = "Nomor HP wajib diisi.";
    if (!$pembayaran) $errors[] = "Pilih metode pembayaran.";

    if (empty($errors)) {
        $alamat_db = mysqli_real_escape_string($conn, $alamat);
        $no_hp_db = mysqli_real_escape_string($conn, $no_hp);
        $pembayaran_db = mysqli_real_escape_string($conn, $pembayaran);

        mysqli_query($conn, "
            INSERT INTO pesanan (id_user, total, status, alamat, no_hp, pembayaran)
            VALUES ($id_user, $total, 'pending', '$alamat_db', '$no_hp_db', '$pembayaran_db')
        ");

        $id_pesanan = mysqli_insert_id($conn);

        foreach ($cart as $item) {
            $id_produk = (int)$item['id_produk'];
            $nama      = mysqli_real_escape_string($conn, $item['nama']);
            $harga     = (int)$item['harga'];
            $qty       = (int)$item['qty'];
            $subtotal  = $harga * $qty;

            mysqli_query($conn, "
                INSERT INTO pesanan_detail
                (id_pesanan, id_produk, nama_produk, harga, qty, subtotal)
                VALUES
                ($id_pesanan, $id_produk, '$nama', $harga, $qty, $subtotal)
            ");
        }

        unset($_SESSION['cart']);
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#f3e5d8; min-height:100vh; display:flex; align-items:center; justify-content:center; }
.checkout-card{ background:#fff3e0; border-radius:18px; padding:40px; width:100%; max-width:420px; text-align:center; box-shadow:0 8px 25px rgba(0,0,0,.12); }
.checkout-icon{ font-size:60px; color:#8b5e3c; }
.checkout-title{ color:#6d4c41; font-weight:bold; }
.total{ color:#8d6e63; font-size:22px; font-weight:bold; }
.btn-coklat{ background:#9f7d3f; border:none; color:white; border-radius:10px; padding:10px; }
.btn-coklat:hover{ background:#8a6a32; }
.form-control{ border-radius:10px; margin-bottom:15px; }
</style>
</head>
<body>

<div class="checkout-card">
<?php if($success): ?>
    <div class="checkout-icon mb-3">🍪</div>
    <h3 class="checkout-title mb-2">Checkout Berhasil</h3>
    <p class="mb-3">Pesanan kamu berhasil dibuat 🤎</p>
    <p class="mb-1">Total Pembayaran</p>
    <div class="total mb-4">Rp <?= number_format($total); ?></div>
    <a href="beranda.php" class="btn btn-coklat w-100">Kembali ke Beranda</a>
<?php else: ?>
    <h3 class="checkout-title mb-3">Lengkapi Data Checkout</h3>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger"><?= implode("<br>", $errors); ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="alamat" placeholder="Alamat lengkap" class="form-control" required>
        <input type="text" name="no_hp" placeholder="Nomor HP" class="form-control" required>
        <select name="pembayaran" class="form-control" required>
            <option value="">-- Pilih Metode Pembayaran --</option>
            <option value="cod">COD</option>
            <option value="transfer">Transfer Bank</option>
        </select>
        <div class="total mb-3">Total: Rp <?= number_format($total); ?></div>
        <button type="submit" name="checkout" class="btn btn-coklat w-100">Checkout</button>
    </form>
<?php endif; ?>
</div>

</body>
</html>
