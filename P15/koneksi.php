<?php
date_default_timezone_set('Asia/Jakarta');

$conn = mysqli_connect("localhost","root","","id21490355_windi");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pemeriksaan sederhana untuk melihat apakah koneksi berhasil
if ($conn) {
    echo " ";
}

?>