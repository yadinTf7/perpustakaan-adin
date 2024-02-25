<?php
require "../../config/config.php";
// Ambil data dari url
$review = $_GET["idReview"];
$reviewData = queryReadData("SELECT * FROM buku WHERE id_buku = '$review'")[0];

// ==== FASE PERCOBAAN DEBUGGING =====
/*
$reviewKategori = queryReadData("SELECT * FROM buku WHERE kategori = '$review'");
*/
// Data kategori buku
$kategori = queryReadData("SELECT * FROM kategori_buku"); 

if(isset($_POST["update"]) ) {
  
  if(updateBuku($_POST) > 0) {
    echo "<script>
    alert('Data buku berhasil diupdate!');
    document.location.href = '../dashboardAdmin.php';
    </script>";
  }else {
    echo "<script>
    alert('Data buku gagal diupdate!');
    </script>";
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
     <link rel="stylesheet" href="../../assets/style.css">
     <title>Edit data buku || Admin</title>
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
            <a href="../member/member.php" class="btn btn-primary w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Member</a>
            <a href="../buku/tambahBuku.php" class="btn btn-info w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Tambah Buku</a>
            <a href="../petugas.php" class="btn btn-warning w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Admin</a>
            <a class="btn btn-danger w-100 text-light rounded-3" href="../dashboardAdmin.php" style="font-family: 'Comic Sans MS', sans-serif;">kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav><br><br>
    <h1 class="container text-center header-text" style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">Form Edit buku</h1>
<div class="container text-light d-flex justify-content-center">


      <div class="custom-container" style="height:65vh;">

      
      <form action="" method="post" enctype="multipart/form-data" class="">

      <div class="custom-css-form">
        <div class="mb-3">
          <input type="hidden" name="coverLama" value="<?= $reviewData["cover"];?>">
          <img src="../../imgDB/<?= $reviewData["cover"]; ?>" width="80px" height="80px">
          <label for="formFileMultiple" class="form-label">Cover Buku</label>
          <input class="form-control" type="file" name="cover" id="formFileMultiple">
          </div>

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Id Buku</label>
          <input type="text" class="form-control" name="id_buku" id="exampleFormControlInput1" placeholder="example inf01" value="<?= $reviewData["id_buku"]; ?>">
        </div>
      </div>
    
      <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupSelect01">Kategori</label>
        <select class="form-select" id="inputGroupSelect01" name="kategori">
          <option selected><?= $reviewData["kategori"]; ?></option>
          <?php foreach ($kategori as $item) : ?>
          <option><?= $item["kategori"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
        
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
          <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Buku" aria-label="Username" aria-describedby="basic-addon1" value="<?= $reviewData["judul"]; ?>">
          </div>
        
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Pengarang</label>
          <input type="text" class="form-control" name="pengarang" id="exampleFormControlInput1" placeholder="nama pengarang"  value="<?= $reviewData["pengarang"]; ?>">
        </div>

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Penerbit</label>
          <input type="text" class="form-control" name="penerbit" id="exampleFormControlInput1" placeholder="nama penerbit"   value="<?= $reviewData["penerbit"]; ?>">
        </div>
        
        <label for="validationCustom01" class="form-label">Tahun Terbit</label>
        <div class="input-group mt-0">
          <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
          <input type="date" class="form-control" name="tahun_terbit" id="validationCustom01"  value="<?= $reviewData["tahun_terbit"]; ?>">
          </div>
          
        <label for="validationCustom01" class="form-label">Jumlah Halaman</label>
        <div class="input-group mt-0">
          <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book-open"></i></span>
          <input type="number" class="form-control" name="jumlah_halaman" id="validationCustom01"  value="<?= $reviewData["jumlah_halaman"]; ?>">
          </div>
        
        <div class="form-floating mt-3 mb-3">
          <textarea class="form-control" placeholder="sinopsis tentang buku ini" name="buku_deskripsi" id="floatingTextarea2" style="height: 100px"><?= $reviewData["buku_deskripsi"]; ?></textarea>
          <label for="floatingTextarea2">Sinopsis</label>
          </div>
          
      <button class="btn btn-success" type="submit" name="update">Edit</button>
      <a class="btn btn-danger" href="../dashboardAdmin.php">Batal</a>
      </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>