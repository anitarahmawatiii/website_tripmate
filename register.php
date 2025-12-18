<?php 
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query = mysqli_query($koneksi, 
            "INSERT INTO users (username, email, password, role) 
             VALUES ('$nama', '$email', '$hash', 'user')"
        );

        if ($query) {
            $success = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error = "Terjadi kesalahan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php require('components/head.php'); ?>
<title>Daftar Akun - TripMate</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}

:root{
    --primary:#006D77;
    --primary-dark:#005a63;
    --accent:#83C5BE;
    --white:#ffffff;
    --border:#cfd8dc;
}

body{
    background:#e4f5f6;
}

/* NAVBAR */
.navbar{
    position:fixed;
    top:0;left:0;
    width:100%;
    padding:16px 32px;
    background:var(--primary);
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    z-index:1000;
}
.navbar span{
    font-size:24px;
    font-weight:700;
}
.navbar a{
    margin-left:25px;
    color:white;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{
    text-decoration:underline;
}
.dark-toggle{
    background:none;
    border:none;
    color:white;
    font-size:18px;
    cursor:pointer;
    margin-left:20px;
}

/* CARD */
.login-box{
    width:360px;
    margin:60px auto 100px auto;
    background:white;
    padding:35px 30px;
    border-radius:16px;
    text-align:center;
    border:1px solid var(--border);
    box-shadow:0 8px 24px rgba(0,0,0,.1);
}
.login-box h2{
    color:var(--primary);
    margin-bottom:20px;
}

/* INPUT */
.login-box input{
    width:95%;
    padding:11px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid var(--border);
}

.login-box button{
    width:95%;
    padding:11px;
    margin-top:10px;
    background:var(--primary);
    color:white;
    font-weight:700;
    border:none;
    border-radius:10px;
    cursor:pointer;

    -webkit-tap-highlight-color: transparent;
}

.login-box button:hover,
.login-box button:active,
.login-box button:focus{
    background:var(--primary) !important;
    color:white !important;
    outline:none;
    box-shadow:none;
}

/* MESSAGE */
.error{color:#b00000;margin-bottom:10px;}
.success{color:#207a3a;margin-bottom:10px;}

.link-login{
    margin-top:12px;
    display:block;
    font-weight:600;
    color:var(--primary);
    text-decoration:none;
}
.link-login:hover,
.link-login:active,
.link-login:visited{
    color:var(--primary);
}

/* FOOTER */
footer{
    width:100%;
    padding:14px;
    text-align:center;
    position:fixed;
    bottom:0;
    background:var(--primary);
    color:white;
}

/* ======================
   DARK MODE
====================== */
body.dark-mode{
    background:#020617;
    color:#e5e7eb;
}
body.dark-mode .navbar,
body.dark-mode footer{
    background:#020617;
}
body.dark-mode .login-box{
    background:#0f172a;
    color:#e5e7eb;
    border:1px solid #334155;
}
body.dark-mode input{
    background:#020617;
    color:#e5e7eb;
    border:1px solid #334155;
}
</style>
</head>

<body>

<?php require('components/header.php'); ?>

<div class="login-box">
<h2>Daftar Akun</h2>

<?php if (!empty($error)): ?>
<p class="error"><?= $error ?></p>
<?php endif; ?>

<?php if (!empty($success)): ?>
<p class="success"><?= $success ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="nama" placeholder="Nama Lengkap" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Daftar</button>
</form>

<a class="link-login" href="login.php">Sudah punya akun? Login</a>
</div>

<?php require('components/footer.php'); ?>

<script src="script.js"></script>

</body>
</html>
