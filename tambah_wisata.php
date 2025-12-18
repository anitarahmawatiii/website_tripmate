<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Wisata</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="navbar">
    <h2>🌴Tambah Wisata</h2>
    <div class="nav-right">
        <a href="admin_dashboard.php" class="logout">Kembali</a>
    </div>
</div>

<div class="container">
    <div class="box">
        <h3>Form Tambah Wisata</h3>
        <br>

        <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">

            <label>Nama Wisata:</label>
            <input type="text" name="nama" class="input-text" required>

            <label>Lokasi:</label>
            <input type="text" name="lokasi" class="input-text" required>

            <label>Kategori:</label>
            <input type="text" name="kategori" class="input-text" required>

            <label>Deskripsi:</label>
            <textarea name="deskripsi" class="input-text" required></textarea>

            <label>Harga Min:</label>
            <input type="number" name="harga_min" class="input-text" required>

            <label>Harga Max:</label>
            <input type="number" name="harga_max" class="input-text" required>

            <label>Foto:</label>
            <input type="file" name="foto" class="input-text" required>

            <br><br>
            <button type="submit" class="btn-add">Simpan</button>

        </form>
    </div>
</div>

<div class="footer">
    Sistem Informasi Wisata © 2025
</div>

</body>
</html>
