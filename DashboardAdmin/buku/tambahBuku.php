<?php 
require "../../config/config.php";
//$informatika = "informatika";
$kategori = queryReadData("SELECT * FROM kategori_buku");
$query = mysqli_query($connection, "SELECT max(id_buku) as kodeTerbesar FROM buku");
$dataid = mysqli_fetch_array($query);
$kodebuku = $dataid['kodeTerbesar'];
$urutan = (int) substr($kodebuku, -4, 4);
$urutan++;
$huruf = "BK";
$kodebuku = $huruf . sprintf("%04s", $urutan);
if(isset($_POST["tambah"]) ) {
  
  if(tambahBuku($_POST) > 0) {
    echo "<script>
    alert('Data buku berhasil ditambahkan');
    </script>";
    header("Location: ../dashboardAdmin.php");
    exit(); // Pastikan exit digunakan setelah header untuk menghentikan eksekusi script selanjutnya
  }else {
    echo "<script>
    alert('Data buku gagal ditambahkan!');
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
     <title>Tambah buku || Admin</title>
     <link rel="stylesheet" href="../../assets/style.css">
     <link rel="stylesheet" href="../../assets/tambahbuku.css">
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
            <a class="btn btn-danger w-100 text-light rounded-3" href="../dashboardAdmin.php" style="font-family: 'Comic Sans MS', sans-serif;">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
<br><br><br>
<div class="card">
<p class="card-title text-light text-center fw-bold" style="font-family: 'comic sans ms', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">
  <span style="position: relative; top: 50%; transform: translateY(-50%); margin-left: 30px;">Form Tambah buku</span>
</p>


      <form action="" method="post" enctype="multipart/form-data" class="mt-8 p-2">
        <div class="custom-css-form">
        <div class="mb-3">
          <label for="formFileMultiple" class="form-label text-light">Cover Buku</label>
          <input style="width: 100%;border-radius: 0 50px 50px 0;" class="form-control form-control-outline" type="file" name="cover" id="formFileMultiple" required>
          </div>

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label text-light ">Id Buku</label>
          <input type="text" class="form-control form-control-outline" name="id_buku" style="width: 100%; border-radius: 0 50px 50px 0;" id="exampleFormControlInput1" value="<?= $kodebuku; ?>"  required>
        </div>
      </div>
    
      <div class="input-group mb-3" style="border: 1px solid black; border-radius: 12px 50px 50px 12px;">
        <label class="input-group-text" for="inputGroupSelect01">Kategori</label>
        <select class="form-select" id="inputGroupSelect01" name="kategori" style="border: 1px solid black; border-radius: 0 50px 50px 0;">
          <option selected>Choose</option>
          <?php foreach ($kategori as $item) : ?>
          <option><?= $item["kategori"]; ?></option>
          <?php endforeach; ?>
          </select>
        </div>
        
        <div class="input-group mb-3" style="border: 1px solid black; border-radius: 12px 50px 50px 12px;">
          <span class="input-group-text" id="basic-addon1"><i class="text-dark fa-solid fa-book"></i></span>
          <input type="text" style="border: 1px solid black; border-radius: 12px 50px 50px 12px;" class="form-control form-control-outline" name="judul" id="judul" placeholder="Judul Buku" aria-label="Username" aria-describedby="basic-addon1" required>
          </div>
        
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="text-dark fa-solid fa-book"></i></span>
          <input type="text" style="border: 1px solid black; border-radius: 12px 50px 50px 12px;" class="form-control form-control-outline" name="pengarang" id="exampleFormControlInput1" placeholder="nama pengarang"  required>
        </div>

        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="text-dark fa-solid fa-book"></i></span>
          <input style="border: 1px solid black; border-radius: 12px 50px 50px 12px;" type="text" class="form-control form-control-outline" name="penerbit" id="exampleFormControlInput1" placeholder="nama penerbit"  required>
        </div>
        
        <label for="validationCustom01" class="form-label text-light">Tahun Terbit</label>
        <div class="input-group mt-0">
          <span class="input-group-text" id="basic-addon1"><i class="text-dark fa-solid fa-calendar-days"></i></span>
          <input style="border: 1px solid black; border-radius: 12px 50px 50px 12px;" type="date" class="form-control form-control-outline" name="tahun_terbit" id="validationCustom01" required>
          </div>
          
        <div class="input-group mt-3 mb-3">
          <span class="input-group-text" id="basic-addon1"><i class="text-dark fa-solid fa-book-open"></i></span>
          <input style="border: 1px solid black; border-radius: 12px 50px 50px 12px;" type="number" class="form-control form-control-outline" name="jumlah_halaman" id="validationCustom01" placeholder="Jumlah Halaman" required>
          </div>
        
        <div class="form-floating mt-3 mb-3">
          <textarea style="border-radius: 0 50px 50px 0;" class="form-control form-control-outline" placeholder="sinopsis tentang buku ini" name="buku_deskripsi" id="floatingTextarea2" style="height: 100px"></textarea>
          <label for="floatingTextarea2">Sinopsis</label>
          </div>
          
                <label class="form-label text-light" for="formFileMultiple">Isi Buku</label>
                <div class="input-group mb-3">
                    <input style="border: 1px solid black; border-radius: 12px 50px 50px 12px;" class="form-control form-control-outline" type="file" name="isi_buku"
                        id="formFileMultiple" required>
                </div>

<div class="btn-actions">
      <button class="btn btn-success" align="right" type="submit" name="tambah">Tambah</button>
      <input type="reset" class="btn btn-danger text-dark" value="Reset">
      </form>
         </div></div>
</div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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