<?php
session_start();
require "../koneksi.php";

/* =========================
   CEK LOGIN
========================= */
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

/* =========================
   SIMPAN DATA
========================= */
if (isset($_POST['save'])) {

    $id = $_POST['id'] ?? "";
    $nama = $_POST['nama_wisata'];
    $lokasi = $_POST['lokasi'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    $harga_masuk = $_POST['harga_masuk'];
    $harga_parkir = $_POST['harga_parkir'];
    $nama_barang_sewa = $_POST['nama_barang_sewa'];
    $total_sewa_barang = $_POST['total_sewa_barang'];
    $total_makanan = $_POST['total_makanan'];

    $total_biaya = $harga_masuk + $harga_parkir + $total_sewa_barang + $total_makanan;

    // Upload Foto
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../img/" . $foto);
    } else {
        $foto = $_POST['foto_lama'] ?? "";
    }

    if ($id == "") {
        mysqli_query($koneksi,"
            INSERT INTO wisatatripmate (nama_wisata, foto)
            VALUES ('$nama', '$foto')
        ");

        $last_id = mysqli_insert_id($koneksi);

        mysqli_query($koneksi,"
    INSERT INTO detail_wisatatripmate
    (id_wisatatripmate, lokasi, kategori, deskripsi, harga_masuk, harga_parkir, nama_barang_sewa, total_sewa_barang, total_makanan, total_biaya, foto_detail)
    VALUES
    ($last_id, '$lokasi', '$kategori', '$deskripsi', '$harga_masuk', '$harga_parkir', '$nama_barang_sewa', '$total_sewa_barang', '$total_makanan', '$total_biaya', '$foto')
");

    } else {
        mysqli_query($koneksi,"
            UPDATE wisatatripmate SET
                nama_wisata='$nama',
                foto='$foto'
            WHERE id_wisatatripmate=$id
        ");

        mysqli_query($koneksi,"
    UPDATE detail_wisatatripmate SET
        lokasi='$lokasi',
        kategori='$kategori',
        deskripsi='$deskripsi',
        harga_masuk='$harga_masuk',
        harga_parkir='$harga_parkir',
        nama_barang_sewa='$nama_barang_sewa',
        total_sewa_barang='$total_sewa_barang',
        total_makanan='$total_makanan',
        total_biaya='$total_biaya',
        foto_detail='$foto'
    WHERE id_wisatatripmate=$id
");

    }

    header("Location: admin_dashboard.php");
    exit;
}

/* =========================
   HAPUS DATA
========================= */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    mysqli_query($koneksi,"DELETE FROM detail_wisatatripmate WHERE id_wisatatripmate=$id");
    mysqli_query($koneksi,"DELETE FROM wisatatripmate WHERE id_wisatatripmate=$id");

    header("Location: admin_dashboard.php");
    exit;
}

/* =========================
   AMBIL DATA LIST
========================= */
$wisata = mysqli_query($koneksi,"
    SELECT 
        w.id_wisatatripmate,
        w.nama_wisata,
        w.foto,
        d.lokasi,
        d.kategori,
        d.total_biaya
    FROM wisatatripmate w
    LEFT JOIN detail_wisatatripmate d
        ON w.id_wisatatripmate = d.id_wisatatripmate
    ORDER BY w.id_wisatatripmate DESC
");

/* =========================
   FORM EDIT
========================= */
$edit = null;
$detail = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit   = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM wisatatripmate WHERE id_wisatatripmate=$id"));
    $detail = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM detail_wisatatripmate WHERE id_wisatatripmate=$id"));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - TripMate</title>

<style>
body { background:#f4f6f8; margin:0; font-family:Arial; }
.navbar { background:#006d77; padding:15px 30px; color:white; display:flex; justify-content:space-between; }
.navbar a { color:white; margin-left:20px; text-decoration:none; font-weight:bold; }
.container { width:85%; margin:auto; }
.box { background:white; padding:25px; margin-top:25px; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,.1); }
input, textarea { width:100%; padding:12px; margin-bottom:14px; border-radius:8px; border:1px solid #ccc; }
button { padding:12px 25px; background:#006d77; color:white; border:none; border-radius:8px; font-weight:bold; }
.table { width:100%; border-collapse:collapse; margin-top:20px; }
.table th { background:#006d77; color:white; padding:12px; }
.table td { padding:10px; border-bottom:1px solid #ddd; text-align:center; }

.action-buttons {
    display:flex;
    flex-direction:column;
    gap:6px;
}

.edit-btn {
    background:#fcbf49;
    padding:6px;
    border-radius:6px;
    text-decoration:none;
    color:black;
}

.delete-btn {
    background:#e63946;
    padding:6px;
    border-radius:6px;
    text-decoration:none;
    color:white;
}

.footer { margin-top:50px; background:#006d77; color:white; text-align:center; padding:18px; }

/* =========================
   DARK MODE – MODE MALAM
========================= */
body.dark-mode {
    background:#020617;
    color:#e5e7eb;
}

/* NAVBAR */
body.dark-mode .navbar {
    background:#020617;
}

/* CARD / BOX */
body.dark-mode .box {
    background:#0f172a;
    color:#e5e7eb;
}

/* INPUT */
body.dark-mode input,
body.dark-mode textarea {
    background:#020617;
    color:#e5e7eb;
    border:1px solid #334155;
}

/* FOOTER */
body.dark-mode .footer {
    background:#020617;
    color:#cbd5f5;
}

</style>
</head>

<body>
 <script src="script.js"></script>
<div class="navbar">
<b>🌴 TripMate Admin</b>
<div>
<a href="admin_dashboard.php">Dashboard</a>
<a href="../logout.php">Keluar</a>
<button id="darkToggle" class="dark-toggle" aria-label="Toggle Dark Mode">
    🌙
  </button>
</li>

</div>
</div>

<div class="container">

<div class="box">
<h3><?= $edit ? "Edit Wisata" : "Tambah Wisata Baru" ?></h3>

<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $edit['id_wisatatripmate'] ?? "" ?>">
<input type="hidden" name="foto_lama" value="<?= $edit['foto'] ?? "" ?>">

<label>Nama Wisata</label>
<input type="text" name="nama_wisata" required value="<?= $edit['nama_wisata'] ?? "" ?>">

<label>Lokasi</label>
<input type="text" name="lokasi" required value="<?= $detail['lokasi'] ?? "" ?>">

<label>Kategori</label>
<input type="text" name="kategori" required value="<?= $detail['kategori'] ?? "" ?>">

<label>Deskripsi</label>
<textarea name="deskripsi"><?= $detail['deskripsi'] ?? "" ?></textarea>

<label>Harga Masuk</label>
<input type="number" name="harga_masuk" value="<?= $detail['harga_masuk'] ?? 0 ?>">

<label>Harga Parkir</label>
<input type="number" name="harga_parkir" value="<?= $detail['harga_parkir'] ?? 0 ?>">

<label>Nama Barang Sewa</label>
<textarea name="nama_barang_sewa"><?= $detail['nama_barang_sewa'] ?? "" ?></textarea>

<label>Total Sewa Barang</label>
<input type="number" name="total_sewa_barang" value="<?= $detail['total_sewa_barang'] ?? 0 ?>">

<label>Total Makanan</label>
<input type="number" name="total_makanan" value="<?= $detail['total_makanan'] ?? 0 ?>">

<label>Upload Foto</label>
<input type="file" name="foto">

<button name="save">💾 SIMPAN</button>
</form>
</div>

<div class="box">
<h3>Daftar Wisata</h3>

<table class="table">
<tr>
<th>No</th>
<th>Nama</th>
<th>Lokasi</th>
<th>Kategori</th>
<th>Total Biaya</th>
<th>Foto</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($w=mysqli_fetch_assoc($wisata)): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $w['nama_wisata'] ?></td>
<td><?= $w['lokasi'] ?></td>
<td><?= $w['kategori'] ?></td>
<td>Rp <?= number_format($w['total_biaya'] ?? 0,0,',','.') ?></td>
<td>
    <img src="../img/<?= $w['foto'] ?>" width="80" style="border-radius:8px;">
</td>
<td>
    <div class="action-buttons">
        <a href="?edit=<?= $w['id_wisatatripmate'] ?>" class="edit-btn">Edit</a>
        <a href="?hapus=<?= $w['id_wisatatripmate'] ?>" class="delete-btn"
           onclick="return confirm('Hapus data ini?')">Hapus</a>
    </div>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>
<script>
const toggle = document.getElementById("darkToggle");

// cek mode terakhir
if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
    toggle.textContent = "☀️";
}

// klik tombol
toggle.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
        toggle.textContent = "🌙";
    } else {
        localStorage.setItem("theme", "light");
        toggle.textContent = "☀️";
    }
});
</script>

<div class="footer">© TripMate Lampung</div>

</body>
</html>
