<?php
require_once "../config/config.php";
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

// Mendapatkan data terakhir dari tabel admin
$query = mysqli_query($conn, "SELECT * FROM admin ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_assoc($query);
$lastAdminNumber = 0;

if ($data) {
    $lastKodeAdmin = $data['kode_admin'];
    $lastAdminNumber = intval(substr($lastKodeAdmin, 5)); // Ambil angka terakhir dari kode admin
}

// Ambil data terakhir dari tabel petugas
$queryPetugas = mysqli_query($conn, "SELECT * FROM admin WHERE sebagai = 'petugas' ORDER BY id DESC LIMIT 1");
$dataPetugas = mysqli_fetch_assoc($queryPetugas);
$lastPetugasNumber = 0;

if ($dataPetugas) {
    $lastKodePetugas = $dataPetugas['kode_admin'];
    $lastPetugasNumber = intval(substr($lastKodePetugas, 7)); // Ambil angka terakhir dari kode petugas
}

// Jika belum ada data admin, kode admin dimulai dari 1
if ($lastAdminNumber == 0) {
    $lastAdminNumber = 1;
}

// Jika belum ada data petugas, kode petugas dimulai dari 1
if ($lastPetugasNumber == 0) {
    $lastPetugasNumber = 1;
}
$admin = queryReadData("SELECT * FROM admin");

if(isset($_POST["signup"])) {
    // Ambil data yang dikirimkan melalui form
    $nama_admin = $_POST['nama_admin'];
    $password = $_POST['password'];
    $kode_admin = $_POST['kode_admin'];
    $no_tlp = $_POST['no_tlp'];
    $sebagai = $_POST['sebagai'];

    // Tentukan kode admin berdasarkan peran yang dipilih
    if ($sebagai === "admin") {
        $lastAdminNumber++; // Tambahkan 1 untuk mendapatkan nilai baru
        $kode_admin = "admin" . $lastAdminNumber;
    } elseif ($sebagai === "petugas") {
        $lastPetugasNumber++; // Tambahkan 1 untuk mendapatkan nilai baru
        $kode_admin = "petugas" . $lastPetugasNumber;
    }

    // Query untuk menambahkan petugas ke dalam tabel admin
    $sql = "INSERT INTO admin (nama_admin, password, kode_admin, no_tlp, sebagai) 
            VALUES ('$nama_admin', '$password', '$kode_admin', '$no_tlp','$sebagai')";

    // Jalankan query
    if (mysqli_query($connection, $sql)) {
        // Jika query berhasil dijalankan, arahkan kembali ke halaman tambah petugas dengan pesan sukses
        header("Location: petugas.php?status=success");
        exit();
    } else {
        // Jika terjadi kesalahan, arahkan kembali ke halaman tambah petugas dengan pesan error
        header("Location: petugas.php?status=error");
        exit();
    }
}
// Tutup connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootsrap/bootstrap.min.css" crossorigin="anonymous">
    <script src="../assets/bootsrap/de8de52639.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Sign In || Admin</title>
    <link rel="stylesheet" href="../assets/signuser.css">
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
            <a href="member/member.php" class="btn btn-primary w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Member</a>
            <a href="buku/tambahBuku.php" class="btn btn-info w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Tambah Buku</a>
            <a href="petugas.php" class="btn btn-warning w-100 mb-2 text-light rounded-3" style="font-family: 'Comic Sans MS', sans-serif;">Admin</a>
            <a class="btn btn-danger w-100 text-light rounded-3" href="dashboardAdmin.php" style="font-family: 'Comic Sans MS', sans-serif;">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav><br><br>
    <div class="container mt-5">
        <h1 class="container text-center mb-3 header-text" style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff; position: relative;">
            <img src="../assets/logourl.png" alt="User Logo" style="width: 24px; height: auto; position: absolute; top: 50%; transform: translateY(-50%); left: 5px;">
            <span style="position: relative; top: 50%; transform: translateY(-50%); margin-left: 30px;">DAFTAR AKUN PENGGUNA</span>
        </h1>
        <div class="table-responsive mt-3" style="border-radius: 30px;">
    <table class="table table-striped table-hover">
        <thead class="text-center">
            <tr>
                <th>ID Admin</th>
                <th>Nama Lengkap</th>
                <th>Password</th>
                <th>Kode</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admin as $data): ?>
            <tr>
                <td><?= $data["id"]; ?></td>
                <td><?= $data["nama_admin"]; ?></td>
                <td><?= $data["password"]; ?></td>
                <td><?= $data["kode_admin"]; ?></td>
                <td><?= $data["no_tlp"]; ?></td>
                <td><?= $data["sebagai"]; ?></td>
                <td><a href="deletepetugas.php?id=<?= $data["id"]; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data member ?');"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


        <div class="card text-light" style="font-family: 'Comic Sans MS', sans-serif; font-weight: lite; color: dark; overflow-y: auto; max-height: 70vh;">
                <form action="" class="row g-3 p-4 needs-validation" method="POST">
                    
            <div class="form-group">
                <label for="nama_admin">Nama Petugas:</label>
                <input type="text" class="form-control" id="nama_admin" name="nama_admin" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="col input-group mb-2">
  <label class="input-group-text" for="sebagai">Sebagai :</label>
  <select class="form-select" id="sebagai" name="sebagai">
    <option selected>Choose</option>
    <option value="admin">admin</option>
    <option value="petugas">petugas</option>
    </select>
  </div>
            <div class="form-group">
                <label for="kode_admin">Kode Admin:</label>
                <input type="text" disabled class="form-control" id="kode_admin" name="kode_admin" required>
            </div>
            <div class="form-group">
                <label for="no_tlp">Nomor Telepon:</label>
                <input type="text" class="form-control" id="no_tlp" name="no_tlp" required>
            </div>
            
            <div class="form-group">
            <button type="submit" name="signup" class="btn btn-primary">Tambah Petugas</button>
        </form>
    </div>
    <script>
  function showDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'block';
  }

  function hideDropdownMenu() {
    document.getElementById('dropdownMenu').style.display = 'none';
  }
</script>
<script>
var lastAdminNumber = <?php echo $lastAdminNumber; ?>; // Angka terakhir untuk admin
    var lastPetugasNumber = <?php echo $lastPetugasNumber; ?>; // Angka terakhir untuk petugas

    document.getElementById("sebagai").addEventListener("change", function() {
        var selectedRole = this.value; // Mendapatkan peran yang dipilih dari select
        var kodeAdmin = document.getElementById("kode_admin");
        if (selectedRole === "admin") {
            lastAdminNumber++; // Tambahkan 1 untuk mendapatkan nilai baru
            kodeAdmin.value = "admin" + lastAdminNumber;
        } else if (selectedRole === "petugas") {
            lastPetugasNumber++; // Tambahkan 1 untuk mendapatkan nilai baru
            kodeAdmin.value = "petugas" + lastPetugasNumber;
        }
    });
</script>
</body>
</html>
