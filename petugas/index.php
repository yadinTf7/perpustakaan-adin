<?php
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../sign/admin/sign_in.php");
  exit;
}
$namaAdmin = $_SESSION["nama_admin"]; // Ambil nilai session nama_admin
require "../config/config.php";

// Ambil data peminjaman yang belum dikonfirmasi
$query = mysqli_query($connection, "SELECT * FROM peminjaman WHERE status = 'Belum konfirmasi' AND nama_admin = '$namaAdmin'");

$peminjaman = [];
while ($data = mysqli_fetch_assoc($query)) {
  $peminjaman[] = $data;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Petugas</title>
    <link href="../assets/bootsrap/bootstrap.min.css" rel="stylesheet">
     <script src="../assets/bootsrap/de8de52639.js"></script>
     <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
    <h5 class="container text-left" style="font-family: 'Comic Sans MS', sans-serif; font-weight: bold; color: dark;">
      sastra mesin<img src="../assets/header.png" alt="Logo" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
    </h5>

    <!-- Move dropdown button inside the navbar -->
    <div class="navbar-nav dropdown">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-light rounded-circle" onclick="showDropdownMenu()">
        <img src="../assets/memberLogo.png" alt="memberLogo" width="30px">
      </button>
    </div>    <!-- Modal -->
    <div id="dropdownMenu" class="modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: 1px solid black;">
          <div class="modal-header" style="border-bottom: 1px solid black; border-radius: 10px; margin-top: -10px;">
            <button type="button" class="btn-close" onclick="hideDropdownMenu()" aria-label="Close"></button>
            <div class="container text-center text-dark" style="font-family: 'times new roman', sans-serif; font-size: 1.5rem;margin-top: 20px;">Menu Pilihan</div>
          </div>
          <div class="modal-body">
            <!-- Dropdown menu items -->
            <a class="btn btn-danger w-100 text-light rounded-3" href="signOut.php" style="font-family: 'Comic Sans MS', sans-serif;">Keluar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
<br><br><br>
<h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">Konfirmasi Peminjaman</h1>
            <div class="container">
        <div class="table-responsive mt-3" style="border-radius: 30px;">
        <table class="table table-striped table-hover">
        <thead>
                <tr>
                    <th class="text-center">No. Pembelian</th>
                    <th class="text-center">ID Buku</th>
                    <th class="text-center">NISN</th>
                    <th class="text-center">Tanggal Peminjaman</th>
                    <th class="text-center">Tanggal Pengembalian</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <?php foreach ($peminjaman as $data): ?>
  <tr>
    <td class="text-center"><?= $data["id_peminjaman"]; ?></td>
    <td class="text-center"><?= $data["id_buku"]; ?></td>
    <td class="text-center"><?= $data["nisn"]; ?></td>
    <td class="text-center"><?= $data["tgl_peminjaman"]; ?></td>
    <td class="text-center"><?= $data["tgl_pengembalian"]; ?></td>
    <td class="text-center" class="text-center">  
      <?php if ($data['bukti_transaksi']) : ?>
    <img src="../uploads/<?= $data['bukti_transaksi']; ?>" alt="Bukti Transaksi" style="max-width: 100px;">
  <?php else : ?>
    <i>Belum Upload Bukti</i>
  <?php endif; ?></td>
    <td class="text-center">
    <div class="btn-group" role="group">
    <?php if ($data['bukti_transaksi']) : ?>
  <a href="konfirmasi_peminjaman.php?id=<?= $data['id_peminjaman']; ?>" class="btn btn-success" onclick="return confirm('Yakin Bukti Sudah Benar ?');">Konfirmasi </a> 
  <?php else : ?>
    <button disabled href="konfirmasi_peminjaman.php?id=<?= $data['id_peminjaman']; ?>" class="btn btn-success">Konfirmasi </button> 
    <?php endif; ?>
    <form action="" method="post">
    <input type="hidden" name="id_peminjaman" value="<?= $data["id_peminjaman"]; ?>">
    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data peminjaman?');">Tidak Sesuai</button>
  </form>
  </div>
</td>

  </tr>
<?php endforeach; ?>
            </tbody>
        </table>

    </div>
        <footer id="footer" class="p-1 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <p class="text-light"><i>Copyright © 2023 SULTHAN MADYA.</i></p>
                </div>
            </div>
        </footer>
        <?php
// ...
if (isset($_POST['delete'])) {
  $idPeminjaman = $_POST['id_peminjaman'];
  $query = "DELETE FROM peminjaman WHERE id_peminjaman = $idPeminjaman";
  mysqli_query($connection, $query);
  header("Location: index.php");
  exit;
}
?>
    <script>
  function showDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'block';
  }

  function hideDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'none';
  }
</script>
</body>
</html>
