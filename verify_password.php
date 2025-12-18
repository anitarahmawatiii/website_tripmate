<?php
// verify_password.php
// Simpan file ini sebagai verify_password.php
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pw = $_POST['password'] ?? "";
    $hash = $_POST['hash'] ?? "";
    $pw = (string)$pw;
    $hash = (string)$hash;

    if ($pw === "" || $hash === "") {
        $result = "Masukkan password dan hash.";
    } else {
        if (password_verify($pw, $hash)) {
            $result = "✅ Password cocok dengan hash (VERIFIED).";
            // cek apakah hash perlu rehash (optional)
            if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                $result .= " — NOTE: hash disarankan untuk dirubah (rehash) dengan algorithm terbaru.";
            }
        } else {
            $result = "❌ Password TIDAK cocok dengan hash.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Verify Password - TripMate</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Inter,system-ui,Arial;margin:30px;background:#f3fbfa;color:#033;}
    .card{max-width:900px;margin:0 auto;padding:20px;background:#fff;border-radius:10px;box-shadow:0 6px 24px rgba(0,0,0,0.08);}
    input[type="password"], textarea{width:100%;padding:10px;margin:8px 0;border-radius:8px;border:1px solid #cfe9e6;}
    button{background:#006D77;color:#fff;border:none;padding:10px 16px;border-radius:8px;cursor:pointer;font-weight:700}
    pre{background:#f6fffe;padding:12px;border-radius:8px;overflow:auto}
  </style>
</head>
<body>
  <div class="card">
    <h2>Verify Password vs Hash</h2>
    <p>Masukkan password asli dan hash yang ingin diuji.</p>

    <form method="post" autocomplete="off">
      <label>Password</label>
      <input type="password" name="password" required>

      <label>Hash (paste di sini)</label>
      <textarea name="hash" rows="3" required><?= isset($_POST['hash']) ? htmlspecialchars($_POST['hash']) : '' ?></textarea>

      <div style="margin-top:10px;">
        <button type="submit">Verify</button>
      </div>
    </form>

    <?php if ($result !== null): ?>
      <hr>
      <h3>Hasil</h3>
      <pre><?= htmlspecialchars($result) ?></pre>
    <?php endif; ?>

    <p><small>Gunakan ini untuk mengecek apakah <code>password_verify()</code> mengembalikan true untuk pasangan password/hash tertentu.</small></p>
  </div>
</body>
</html>
