<?php
require '../function.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

if (isset($_POST['submit'])) {
    if (tambahProduk($_POST) > 0) {
        echo "<script>
                alert('Produk berhasil ditambahkan');
                document.location.href = 'produk.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menambah produk');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f5e6d3}
.card{background:#fff3e0;border-radius:15px}
</style>
</head>

<body class="p-5">

<div class="container">
<div class="card p-4 col-md-6 mx-auto">
<h4>Tambah Produk</h4>

<form method="post" enctype="multipart/form-data">
<div class="mb-3">
<label>Nama Produk</label>
<input type="text" name="nama_produk" class="form-control" required>
</div>

<div class="mb-3">
<label>Harga</label>
<input type="number" name="harga" class="form-control" required>
</div>

<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok" class="form-control" required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="deskripsi" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Gambar Produk</label>
<input type="file" name="gambar" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-success">Simpan</button>
<a href="produk.php" class="btn btn-secondary">Kembali</a>
</form>

</div>
</div>

</body>
</html>
