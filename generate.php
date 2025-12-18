<?php
// generate.php
// Simpan file ini sebagai generate.php
$hash = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pw = $_POST['password'] ?? "";
    // jangan trim password otomatis kalau ingin spasi dihitung, tapi biasanya trim aman:
    $pw = (string)$pw;
    if ($pw !== "") {
        // generate hash menggunakan default algorithm (bcrypt/argon2 tergantung PHP)
        $hash = password_hash($pw, PASSWORD_DEFAULT);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Generate Password Hash - TripMate</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Inter,system-ui,Arial;margin:30px;background:#f3fbfa;color:#033; }
    .card{max-width:700px;margin:0 auto;padding:20px;background:#fff;border-radius:10px;box-shadow:0 6px 24px rgba(0,0,0,0.08);}
    input[type="password"]{width:100%;padding:10px;margin:8px 0;border-radius:8px;border:1px solid #cfe9e6;}
    button{background:#006D77;color:#fff;border:none;padding:10px 16px;border-radius:8px;cursor:pointer;font-weight:700}
    pre{background:#f6fffe;padding:12px;border-radius:8px;overflow:auto}
    small{color:#666}
  </style>
</head>
<body>
  <div class="card">
    <h2>Generate Password Hash</h2>
    <p>Masukkan password untuk menghasilkan hash (menggunakan <code>password_hash()</code> PHP).</p>

    <form method="post" autocomplete="off">
      <label>Password</label>
      <input type="password" name="password" required>
      <div style="margin-top:10px;">
        <button type="submit">Generate Hash</button>
      </div>
    </form>

    <?php if ($hash): ?>
      <hr>
      <h3>Hasil Hash</h3>
      <pre><?= htmlspecialchars($hash) ?></pre>

      <h4>Contoh SQL (INSERT)</h4>
      <pre><?php
        // contoh menggunakan kolom username 'admin'
        $sql = "INSERT INTO users (username, password, role) VALUES ('admin', '". addslashes($hash) ."', 'admin');";
        echo htmlspecialchars($sql);
      ?></pre>

      <p><small>Catatan: simpan hash yang tampil ke kolom password di database. Gunakan <code>password_verify()</code> saat login.</small></p>
    <?php endif; ?>

  </div>
</body>
</html>
