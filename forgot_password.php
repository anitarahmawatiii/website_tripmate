<?php
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) === 1) {

        $token = bin2hex(random_bytes(16));
        mysqli_query($koneksi, "UPDATE users SET reset_token='$token' WHERE email='$email'");

        header("Location: forgot_password.php?sent=1&go=$token");
        exit();
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php require('components/head.php'); ?>
<title>Lupa Password - TripMate</title>

<style>
/* ===== RESET ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

/* ===== ROOT COLOR ===== */
:root{
    --primary:#006D77;
    --primary-dark:#005a62;
    --soft:#83c5be;

    /* DARK */
    --dark-bg:#020617;
    --dark-box:#020617;
    --dark-bar:#0b1226;
    --dark-border:#1e293b;
    --dark-text:#e5e7eb;
}

/* ===== BODY ===== */
body{
    background:#e5f5f4;
    padding-top:0px;
    padding-bottom:80px;
    transition:.3s;
}

/* ===== NAVBAR ===== */
.navbar{
    position:fixed;
    top:0;left:0;
    width:100%;
    height:70px;
    padding:0 32px;
    background:var(--primary);
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    z-index:999;
}
.logo{
    font-size:26px;
    font-weight:700;
}
.menu{
    display:flex;
    align-items:center;
    gap:22px;
}
.menu a{
    color:white;
    font-weight:600;
    text-decoration:none;
}
.dark-toggle{
    background:white;
    border:none;
    border-radius:8px;
    padding:6px 10px;
    cursor:pointer;
}

/* ===== CARD ===== */
.login-box{
    width:360px;
    margin:120px auto;
    background:white;
    padding:35px 30px;
    border-radius:16px;
    text-align:center;
    border:1px solid #b7d7d3;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
}
.login-box h2{
    color:var(--primary);
    margin-bottom:20px;
}
.login-box input{
    width:95%;
    padding:11px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #b7d7d3;
}
.login-box button{
    width:95%;
    padding:11px;
    margin-top:10px;
    background:linear-gradient(90deg,var(--primary),var(--primary-dark));
    color:white;
    font-weight:700;
    border:none;
    border-radius:10px;
    cursor:pointer;
}
.login-box a{
    color:var(--primary);
    font-weight:600;
    text-decoration:none;
}
.error{
    color:#b00000;
    margin-bottom:10px;
}

/* ===== FOOTER ===== */
footer{
    position:fixed;
    bottom:0;left:0;
    width:100%;
    padding:14px;
    background:var(--primary);
    color:white;
    text-align:center;
}

/* =====================
   🌙 DARK MODE
===================== */
body.dark-mode{
    background:var(--dark-bg);
    color:var(--dark-text);
}
body.dark-mode .navbar,
body.dark-mode footer{
    background:var(--dark-bar);
}
body.dark-mode .login-box{
    background:var(--dark-box);
    border:1px solid var(--dark-border);
    color:var(--dark-text);
}
body.dark-mode input{
    background:#020617;
    color:var(--dark-text);
    border:1px solid var(--dark-border);
}

body.dark-mode .login-box h2,
body.dark-mode .login-box a{
    background:none !important;
    -webkit-background-clip:unset !important;
    -webkit-text-fill-color:var(--primary) !important;
    color:var(--primary) !important;
}
</style>
</head>

<body>

<?php require('components/header.php'); ?>

<div class="login-box">
    <h2>Lupa Password</h2>

    <?php if(isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Masukkan email Anda" required>
        <button type="submit">Kirim Link Reset</button>
    </form>

    <p style="margin-top:10px;">
        <a href="login.php">Kembali ke Login</a>
    </p>
</div>

<!-- footer -->
<?php require('components/footer.php'); ?>

<script src="script.js"></script>

<script>
function toggleDark(){
    document.body.classList.toggle("dark-mode");
}
</script>

</body>
</html>
