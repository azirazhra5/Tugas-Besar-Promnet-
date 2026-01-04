<?php
require '../function.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn, "
        INSERT INTO admin (username, email, password)
        VALUES ('$username', '$email', '$password')
    ");

    header("Location: login_admin.php?pesan=register_berhasil");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{ background:#f5e6d3; height:100vh; display:flex; align-items:center; }
.card{ background:#fff3e0; }
.btn-register{ background:#6d4c41; color:white; }
</style>
</head>

<body>
<div class="container">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card p-4 shadow">
<h4 class="text-center">Register Admin</h4>

<?php if(isset($_GET['pesan'])): ?>
<p class="text-warning text-center">Akun belum terdaftar</p>
<?php endif; ?>

<form method="post">
<input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button name="register" class="btn btn-register w-100">Register</button>
</form>

<p class="text-center mt-2">
Sudah punya akun? <a href="login_admin.php">Login</a>
</p>
</div>

</div>
</div>
</div>
</body>
</html>
