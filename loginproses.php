<?php
// loginproses.php

require 'vendor/autoload.php'; // Pastikan library JWT diinstal melalui Composer
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Konfigurasi
$key = 'your_secret_key';

// Ambil data dari form
$user = $_POST['username'];
$pass = $_POST['password'];

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jwt";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil hash password dari database untuk pengguna yang diberikan
$sql = "SELECT password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($stored_hash);
$stmt->fetch();
// $stmt->close();
// $conn->close();

// Verifikasi kredensial
if ($stmt->num_rows === 1 && password_verify($pass, $stored_hash)) {
    // Buat payload
    $payload = [
        'iss' => 'http://localhost/jwt',  // Issuer untuk pengembangan lokal
        'aud' => 'http://localhost/jwt',  // Audience untuk pengembangan lokal
        'iat' => time(),               // Issued At
        'exp' => time() + 3600,        // Expiration Time (1 hour)
        'data' => [
            'username' => $user
        ]
    ];

    // Encode JWT
    $jwt = JWT::encode($payload, $key, 'HS256');

    // Set JWT as a cookie
    setcookie('jwt', $jwt, time() + 3600, '/'); // Cookie expires in 1 hour

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit();
} else {
    echo 'Invalid credentials';
}
?>
