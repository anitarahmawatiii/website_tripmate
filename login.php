<?php 
session_start();
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $data  = mysqli_fetch_assoc($query);

    if ($data) {
        if (!password_verify($password, $data['password'])) {
            $error = "Password salah!";
        } elseif ($data['role'] !== $role) {
            $error = "Role tidak sesuai!";
        } else {
            $_SESSION['login']    = true;
            $_SESSION['username'] = $data['username']; 
            $_SESSION['email']    = $data['email'];
            $_SESSION['role']     = $data['role'];

            if ($data['role'] === 'admin') {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<?php require('components/head.php'); ?>
<title>Login TripMate</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}

body{
    background:#f2f2f2;
    transition:background .4s,color .4s;
}

/* ===== NAVBAR ===== */
.navbar{
    width:100%;
    background:#006D77;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

/* ===== LOGIN BOX ===== */
.login-box{
    width:380px;
    padding:32px;
    margin:60px auto 100px auto;
    background:white;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    text-align:center;
    transition:background .4s,color .4s,border .4s;
}

.login-box h2{
    color:#006D77;
    margin-bottom:20px;
}

.login-box input,
.login-box select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
    outline:none;
    font-size:14px;
}

.login-box button{
    width:100%;
    padding:12px;
    background:#006D77;
    border:none;
    border-radius:8px;
    color:white;
    font-weight:600;
    cursor:pointer;
    margin-top:10px;
    -webkit-tap-highlight-color: transparent;
}

.login-box button:hover,
.login-box button:active,
.login-box button:focus{
    background:#006D77 !important;
    color:white;
    outline:none;
    box-shadow:none;
}

.login-box a{
    color:#006D77;
    text-decoration:none;
    font-weight:600;
}

.login-box a:hover,
.login-box a:active,
.login-box a:visited,
.login-box a:focus{
    color:#006D77;
}

/* ERROR */
.error{
    color:#b40000;
    font-size:14px;
    padding:5px;
}

/* ===== FOOTER ===== */
footer{
    background:#006D77;
    color:white;
    padding:12px;
    text-align:center;
    position:fixed;
    bottom:0;
    width:100%;
    font-size:14px;
}

/* ===== DARK MODE ===== */
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

body.dark-mode input,
body.dark-mode select{
    background:#020617;
    color:#e5e7eb;
    border:1px solid #334155;
}
</style>
</head>

<body>

<?php require('components/header.php'); ?>

<div class="login-box">
    <h2>Masuk ke TripMate</h2>

    <?php if(!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="role" required>
            <option value="" disabled selected>Pilih Role</option>
            <option value="admin">Admin</option>
            <option value="user">Pengguna</option>
        </select>

        <button type="submit">Masuk</button>

        <p style="margin-top:12px;">
            <a href="forgot_password.php">Lupa Password?</a>
        </p>
    </form>

    <p style="margin-top:10px;">
        <a href="register.php">Belum punya akun? Daftar</a>
    </p>
</div>

<?php require('components/footer.php'); ?>

<script src="script.js"></script>

</body>
</html>
