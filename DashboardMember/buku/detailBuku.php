<?php 
require "../../config/config.php";
$idBuku = $_GET["id"];
$query = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../assets/bootsrap/bootstrap.min.css" rel="stylesheet">
     <script src="../../assets/bootsrap/de8de52639.js"></script>
     <link rel="stylesheet" href="../../assets/style.css">
     <title>Detail Buku || Member</title>
    <link rel="stylesheet" href="../../assets/detail.css">
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
            <a href="formPeminjaman/pinjamBuku.php" class="btn btn-success w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Peminjaman</a>
            <a href="pengembalian/pengembalianBuku.php" class="btn btn-warning w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">pengembalian</a>
            <a class="btn btn-danger w-100 text-light rounded-3" href="../dashboardMember.php" style="font-family: 'Comic Sans MS', sans-serif;">Keluar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav><br><br><br>
  <h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">DETAIL BUKU</h1>
            
    <div class="d-flex justify-content-center">
    <div class="card container-fluid overflow-scroll" style="width: 18rem;height: auto;">

      <?php foreach ($query as $item) : ?>
  <img src="../../imgDB/<?= $item["cover"]; ?>"  alt="coverBuku" height="250vh">
  <div class="card-body">
    <h5 class="card-title"><?= $item["judul"]; ?></h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Id Buku : <?= $item["id_buku"]; ?></li>
    <li class="list-group-item">Kategori : <?= $item["kategori"]; ?></li>
    <li class="list-group-item">Pengarang : <?= $item["pengarang"]; ?></li>
    <li class="list-group-item">Penerbit : <?= $item["penerbit"]; ?></li>
    <li class="list-group-item">Tahun terbit : <?= $item["tahun_terbit"]; ?></li>
    <li class="list-group-item">Jumlah halaman : <?= $item["jumlah_halaman"]; ?></li>
    <li class="list-group-item">Deskripsi buku : <?= $item["buku_deskripsi"]; ?></li>
  </ul>
  <?php endforeach; ?>
  <div class="card-body">
    <a href="../dashboardMember.php" class="btn btn-danger">Batal</a>
     <a href="../formPeminjaman/pinjamBuku.php?id=<?= $item["id_buku"]; ?>" class="btn btn-success">Pinjam</a>
     </div>
    </div>
   </div>
  </div>
  
  <footer id="footer" class="p-1 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <p class="text-light"><i>Copyright © 2023 SULTHAN MADYA.</i></p>
                </div>
            </div>
        </footer>
  <script>
  function showDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'block';
  }

  function hideDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'none';
  }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>