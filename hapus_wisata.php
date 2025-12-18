<?php
include "koneksi.php";

$id = $_GET['id'];

// Ambil data foto dulu
$query = mysqli_query($koneksi, "SELECT foto FROM wisata WHERE wisata_id='$id'");
$data = mysqli_fetch_assoc($query);

// Hapus foto fisik
if (file_exists("upload/" . $data['foto'])) {
    unlink("upload/" . $data['foto']);
}

// Hapus data dari database
mysqli_query($koneksi, "DELETE FROM wisata WHERE wisata_id='$id'");

header("Location: admin_dashboard.php");
exit();
?>
