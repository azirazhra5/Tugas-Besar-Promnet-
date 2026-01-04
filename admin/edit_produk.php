<?php
require '../function.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$id = $_GET['id'];
$produk = query("SELECT * FROM produk WHERE id_produk=$id")[0];

if (isset($_POST['submit'])) {
    if (editProduk($_POST) > 0) {
        echo "<script>
                alert('Produk berhasil diubah');
                document.location.href = 'produk.php';
              </script>";
    } else {
        echo "<script>alert('Produk gagal diubah');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f5e6d3}
.card{background:#fff3e0;border-radius:15px}
</style>
</head>

<body class="p-5">

<div class="container">
<div class="card p-4 col-md-6 mx-auto">
<h4>Edit Produk</h4>

<form method="post" enctype="multipart/form-data">

<input type="hidden" name="id_produk" value="<?= $produk['id_produk']; ?>">
<input type="hidden" name="gambar_lama" value="<?= $produk['gambar']; ?>">

<div class="mb-3">
<label>Nama Produk</label>
<input type="text" name="nama_produk" class="form-control"
value="<?= $produk['nama_produk']; ?>" required>
</div>

<div class="mb-3">
<label>Harga</label>
<input type="number" name="harga" class="form-control"
value="<?= $produk['harga']; ?>" required>
</div>

<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok" class="form-control"
value="<?= $produk['stok']; ?>" required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="deskripsi" class="form-control" required><?= $produk['deskripsi']; ?></textarea>
</div>

<div class="mb-3">
<label>Gambar Saat Ini</label><br>
<img src="/cookieraa/dist/assets/img/<?= $p['gambar']; ?>" width="60">
</div>

<div class="mb-3">
<label>Ganti Gambar (opsional)</label>
<input type="file" name="gambar" class="form-control">
</div>

<button type="submit" name="submit" class="btn btn-warning">Update</button>
<a href="produk.php" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>

</body>
</html>
