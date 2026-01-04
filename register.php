<?php
require 'function.php';

$error = '';

if (isset($_POST["register"])) {
    $username = strtolower(mysqli_real_escape_string($conn, $_POST["username"]));
    $email    = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $password2= $_POST["password2"];

    // CEK USERNAME
    $cek = mysqli_query($conn, "SELECT username FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah terdaftar!";
    } elseif ($password !== $password2) {
        $error = "Konfirmasi password tidak sesuai!";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn, "
            INSERT INTO user (username, email, password)
            VALUES ('$username', '$email', '$passwordHash')
        ");

        header("Location: login_user.php?pesan=register_berhasil");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#f5f0e6; }
.card{ background:#fff3e0; }
.btn-brown{ background:#8b5e3c; color:white; }
</style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
<div class="card p-4 shadow" style="width:380px">
<h4 class="text-center">Register User</h4>

<?php if(isset($_GET['pesan'])): ?>
<p class="text-warning text-center">
Akun belum terdaftar, silakan register
</p>
<?php endif; ?>

<?php if($error): ?>
<p class="text-danger text-center"><?= $error; ?></p>
<?php endif; ?>

<form method="post">
<input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
<input type="password" name="password2" class="form-control mb-2" placeholder="Ulangi Password" required>
<button name="register" class="btn btn-brown w-100">Register</button>
</form>

<p class="text-center mt-2">
Sudah punya akun? <a href="login_user.php">Login</a>
</p>
</div>
</body>
</html>
