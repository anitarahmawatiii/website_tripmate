<?php
include "koneksi.php";

$wisata_id  = $_POST['wisata_id'];
$nama       = $_POST['nama_wisata'];
$lokasi     = $_POST['lokasi'];
$kategori   = $_POST['kategori'];
$deskripsi  = $_POST['deskripsi'];
$harga_min  = $_POST['harga_min'];
$harga_max  = $_POST['harga_max'];

$query = "UPDATE wisata SET 
            nama_wisata='$nama',
            lokasi='$lokasi', 
            kategori='$kategori',
            deskripsi='$deskripsi',
            harga_min='$harga_min',
            harga_max='$harga_max'
          WHERE wisata_id='$wisata_id'";

mysqli_query($koneksi, $query);

// Cek apakah berhasil
if (mysqli_affected_rows($koneksi) > 0) {
    header("Location: admin_dashboard.php");
    exit;
} else {
    echo "Update gagal, periksa query atau database!";
}
?>
