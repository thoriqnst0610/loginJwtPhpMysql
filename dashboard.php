<?php
// dashboard.php

require 'vendor/autoload.php'; // Pastikan library JWT diinstal melalui Composer
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Kunci rahasia untuk JWT
$secret_key = "your_secret_key";

// Periksa token JWT dari cookie
if (isset($_COOKIE['jwt'])) {
    $jwt = $_COOKIE['jwt'];

    try {
        // Decode token
        $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));

        // Ambil username dari token
        $username = $decoded->data->username;

        echo "<h2>Welcome, " . htmlspecialchars($username) . "!</h2>";
        echo "<a href='logout.php'>Logout</a>";

        // Anda bisa menambahkan konten dashboard di sini

    } catch (Exception $e) {
        echo "Token tidak valid.";
    }
} else {
    echo "Anda harus login terlebih dahulu.";
}
?>
