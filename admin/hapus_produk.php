<?php
require '../function.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$id = $_GET['id'];

if (hapusProduk($id) > 0) {
    echo "<script>
            alert('Produk berhasil dihapus');
            document.location.href = 'produk.php';
          </script>";
} else {
    echo "<script>alert('Produk gagal dihapus');</script>";
}
