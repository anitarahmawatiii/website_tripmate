<?php
require "koneksi.php";

if (!isset($_GET['token'])) {
    die("Token tidak ditemukan!");
}

$token = $_GET['token'];

$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE reset_token='$token'");
if (mysqli_num_rows($cek) !== 1) {
    die("Token tidak valid!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($koneksi, "
        UPDATE users 
        SET password='$password', reset_token=NULL 
        WHERE reset_token='$token'
    ");

    echo "<script>
            alert('Password berhasil direset!');
            window.location='login.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php require('components/head.php'); ?>
<title>Reset Password - TripMate</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

:root{
    --primary:#006D77;
    --dark-bg:#020617;
    --dark-bar:#0b1226;
    --dark-border:#1e293b;
    --dark-text:#e5e7eb;
}

/* ===== BODY ===== */
body{
    background:#f2f2f2;
    padding-top:80px;
    padding-bottom:80px;
    transition:.3s;
}

/* ===== NAVBAR ===== */
.navbar{
    position:fixed;
    top:0;left:0;
    width:100%;
    height:70px;
    padding:0 40px;
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
    text-decoration:none;
    font-weight:600;
}

.dark-toggle{
    background:white;
    border:none;
    border-radius:8px;
    padding:6px 10px;
    cursor:pointer;
}

/* ===== RESET BOX ===== */
.reset-box{
    width:380px;
    padding:32px;
    margin:80px auto;
    background:white;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.1);
    text-align:center;
}

.reset-box h2{
    color:var(--primary);
    margin-bottom:20px;
}

.reset-box input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
}

.reset-box button{
    width:100%;
    padding:12px;
    background:var(--primary);
    border:none;
    border-radius:8px;
    color:white;
    font-weight:600;
    cursor:pointer;
    margin-top:10px;
}

.reset-box a{
    color:var(--primary);
    font-weight:600;
    text-decoration:none;
}

/* ===== FOOTER ===== */
footer{
    position:fixed;
    bottom:0;left:0;
    width:100%;
    padding:12px;
    text-align:center;
    background:var(--primary);
    color:white;
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

body.dark-mode .reset-box{
    background:var(--dark-bg);
    border:1px solid var(--dark-border);
    color:var(--dark-text);
}

body.dark-mode .reset-box input{
    background:#020617;
    color:var(--dark-text);
    border:1px solid var(--dark-border);
}


body.dark-mode .reset-box h2,
body.dark-mode .reset-box a{
    background:none !important;
    -webkit-background-clip:initial !important;
    -webkit-text-fill-color:#006D77 !important;
    color:#006D77 !important;
}
</style>
</head>

<body>

<?php require('components/header.php'); ?>

<div class="reset-box">
    <h2>Reset Password</h2>

    <form method="POST">
        <input type="password" name="password" placeholder="Password Baru" required>
        <button type="submit">Reset Password</button>
    </form>

    <p style="margin-top:10px;">
        <a href="login.php">Kembali ke Login</a>
    </p>
</div>

<?php require('components/footer.php'); ?>

<script src="script.js"></script>

<script>
function toggleDark(){
    document.body.classList.toggle("dark-mode");
}
</script>

</body>
</html>
