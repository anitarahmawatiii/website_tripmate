<?php
include "koneksi.php";

// CEK PARAMETER ID
if (!isset($_GET['id'])) {
    die("ID wisata tidak ditemukan!");
}

$id = intval($_GET['id']);

$query = mysqli_query($koneksi, "
    SELECT 
        w.nama_wisata,
        d.lokasi,
        d.kategori,
        d.deskripsi,
        d.harga_masuk,
        d.harga_parkir,
        d.nama_barang_sewa,
        d.total_sewa_barang,
        d.total_makanan,
        d.total_biaya,
        d.foto_detail
    FROM wisatatripmate w
    LEFT JOIN detail_wisatatripmate d 
        ON d.id_wisatatripmate = w.id_wisatatripmate
    WHERE w.id_wisatatripmate = $id
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data wisata tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Wisata</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f7fb;
    padding: 30px;
}

.card {
    width: 650px;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.card img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

table td:first-child {
    font-weight: bold;
    width: 40%;
}

.btn-back {
    display: inline-block;
    padding: 10px 20px;
    background: #006d77;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    margin-top: 15px;
}
</style>
</head>

<body>

<div class="card">

    <!-- FOTO WISATA -->
    <?php if (!empty($data['foto_detail'])) : ?>
        <img src="img/<?= $data['foto_detail']; ?>" alt="<?= $data['nama_wisata']; ?>">
    <?php endif; ?>

    <h2><?= $data['nama_wisata']; ?></h2>

    <table>
        <tr>
            <td>Lokasi</td>
            <td><?= $data['lokasi'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td><?= $data['kategori'] ?? '-'; ?></td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td><?= nl2br($data['deskripsi'] ?? '-'); ?></td>
        </tr>
        <tr>
            <td>Harga Masuk</td>
            <td>Rp <?= number_format($data['harga_masuk'] ?? 0, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Harga Parkir</td>
            <td>Rp <?= number_format($data['harga_parkir'] ?? 0, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Barang Sewa</td>
            <td><?= nl2br($data['nama_barang_sewa'] ?? '-'); ?></td>
        </tr>
        <tr>
            <td>Total Sewa Barang</td>
            <td>Rp <?= number_format($data['total_sewa_barang'] ?? 0, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Total Makanan</td>
            <td>Rp <?= number_format($data['total_makanan'] ?? 0, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Total Biaya</td>
            <td><b>Rp <?= number_format($data['total_biaya'] ?? 0, 0, ',', '.'); ?></b></td>
        </tr>
    </table>

    <a class="btn-back" href="dashboard.php">← Kembali</a>
</div>

</body>
</html>
