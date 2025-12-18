<!DOCTYPE html>
<html lang="id">
<head>
  <?php require('components/head.php'); ?>
  <title>Tentang Kami - TripMate Lampung</title>
  <link rel="stylesheet" href="style.css" />

</head>

<body>

    <!-- Header -->
 <?php require('components/header.php'); ?>
  <script src="script.js"></script>

<div class="container">

  <p class="intro">
    TripMate Lampung adalah platform digital yang membantu wisatawan menjelajahi keindahan
    alam, budaya, serta destinasi wisata menarik di Lampung dengan mudah. Website ini
    dikembangkan oleh <b>Kelompok 9 PTI Universitas Lampung</b> sebagai media informasi wisata.
  </p>

  <div class="contact-wrapper">

   <!-- FORM -->
<div class="contact-form">
  <h2>Hubungi Kami</h2>

  <form id="formKontak">

    <div class="input-row">
      <input type="text" id="nama" placeholder="Nama Anda" required>
      <input type="email" id="email" placeholder="Email Anda" required>
    </div>

    <textarea id="pesan" placeholder="Pesan" required></textarea>

    <button type="submit">Kirim</button>
  </form>
</div>

<script>
  document.getElementById("formKontak").addEventListener("submit", function(e) {
    e.preventDefault();      // mencegah reload
    this.reset();            // mengosongkan input
    alert("Pesan berhasil dikirim!"); // opsional, bisa dihapus
  });
</script>

    <!-- CONTACT INFO -->
    <div class="contact-info">
      <h2>Kontak</h2>

      <p style="line-height: 1.7; margin-bottom: 20px; color:#444;">
        Silakan hubungi kami kapan saja jika membutuhkan bantuan atau memiliki pertanyaan
        mengenai TripMate Lampung.
      </p>

      <div class="contact-item">
        <div class="icon">📧</div>
        TripmateLampung@gmail.com
      </div>

      <div class="contact-item">
        <div class="icon">📞</div>
        085805703417
      </div>

    </div>
  </div>
</div>

<!-- footer -->
  <?php require('components/footer.php'); ?>
</body>
</html>
