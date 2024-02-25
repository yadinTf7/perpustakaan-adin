<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Baca Buku</title>
    <link rel="stylesheet" href="../../assets/bacabuku.css">
</head>
<body>
    <h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff; position: relative; z-index: 2;">DAFTAR
            BUKU PERPUSTAKAAN</h1>
    <div class="container custom-container text-center">
        <a class="back-btn" href="Transaksipeminjaman.php">Kembali</a>
        <?php
        // Periksa apakah parameter pdf ada dalam URL
        if (isset($_GET['pdf'])) {
            // Ambil nilai parameter pdf dari URL
            $pdfUrl = urldecode($_GET['pdf']);
            // Tampilkan PDF menggunakan tag <embed>
            echo '<embed class="pdf-container" src="' . $pdfUrl . '" type="application/pdf" width="100%" height="100%" />';
        } else {
            // Jika parameter pdf tidak ditemukan, tampilkan pesan kesalahan
            echo 'Parameter pdf tidak ditemukan.';
        }
        ?>
    </div>
</body>
</html>
