<?php 
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/link_login.php");
  exit;
}

$uploadStatus = "";

if (isset($_POST['upload'])) {
  // Proses upload bukti transaksi
  // ...

  if (move_uploaded_file($fileTmpName, $filePath)) {
    // Update status upload
    $uploadStatus = "success";
  } else {
    $uploadStatus = "error";
  }
}
require "../../config/config.php";
pengembalian();

$akunMember = $_SESSION["member"]["nisn"];
$dataPinjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, admin.nama_admin, peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian, peminjaman.status, buku.isi_buku, harga, peminjaman.bukti_transaksi
                              FROM peminjaman
                              INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
                              INNER JOIN member ON peminjaman.nisn = member.nisn
                              INNER JOIN admin ON peminjaman.nama_admin = admin.nama_admin
                              WHERE peminjaman.nisn = '$akunMember' AND (peminjaman.status = 'Konfirmasi' OR peminjaman.status = 'Belum konfirmasi')");

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
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
    <h5 class="container text-left" style="font-family: 'Comic Sans MS', sans-serif; font-weight: bold; color: dark;">
      sastra mesin<img src="../../assets/header.png" alt="Logo" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
    </h5>

    <!-- Move dropdown button inside the navbar -->
    <div class="navbar-nav dropdown">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-light rounded-circle" onclick="showDropdownMenu()">
        <img src="../../assets/memberLogo.png" alt="memberLogo" width="30px">
      </button>
    </div>

    <!-- Modal -->
    <div id="dropdownMenu" class="modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: 1px solid black;">
          <div class="modal-header" style="border-bottom: 1px solid black; border-radius: 10px; margin-top: -10px;">
            <button type="button" class="btn-close" onclick="hideDropdownMenu()" aria-label="Close"></button>
            <div class="container text-center text-dark" style="font-family: 'times new roman', sans-serif; font-size: 1.5rem;margin-top: 20px;">Menu Pilihan</div>
          </div>
          <div class="modal-body">
            <!-- Dropdown menu items -->
            <a href="Transaksipeminjaman.php" class="btn btn-success w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Peminjaman</a>
            <a class="btn btn-warning w-100 mb-2 text-light rounded-3" href="Transaksipengembalian.php" style="font-family: 'Comic Sans MS', sans-serif;">history</a>
            <a class="btn btn-danger w-100 text-light rounded-3" href="../dashboardMember.php" style="font-family: 'Comic Sans MS', sans-serif;">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
    <br><br><br>
<h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">Riwayat transaksi Peminjaman Buku</h1>
            <div class="container">
            <div class="alert alert-warning text-dark text-center" role="alert"><h6>JIKA BUKU BELUM TERKONFIRMASI SILAHKAN LAKUKAN PEMBAYARAN KE NOMER YANG TERTERA DI DALAM TABEL SESUAI BARIS</h6></div></div>
            <div class="container">
    <div class="table-container">
      <table class="table table-striped table-hover" width="100%">
        <thead class="text-center text-light">
          <tr>
        <th class="bg-primary text-light" width="5%">NO</th>
        <th class="bg-primary text-light">Id Buku</th>
        <th class="bg-primary text-light">Judul Buku</th>
        <th class="bg-primary text-light">Nama Siswa</th>
        <th class="bg-primary text-light" width="5%">Nama Admin</th>
        <th class="bg-primary text-light">Tanggal Peminjaman</th>
        <th class="bg-primary text-light">Tanggal Berakhir</th>
        <th class="bg-primary text-light" width="10%">Harga</th>
        <th class="bg-primary text-light" width="15%">Aksi</th>
      </tr>
      </thead>
      
      <tr>
      <?php foreach ($dataPinjam as $item) : ?>
  <?php if ($item["nisn"] == $akunMember) : ?>
    <tr>
      <td><?= $item["id_peminjaman"]; ?></td>
      <td><?= $item["id_buku"]; ?></td>
      <td><?= $item["judul"]; ?></td>
      <td><?= $item["nama"]; ?></td>
      <td><?= $item["nama_admin"]; ?></td>
      <td><?= $item["tgl_peminjaman"]; ?></td>
      <td><?= $item["tgl_pengembalian"]; ?></td>
      <td>Rp. <?= number_format($item["harga"]); ?>,-</td>
      <td>
        <div class="btn-group" role="group">
          <?php if ($item["status"] == 'Konfirmasi') : ?>
            <a class="btn btn-primary" href="bacabuku.php?pdf=<?= urlencode("../../isi-buku/" . $item["isi_buku"]); ?>">Baca Buku</a>
            <a href="pinjam.php?id=<?= $item['id_peminjaman']; ?>" class="btn btn-success">Kembalikan Buku</a>
          <?php elseif ($item["status"] == 'Belum konfirmasi') : ?>
            <?php if (!empty($item['bukti_transaksi'])) : ?>
              <button class="btn btn-secondary" disabled>Tunggu Konfirmasi</button>
            <?php else : ?>
              <a href="upload_bukti.php?id=<?= $item['id_peminjaman']; ?>" class="btn btn-warning">Pembayaran</a>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </td>
    </tr>
  <?php endif; ?>
<?php endforeach; ?>
      
    </table>
    </div>
  </div>
  
        <footer id="footer" class="p-1 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <p class="text-light"><i>Copyright © 2023 SULTHAN MADYA.</i></p>
                </div>
            </div>
        </footer>
  </body>
  <script>
  function showDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'block';
  }

  function hideDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'none';
  }
</script>
<script>
  function kembalikanBuku(idPeminjaman) {
  if (confirm("Apakah Anda yakin ingin mengembalikan buku ini?")) {
    // Kirim permintaan AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "Transaksipeminjaman.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Perbarui halaman setelah berhasil
        window.location.reload();
      }
    };
    xhr.send("id_peminjaman=" + idPeminjaman);
  }
}

</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
 