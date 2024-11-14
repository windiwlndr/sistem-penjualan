<?php
session_start();

if (isset($_SESSION['islogin'])) $_SESSION['islogin'] = false;
if (isset($_SESSION['nama'])) $_SESSION['nama'] = '';
if (isset($_SESSION['level'])) $_SESSION['level'] = '';

// Hentikan sesi
session_destroy();

$newURL = "login.php";
echo "<script>window.location.href = '{$newURL}';</script>";
?>
