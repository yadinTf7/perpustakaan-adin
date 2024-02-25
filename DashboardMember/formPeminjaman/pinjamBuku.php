<?php 
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/link_login.php");
  exit;
}
require "../../config/config.php";
// Tangkap id buku dari URL (GET)
$idBuku = $_GET["id"];
$query = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");
//Menampilkan data siswa yg sedang login
$nisnSiswa = $_SESSION["member"]["nisn"];
$dataSiswa = queryReadData("SELECT * FROM member WHERE nisn = $nisnSiswa");
$admin = queryReadData("SELECT * FROM admin WHERE sebagai = 'petugas'");
// Peminjaman 
if(isset($_POST["pinjam"])) {
  $result = pinjamBuku($_POST);
  if ($result > 0) {
      echo "<script>
      alert('Buku berhasil diajukan. Silakan Belum konfirmasi dari petugas.');
      </script>";
  } else {
      echo "<script>
      alert('Buku gagal diajukan!');
      </script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../assets/bootsrap/bootstrap.min.css" crossorigin="anonymous">
    <script src="../../assets/bootsrap/de8de52639.js" crossorigin="anonymous"></script>
    <title>Aksara Sastra - Dashboard</title>
    <link rel="icon" href="../../assets/memberLogo.png" type="image/png">
    <link rel="stylesheet" href="../../assets/style.css">
    <style>@media (max-width: 767px) {
    .container.d-flex {
        display: block !important; /* Mengubah display menjadi block pada layar kecil */
    }
}
</style>
    <link rel="stylesheet" href="../../assets/index.css">
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
            <a class="btn btn-danger w-100 text-light rounded-3" href="../dashboardMember.php" style="font-family: 'Comic Sans MS', sans-serif;">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
    
  <div class="p-4 mt-5">
  <h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">Form Peminjaman Buku</h1>
  
            
            <div class="container d-flex justify-content-between">
        <div class="custom-container flex-column show-custom-container">


      <div class="card-body d-flex flex-wrap gap-1 justify-content-center">
          <?php foreach ($query as $item) : ?>
        <p class="card-text"><img src="../../imgDB/<?= $item["cover"]; ?>" width="180px" height="185px" style="border-radius: 5px;"></p>
        <form action="" method="post">
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Id Buku</span>
            <input type="text" class="form-control" placeholder="id buku" aria-label="Username" aria-describedby="basic-addon1" value="<?= $item["id_buku"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Kategori</span>
            <input type="text" class="form-control" placeholder="kategori" aria-label="kategori" aria-describedby="basic-addon1" value="<?= $item["kategori"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Judul</span>
            <input type="text" class="form-control" placeholder="judul" aria-label="judul" aria-describedby="basic-addon1" value="<?= $item["judul"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Pengarang</span>
            <input type="text" class="form-control" placeholder="pengarang" aria-label="pengarang" aria-describedby="basic-addon1" value="<?= $item["pengarang"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Penerbit</span>
            <input type="text" class="form-control" placeholder="penerbit" aria-label="penerbit" aria-describedby="basic-addon1" value="<?= $item["penerbit"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Tahun Terbit</span>
            <input type="date" class="form-control" placeholder="tahun_terbit" aria-label="tahun_terbit" aria-describedby="basic-addon1" value="<?= $item["tahun_terbit"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Jumlah Halaman</span>
            <input type="number" class="form-control" placeholder="jumlah halaman" aria-label="jumlah halaman" aria-describedby="basic-addon1" value="<?= $item["jumlah_halaman"]; ?>" readonly>
            </div>
          <div class="form-floating">
            <textarea class="form-control" placeholder="deskripsi singkat buku" id="floatingTextarea2" style="height: 100px" readonly><?= $item["buku_deskripsi"]; ?></textarea>
            <label for="floatingTextarea2">Deskripsi Buku</label>
            </div>
        <?php endforeach; ?>
        </form>

        </div></div>
            <div class="container custom-container flex-column show-custom-container">



      <div class="card-body d-flex flex-wrap gap-1 justify-content-center">
        <p><img src="../../assets/memberLogo.png" width="150px"></p>
        <form action="" method="post">
          <?php foreach ($dataSiswa as $item) : ?>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nisn</span>
            <input type="number" class="form-control" placeholder="nisn" aria-label="nisn" aria-describedby="basic-addon1" value="<?= $item["nisn"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Kode Member</span>
            <input type="text" class="form-control" placeholder="kode member" aria-label="kode member" aria-describedby="basic-addon1" value="<?= $item["kode_member"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nama</span>
            <input type="text" class="form-control" placeholder="nama" aria-label="nama" aria-describedby="basic-addon1" value="<?= $item["nama"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Jenis Kelamin</span>
            <input type="text" class="form-control" placeholder="jenis kelamin" aria-label="jenis kelamin" aria-describedby="basic-addon1" value="<?= $item["jenis_kelamin"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Kelas</span>
            <input type="text" class="form-control" placeholder="kelas" aria-label="kelas" aria-describedby="basic-addon1" value="<?= $item["kelas"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Jurusan</span>
            <input type="text" class="form-control" placeholder="jurusan" aria-label="jurusan" aria-describedby="basic-addon1" value="<?= $item["jurusan"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">No Tlp</span>
            <input type="no_tlp" class="form-control" placeholder="no tlp" aria-label="no tlp" aria-describedby="basic-addon1" value="<?= $item["no_tlp"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Tanggal Daftar</span>
            <input type="date" class="form-control" placeholder="tgl_pendaftaran" aria-label="tgl_pendaftaran" aria-describedby="basic-addon1" value="<?= $item["tgl_pendaftaran"]; ?>" readonly>
            </div>
        <?php endforeach; ?>
        </form>
       </div>
       </div>

            <div class="container custom-container flex-column show-custom-container">


      <div class="card-body">
        <form action="" method="post">
          <!--Ambil data id buku-->
          <?php foreach ($query as $item) : ?>
           <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Id Buku</span>
            <input type="text" name="id_buku" class="form-control" placeholder="id buku" aria-label="id_buku" aria-describedby="basic-addon1" value="<?= $item["id_buku"]; ?>" readonly>
            </div>
          <?php endforeach; ?>
        <!-- Ambil data NISN user yang login-->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nisn</span>
            <input type="number" name="nisn" class="form-control" placeholder="nisn" aria-label="nisn" aria-describedby="basic-addon1" value="<?php echo htmlentities($_SESSION["member"]["nisn"]); ?>" readonly>
        </div>
    <!--Ambil data id admin-->
    <div class="input-group mb-3 mt-3">
    <span class="input-group-text" id="basic-addon1">Nama Admin</span>
    <select name="nama_admin" id="nama_admin" class="form-select" aria-label="Default select example" placeholder="Choose" required>
  <option disabled selected>-- Pilih admin --</option>
  <?php foreach ($admin as $item) : ?>
    <?php if ($item["sebagai"] == "petugas") : ?>
      <option value="<?= $item["nama_admin"]; ?>"><?= $item["nama_admin"]; ?></option>
    <?php endif; ?>
  <?php endforeach; ?>
</select>

<div class="input-group mb-3 mt-3">
  <span class="input-group-text" id="basic-addon1">Telpon admin</span>
  <input type="number" name="no_tlp" id="no_tlp" class="form-control" placeholder="No. Telepon" aria-label="No. Telepon" aria-describedby="basic-addon1" readonly>
</div>

<div class="input-group mb-3 mt-1">
    <span class="input-group-text" id="basic-addon1">Paket</span>
    <select class="form-select" aria-label="Default select example" name="paket" id="paket" onchange="setReturnDate(this)" required>
        <option disabled selected>-- Pilih paket --</option>
        <option value="1">Paket 1</option>
        <option value="2">Paket 2</option>
        <option value="3">Paket 3</option>
        <option value="">Non Paket</option>
    </select>
</div>
<div class="input-group mb-3 mt-1">
    <span class="input-group-text" id="basic-addon1">Tanggal Pinjam</span>
    <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control" placeholder="Tanggal Pinjam" aria-label="tgl_peminjaman" aria-describedby="basic-addon1" required>
</div>
<div class="input-group mb-3 mt-1">
    <span class="input-group-text" id="basic-addon1">Tenggat Pengembalian</span>
    <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control" placeholder="Tenggat Pengembalian" aria-label="tgl_pengembalian" aria-describedby="basic-addon1" required>
</div>

<div class="input-group mb-3 mt-1">
    <span class="input-group-text" id="basic-addon1">Harga</span>
    <input type="text" id="harga" name="harga" class="form-control"  placeholder="Harga" aria-label="Harga" aria-describedby="basic-addon1" readonly>
</div>

    <a class="btn btn-danger" href="../dashboardMember.php"> Batal</a>
    <button type="submit" class="btn btn-success" name="pinjam">Pinjam</button>
    </form>
            </div>
        </div>
    </div>
</div>

    
    <footer id="footer" class="p-1 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <p class="text-light"><i>Copyright © 2023 SULTHAN MADYA. All Rights Reserved</i></p>
                </div>
            </div>
        </footer>
    
    <!--JAVASCRIPT -->
    <script src="../../style/js/script.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
function setReturnDate() {
    const currentDate = new Date();
    let returnDate = new Date();

    const selectedPackage = document.getElementById('paket').value;
    let daysToAdd = 1; // Default return date if no package is selected

    // Adjust days to add based on the selected package
    switch (selectedPackage) {
        case "1":
            daysToAdd = 5; // Change to the duration of Paket 1
            break;
        case "2":
            daysToAdd = 7; // Change to the duration of Paket 2
            break;
        case "3":
            daysToAdd = 10; // Change to the duration of Paket 3
            break;
        default:
            daysToAdd = 1; // Default return date if no package is selected
    }

    returnDate.setDate(currentDate.getDate() + daysToAdd);

    // Format tanggal untuk input HTML
    const formattedReturnDate = returnDate.toISOString().split('T')[0];
    document.getElementById('tgl_pengembalian').value = formattedReturnDate; // Mengubah value langsung ke input tgl_pengembalian

    setPrice(); // Call setPrice() after setting return date

    // Enable or disable tgl_pengembalian input based on whether a package is selecte
}
        function setPrice() {
            const priceInput = document.getElementsByName('harga')[0];
            const isPackageSelected = document.getElementById('paket').value !== ""; // Check if a package is selected

            // Get the selected dates
            const tglPinjam = new Date(document.getElementById('tgl_peminjaman').value);
            const tgl = new Date(document.getElementById('tgl_pengembalian').value);

            // Get the difference in days between tgl_peminjaman and tgl_pengembalian
            const diffTime = Math.abs(tgl - tglPinjam);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            let pricePerDay;

            if (isPackageSelected) {
                // Adjust price calculation based on package selection
                const selectedPackage = parseInt(document.getElementById('paket').value);
                // Assuming different packages have different prices
                // You can set prices based on the selected package
                // Here, we are just setting some arbitrary values
                switch (selectedPackage) {
                    case 1:
                        pricePerDay = 1000; // Price for Paket 1
                        break;
                    case 2:
                        pricePerDay = 900; // Price for Paket 2
                        break;
                    case 3:
                        pricePerDay = 800; // Price for Paket 3
                        break;
                    default:
                        pricePerDay = 1250; // Default price if no package selected
                }
            } else {
                // If no package is selected, set default price per day
                pricePerDay = 1250; // Default price per day for non-package
            }

            // Calculate total price
            const totalPrice = diffDays * pricePerDay;
            priceInput.value = totalPrice;
        }

        // Fungsi untuk mengatur tanggal pinjam dengan hari ini
        function setTodayDate() {
            const todayDateInput = document.getElementById('tgl_peminjaman');
            const currentDate = new Date();

            // Format tanggal untuk input HTML
            const formattedTodayDate = currentDate.toISOString().split('T')[0];
            todayDateInput.value = formattedTodayDate;

            setReturnDate(); // Call setReturnDate() after setting today's date
        }

        // Panggil fungsi setTodayDate saat halaman dimuat
        window.onload = function() {
            setTodayDate();
        };

        // Panggil setPrice() saat tgl_peminjaman atau tgl_pengembalian berubah
        document.getElementById('tgl_peminjaman').addEventListener('change', setPrice);
        document.getElementById('tgl_pengembalian').addEventListener('change', setPrice);

        // Validasi tanggal tenggat pengembalian
        document.getElementById('tgl_pengembalian').addEventListener('change', function() {
            var tglPinjam = document.getElementById('tgl_peminjaman').value;
            var tglPengembalian = this.value;

            // Bandingkan tanggal tenggat pengembalian dengan tanggal pinjam
            if (tglPengembalian <= tglPinjam) {
                alert('Tanggal tenggat pengembalian tidak boleh sebelum atau sama dengan tanggal pinjam');
                this.value = '';
            }
        });
</script>
<script>
  document.getElementById('nama_admin').addEventListener('change', function() {
    var nama_admin = this.value; 
    var adminData = <?= json_encode($admin); ?>; 

    for (var i = 0; i < adminData.length; i++) {
      if (adminData[i].nama_admin === nama_admin) {
        document.getElementById('no_tlp').value = adminData[i].no_tlp;
        break; 
      }
    }
  });
</script>
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
