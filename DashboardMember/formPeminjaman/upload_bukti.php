<?php
session_start();

if (!isset($_SESSION["signIn"])) {
  header("Location: ../../sign/link_login.php");
  exit;
}

require "../../config/config.php";

// Ambil id_peminjaman dari parameter GET
$idPeminjaman = $_GET['id'];

// Query untuk mengambil data nama_admin dan no_tlp berdasarkan id_peminjaman
$dataPinjam = queryReadData("SELECT admin.nama_admin, admin.no_tlp FROM peminjaman
                              INNER JOIN admin ON peminjaman.nama_admin = admin.nama_admin
                              WHERE peminjaman.id_peminjaman = $idPeminjaman");

$uploadStatus = ""; // Variabel untuk menyimpan status upload

if (isset($_POST['upload'])) {
  $namaFile = $_FILES['bukti']['name'];
  $fileTmpName = $_FILES['bukti']['tmp_name'];
  $filePath = "../../uploads/" . $namaFile;

  if (move_uploaded_file($fileTmpName, $filePath)) {
    // Update tabel peminjaman dengan nama file bukti transaksi
    $query = "UPDATE peminjaman SET bukti_transaksi = '$namaFile', status = 'Belum konfirmasi' WHERE id_peminjaman = $idPeminjaman";
    mysqli_query($connection, $query);

    $uploadStatus = "success"; // Set uploadStatus menjadi success
  } else {
    $uploadStatus = "error"; // Set uploadStatus menjadi error
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../../assets/bootsrap/bootstrap.min.css" rel="stylesheet">
     <script src="../../assets/bootsrap/de8de52639.js"></script>
     <title>Transaksi peminjaman Buku || Member</title>
     <link rel="stylesheet" href="../../assets/transpinjam.css">
     <link rel="stylesheet" href="../../assets/style.css">
     <script>
       // Fungsi untuk menampilkan alert box saat upload berhasil atau gagal
       function showUploadAlert(status) {
         if (status === "success") {
           alert("Upload bukti transaksi berhasil.");
         } else if (status === "error") {
           alert("Upload bukti transaksi gagal.");
         }
       }
     </script>
  </head>
  <body onload="showUploadAlert('<?php echo $uploadStatus; ?>')"> <!-- Panggil fungsi showUploadAlert saat halaman dimuat -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
    <h5 class="container text-left" style="font-family: 'Comic Sans MS', sans-serif; font-weight: bold; color: dark;">
      sastra mesin<img src="../../assets/header.png" alt="Logo" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
    </h5>

    <!-- Move dropdown button inside the navbar -->
    <div class="navbar-nav dropdown">
      <!-- Button trigger modal -->
      <a href="Transaksipeminjaman.php" class="btn btn-light">Kembali</a>
    </div>
</nav>
    <br><br><br>
            <div class="alert alert-success text-center container" style="max-width: 80%;margin-top: 20px;"><marquee behavior="" direction="center"><h6 style="margin-bottom: -1px;">SILAHKAN LAKUKAN PEMBAYARAN VIA DANA KE NO. HP YANG TERTERA DI KOLOM TABEL</h6></marquee></div>
            <div class="container">
    <div class="custom-container text-dark  flex-column show-custom-container" >
        <div class="card-header"><h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">Upload Bukti Pembayaran</h1></div>
            <div class="card-body">
    <?php foreach ($dataPinjam as $item) : ?>
    <div class="input-group mb-3 mt-1">
    <span class="input-group-text" id="basic-addon1">Nama Petugas</span>
    <input readonly type="text" value="<?= $item["nama_admin"]; ?>" class="form-control" placeholder="Tanggal Pinjam" aria-label="tgl_peminjaman" aria-describedby="basic-addon1" required>
</div>
<div class="input-group mb-3 mt-1">
    <span class="input-group-text" id="basic-addon1">No E-wallet petugas</span>
    <input readonly type="text" value="<?= $item["no_tlp"]; ?>" class="form-control" placeholder="Tenggat Pengembalian" aria-label="tgl_pengembalian" aria-describedby="basic-addon1" required>
</div>
<?php endforeach; ?>
<form action="" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3 mt-1">
    <span class="input-group-text" style="border: 1px solid black;border-radius: 10px; display:flex;justify-content:center;" id="basic-addon1">Bukti Transaksi</span>
    </div>
    <input type="file" class="form-control" name="bukti"></div><button type="submit" class="btn btn-primary" name="upload">Upload</button>
    </div>
    
  </form>
  
</div>
<footer id="footer" class="p-1 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <p class="text-light"><i>Copyright © 2023 SULTHAN MADYA.</i></p>
                </div>
            </div>
        </footer>
</body>
</html>
