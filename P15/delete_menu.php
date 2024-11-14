<?php
include 'koneksi.php';

$id_menu = $_GET["id"];

// Hapus menu dari database
$query = "DELETE FROM menu WHERE id_menu=$id_menu";
if ($conn->query($query)) {
    echo '<script>window.location.href = "menu.php";</script>';
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>
