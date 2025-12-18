<?php
$password_asli = "admin123"; // ganti sesuai password yang kamu mau
$hash = password_hash($password_asli, PASSWORD_DEFAULT);

echo $hash;
