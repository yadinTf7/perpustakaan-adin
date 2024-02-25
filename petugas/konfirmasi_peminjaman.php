<?php
// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "../config/config.php";

// Periksa apakah parameter id_peminjaman sudah ada
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$idPeminjaman = $_GET["id"];

// Perbarui status peminjaman menjadi "Sudah dikonfirmasi"
$query = "UPDATE peminjaman SET status = 'Konfirmasi' WHERE id_peminjaman = $idPeminjaman";
if (mysqli_query($connection, $query)) {
    // Redirect kembali ke halaman petugas
    header("Location: index.php");
    exit;
} else {
    echo "Error updating record: " . mysqli_error($connection);
}
?>
