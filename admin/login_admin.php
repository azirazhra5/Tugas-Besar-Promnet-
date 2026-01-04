<?php
require '../function.php';

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if (mysqli_num_rows($result) === 0) {
        header("Location: register_admin.php?pesan=belum_daftar");
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        $_SESSION['admin'] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email']
        ];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = 'Password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background:#f5e6d3;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.card{
    width:380px;
    border-radius:15px;
    background:#fff3e0;
}
.btn-login{
    background:#6d4c41;
    color:white;
    width:100%;
}
</style>
</head>

<body>
<div class="card p-4 shadow">
<h4 class="text-center mb-3">Login Admin</h4>

<?php if(isset($_GET['pesan'])): ?>
<div class="alert alert-warning text-center">
Akun admin belum terdaftar, silakan register
</div>
<?php endif; ?>

<?php if($error): ?>
<div class="alert alert-danger text-center"><?= $error ?></div>
<?php endif; ?>

<form method="post">
<input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button name="login" class="btn btn-login">Login</button>
</form>

<p class="text-center mt-2">
Belum punya akun? <a href="register_admin.php">Register</a>
</p>
</div>
</body>
</html>
