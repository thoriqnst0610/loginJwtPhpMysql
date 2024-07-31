<?php
// logout.php

// Hapus cookie JWT
setcookie('jwt', '', time() - 3600, '/'); // Hapus cookie dengan waktu kedaluwarsa di masa lalu

// Redirect ke halaman login
header('Location: login.php');
exit();
?>
