<?php
session_start();
include "koneksi.php";

// CEK LOGIN
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// AMBIL DATA BERDASARKAN ID
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM wisata WHERE wisata_id='$id'");
$data = mysqli_fetch_assoc($query);

// UPDATE DATA
if (isset($_POST['update'])) {

    $nama = $_POST['nama_wisata'];
    $lokasi = $_POST['lokasi'];
    $kategori = $_POST['kategori'];
    $harga_min = $_POST['harga_min'];
    $harga_max = $_POST['harga_max'];
    $deskripsi = $_POST['deskripsi'];

    // Jika foto baru diupload
    if ($_FILES['foto']['name'] != "") {

        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "upload/" . $foto);

        // Hapus foto lama
        if (file_exists("upload/" . $data['foto'])) {
            unlink("upload/" . $data['foto']);
        }

        $update = "UPDATE wisata SET 
                    nama_wisata='$nama',
                    lokasi='$lokasi',
                    kategori='$kategori',
                    harga_min='$harga_min',
                    harga_max='$harga_max',
                    deskripsi='$deskripsi',
                    foto='$foto'
                   WHERE wisata_id='$id'";
    } else {
        $update = "UPDATE wisata SET 
                    nama_wisata='$nama',
                    lokasi='$lokasi',
                    kategori='$kategori',
                    harga_min='$harga_min',
                    harga_max='$harga_max',
                    deskripsi='$deskripsi'
                   WHERE wisata_id='$id'";
    }

    mysqli_query($koneksi, $update);
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Wisata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Edit Wisata</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Wisata</label>
        <input type="text" name="nama_wisata" value="<?= $data['nama_wisata'] ?>" required>

        <label>Lokasi</label>
        <input type="text" name="lokasi" value="<?= $data['lokasi'] ?>" required>

        <label>Kategori</label>
        <input type="text" name="kategori" value="<?= $data['kategori'] ?>" required>

        <label>Harga Minimum</label>
        <input type="number" name="harga_min" value="<?= $data['harga_min'] ?>" required>

        <label>Harga Maksimum</label>
        <input type="number" name="harga_max" value="<?= $data['harga_max'] ?>" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required><?= $data['deskripsi'] ?></textarea>

        <label>Foto Lama</label>
        <img src="upload/<?= $data['foto'] ?>" width="120">

        <label>Ganti Foto (Opsional)</label>
        <input type="file" name="foto">

        <button type="submit" name="update" class="btn-add">Update</button>

    </form>
</div>

</body>
</html>
