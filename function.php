<?php
session_start();

/* ================================
   KONEKSI DATABASE
================================ */
$conn = mysqli_connect("localhost", "root", "", "cookieraa");
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

/* ================================
   QUERY HELPER
================================ */
function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);

    if (!$result) return [];

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

/* ================================
   LOGIN ADMIN
================================ */
function loginAdmin($username, $password){
    global $conn;

    $username = mysqli_real_escape_string($conn, $username);
    $result = mysqli_query($conn, "
        SELECT * FROM admin 
        WHERE username='$username' 
        LIMIT 1
    ");

    if (mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = [
                'id'       => $admin['id'],
                'username' => $admin['username'],
                'email'    => $admin['email']
            ];
            return true;
        }
    }
    return false;
}

/* ================================
   UPLOAD GAMBAR PRODUK
================================ */
function uploadGambar(){
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] === 4) {
        return false;
    }

    $namaFile   = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpName    = $_FILES['gambar']['tmp_name'];

    $extValid = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($ext, $extValid)) return false;
    if ($ukuranFile > 2000000) return false;

    $namaBaru = uniqid('produk_', true) . '.' . $ext;
    $path = __DIR__ . "/dist/assets/img/" . $namaBaru;

    move_uploaded_file($tmpName, $path);
    return $namaBaru;
}

/* ================================
   TAMBAH PRODUK
================================ */
function tambahProduk($data){
    global $conn;

    $nama  = htmlspecialchars($data['nama_produk']);
    $harga = (int)$data['harga'];
    $stok  = (int)$data['stok'];
    $desk  = htmlspecialchars($data['deskripsi']);

    $gambar = uploadGambar();
    if (!$gambar) return false;

    mysqli_query($conn, "
        INSERT INTO produk
        (nama_produk, harga, stok, gambar, deskripsi)
        VALUES
        ('$nama', $harga, $stok, '$gambar', '$desk')
    ");

    return mysqli_affected_rows($conn);
}

/* ================================
   EDIT PRODUK
================================ */
function editProduk($data){
    global $conn;

    $id    = (int)$data['id_produk'];
    $nama  = htmlspecialchars($data['nama_produk']);
    $harga = (int)$data['harga'];
    $stok  = (int)$data['stok'];
    $desk  = htmlspecialchars($data['deskripsi']);
    $lama  = $data['gambar_lama'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $lama;
    } else {
        $gambar = uploadGambar();
        if ($gambar && file_exists(__DIR__."/dist/assets/img/".$lama)) {
            unlink(__DIR__."/dist/assets/img/".$lama);
        }
    }

    mysqli_query($conn, "
        UPDATE produk SET
            nama_produk='$nama',
            harga=$harga,
            stok=$stok,
            gambar='$gambar',
            deskripsi='$desk'
        WHERE id_produk=$id
    ");

    return mysqli_affected_rows($conn);
}

/* ================================
   HAPUS PRODUK
================================ */
function hapusProduk($id){
    global $conn;

    $id = (int)$id;
    $data = query("SELECT gambar FROM produk WHERE id_produk=$id");

    if ($data) {
        $file = __DIR__."/dist/assets/img/".$data[0]['gambar'];
        if (file_exists($file)) unlink($file);
    }

    mysqli_query($conn, "DELETE FROM produk WHERE id_produk=$id");
    return mysqli_affected_rows($conn);
}

/* ================================
   DETAIL PESANAN
================================ */
function getPesananDetail($id_pesanan){
    global $conn;
    $id_pesanan = (int)$id_pesanan;

    $q = mysqli_query($conn, "
        SELECT *
        FROM pesanan_detail
        WHERE id_pesanan=$id_pesanan
    ");

    $data = [];
    while ($row = mysqli_fetch_assoc($q)) {
        $data[] = $row;
    }
    return $data;
}
