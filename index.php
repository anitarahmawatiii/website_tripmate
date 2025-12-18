<!DOCTYPE html>
<html lang="id">
<head>
  <?php require('components/head.php'); ?>
  <title>TripMate Lampung – Home</title>
</head>
<body>

  <!-- Header -->
  <script src="script.js"></script>
</body>

  <?php require('components/header.php'); ?>

  <section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Selamat Datang di <span>TripMate Lampung</span></h1>
      <p>Temukan pesona wisata Lampung yang memukau</p>
      <a href="dashboard.php" class="btn-primary">Jelajahi Sekarang</a>
    </div>
  </section>

  <!-- Profil Lampung -->
  <section class="profil" id="profil">
    <div class="container">
      <h2>Profil Singkat Provinsi Lampung</h2>
      <p>
        Lampung terletak di ujung selatan Pulau Sumatra dan dikenal sebagai 
        <strong>Gerbang Sumatra</strong> karena menjadi pintu masuk utama dari Pulau Jawa.
        Provinsi ini memiliki keindahan alam luar biasa seperti pantai, gunung, taman nasional,
        serta budaya khas yang memikat hati wisatawan dari seluruh dunia.
      </p>
    </div>
  </section>

  <!-- Destinasi Unggulan -->
<section class="destinasi" id="destinasi">
  <h2>Destinasi Unggulan Lampung</h2>
  <div class="card-container">

    <!-- Pantai Tanjung Setia -->
<div class="card">
  <img src="img/tanjung setia.jpg" alt="Pantai Tanjung Setia">
  <div class="card-body">
    <h3>Pantai Tanjung Setia</h3>
    <p>Terletak di pesisir Lampung Barat, Pantai Tanjung Setia memanjakan pengunjung dengan ombak besar yang stabil dan panorama pantai tropis yang alami. Suasana damainya cocok untuk menikmati matahari terbenam atau bermain air di tepi pantai.</p>
  </div>
</div>

    <!-- Pulau Pahawang -->
<div class="card">
  <img src="img/1765619278_pulau_pahawang.jpeg" alt="Pulau Pahawang">
  <div class="card-body">
    <h3>Pulau Pahawang</h3>
    <p>Pulau Pahawang menawarkan panorama laut biru jernih, hamparan pasir putih, dan terumbu karang yang memukau. Destinasi ini sangat populer bagi pecinta snorkeling yang ingin melihat langsung pesona biota laut Lampung.</p>
  </div>
</div>

    <!-- Taman Nasional Way Kambas -->
<div class="card">
  <img src="img/way_kambas.jpeg" alt="Taman Nasional Way Kambas">
  <div class="card-body">
    <h3>Taman Nasional Way Kambas</h3>
    <p>Taman Nasional Way Kambas menawarkan pengalaman wisata alam yang memadukan edukasi dan petualangan. Di sini, pengunjung bisa menyaksikan aktivitas gajah sumatra, menjelajahi hutan tropis, dan mengenal upaya pelestarian satwa langka.</p>
  </div>
</div>
</section>

 <!-- footer -->
  <?php require('components/footer.php'); ?>

<!-- POPUP -->
<div id="popup" class="popup">
  <div class="popup-box">
    <h3>Selamat Datang di TripMate Lampung 🌴</h3>
    <p>Jelajahi berbagai destinasi wisata terbaik di Lampung!</p>
    <button id="closePopup">Tutup</button>
  </div>
</div>

<script>
  window.onload = function() {
    document.getElementById("popup").classList.add("show");
  };

  document.getElementById("closePopup").onclick = function() {
    document.getElementById("popup").classList.remove("show");
  };
</script>
</body>
</html> 