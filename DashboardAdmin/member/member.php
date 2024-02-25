<?php 
require "../../loginSystem/connect.php";
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

?>
<?php
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/admin/sign_in.php");
  exit;
}
require "../../config/config.php";

$member = queryReadData("SELECT * FROM member");

if(isset($_POST["search"]) ) {
  $member = searchMember($_POST["keyword"]);
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
     <title>Member terdaftar</title>
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
    
    <div class="p-4 mt-5">
    <h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">Halaman Data Pengguna</h1>
      <!--search engine --->
       <div class="input-group d-flex justify-content-end mb-3">
        <a class="btn btn-primary p-2" href="tambah.php">Tambah Akun</a> 
         <input class="border p-2 rounded rounded-end-0 bg-tertiary" type="text" name="keyword" id="keyword" placeholder="cari data member...">
         <button class="border border-start-0 bg-light rounded rounded-start-0" type="submit" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
       </div>
       <div class="table-responsive mt-3" style="border-radius: 30px;">
    <table class="table table-striped table-hover">
        <thead class="text-center">
            <tr>
                <th class="bg-primary text-light">Nisn</th>
                <th class="bg-primary text-light">Kode</th>
                <th class="bg-primary text-light">Nama</th>
                <th class="bg-primary text-light">Jenis Kelamin</th>
                <th class="bg-primary text-light">Kelas</th>
                <th class="bg-primary text-light">Jurusan</th>
                <th class="bg-primary text-light">No Telepon</th>
                <th class="bg-primary text-light">Pendaftaran</th>
                <th class="bg-primary text-light">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($member as $item) : ?>
            <tr>
                <td><?=$item["nisn"];?></td>
                <td><?=$item["kode_member"];?></td>
                <td><?=$item["nama"];?></td>
                <td><?=$item["jenis_kelamin"];?></td>
                <td><?=$item["kelas"];?></td>
                <td><?=$item["jurusan"];?></td>
                <td><?=$item["no_tlp"];?></td>
                <td><?=$item["tgl_pendaftaran"];?></td>
                <td>
                    <div class="action">
                        <a href="deleteMember.php?id=<?= $item["nisn"]; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data member ?');"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
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
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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