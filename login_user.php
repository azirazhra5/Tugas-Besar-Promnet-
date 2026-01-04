<?php
require 'function.php';

if (isset($_SESSION['user'])) {
    header("Location: beranda.php");
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");

    // USER BELUM TERDAFTAR
    if (mysqli_num_rows($result) === 0) {
        header("Location: register.php?pesan=belum_daftar");
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        $_SESSION['user'] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email']
        ];
        header("Location: beranda.php");
        exit;
    } else {
        $error = "Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#f5f0e6; }
.card{ background:#fff3e0; }
.btn-login{ background:#8b5e3c; color:white; }
</style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
<div class="card p-4 shadow" style="width:350px">
<h4 class="text-center">Login User</h4>

<?php if(isset($_GET['pesan'])): ?>
<p class="text-warning text-center">
Akun belum terdaftar, silakan registrasi
</p>
<?php endif; ?>

<?php if($error): ?>
<p class="text-danger text-center"><?= $error; ?></p>
<?php endif; ?>

<form method="post">
<input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
<button name="login" class="btn btn-login w-100">Login</button>
</form>

<p class="text-center mt-2">
Belum punya akun? <a href="register.php">Daftar</a>
</p>
</div>
</body>
</html>
