<?php
session_start();
require "koneksi.php";

$wisata_database = [];

/* =========================
   QUERY DATA WISATA
   ========================= */
$query = mysqli_query(
    $koneksi,
    "SELECT id_wisatatripmate, nama_wisata, foto 
     FROM wisatatripmate 
     ORDER BY id_wisatatripmate DESC"
);

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

/* =========================
   AMBIL DATA
   ========================= */
while ($row = mysqli_fetch_assoc($query)) {
    $wisata_database[] = [
        "id"   => $row["id_wisatatripmate"],
        "nama" => $row["nama_wisata"],
        "foto" => !empty($row["foto"]) 
                    ? "img/" . $row["foto"] 
                    : "img/default.png"
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cari Wisata Lampung - TripMate</title>

<link rel="stylesheet" href="style.css">

<style>
body {
    background: #f5f5f5;
}

.search-section {
    text-align: center;
    margin-top: 30px;
}

.search-section input {
    width: 320px;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
}

.wisata-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    padding: 40px;
}

.card {
    background: white;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
    transition: 0.3s;
    display: flex;
    flex-direction: column;
    height: 330px;
}

.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.card h4 {
    margin: 12px;
    text-align: center;
}

.lihat-btn {
    margin: auto 15px 18px;
    padding: 12px;
    background: #009688;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}
</style>
</head>
<script src="script.js"></script>
<body>

<?php require 'components/header.php'; ?>

<section class="search-section">
    <h2>Cari Wisata Lampung</h2>
    <input type="text" id="searchInput" placeholder="Ketik nama wisata...">
</section>

<section id="wisataContainer" class="wisata-container"></section>

<?php require 'components/footer.php'; ?>

<script>
const wisataList = <?= json_encode($wisata_database, JSON_UNESCAPED_UNICODE); ?>;
const container = document.getElementById("wisataContainer");
const searchInput = document.getElementById("searchInput");

function lihatDetail(id) {
    window.location.href = "detail.php?id=" + id;
}

function buatCard(item) {
    return `
        <div class="card">
            <img src="${item.foto}" alt="${item.nama}">
            <h4>${item.nama}</h4>
            <button class="lihat-btn" onclick="lihatDetail(${item.id})">
                Lihat Detail
            </button>
        </div>
    `;
}

searchInput.addEventListener("input", () => {
    const keyword = searchInput.value.toLowerCase();

    if (keyword === "") {
        container.innerHTML = "<p style='grid-column:1/-1;text-align:center'>Ketik untuk mencari wisata...</p>";
        return;
    }

    const hasil = wisataList.filter(w =>
        w.nama.toLowerCase().includes(keyword)
    );

    container.innerHTML = hasil.length
        ? hasil.map(buatCard).join("")
        : "<p style='grid-column:1/-1;text-align:center'>Tidak ditemukan.</p>";
});

container.innerHTML = "<p style='grid-column:1/-1;text-align:center'>Ketik untuk mencari wisata...</p>";
</script>

</body>
</html>
