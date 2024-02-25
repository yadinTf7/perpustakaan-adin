<?php 
require "../../loginSystem/connect.php";
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");
function getLastMemberCode()
{
    global $conn;

    $query = "SELECT kode_member FROM member ORDER BY nisn DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle query execution error
        echo "Error: " . mysqli_error($conn);
        return null;
    }

    $row = mysqli_fetch_assoc($result);
    if ($row === null) {
        // Handle no rows returned
        return null;
    }
    
    return $row['kode_member'];
}


// Fungsi untuk menghasilkan kode member berikutnya
function generateNextMemberCode($lastCode)
{
    // Jika tidak ada kode member sebelumnya, atur sebagai "mem01"
    if (!$lastCode) {
        return "mem01";
    }

    // Ambil angka dari kode member sebelumnya, tambahkan 1, dan format ulang
    $lastNumber = intval(substr($lastCode, 3));
    $nextNumber = $lastNumber + 1;

    // Cek apakah kode member baru sudah digunakan, jika ya, iterasikan hingga menemukan yang belum digunakan
    while (codeExists("mem" . sprintf("%02d", $nextNumber))) {
        $nextNumber++;
    }

    return "mem" . sprintf("%02d", $nextNumber);
}

// Fungsi untuk memeriksa apakah suatu kode member sudah ada atau belum
function codeExists($code)
{
    global $conn;

    $query = "SELECT COUNT(*) as count FROM member WHERE kode_member = '$code'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    } else {
        return false;
    }
}

// Ambil kode member terakhir dari database
$lastMemberCode = getLastMemberCode();

// Check if $lastMemberCode is null before using it
if ($lastMemberCode !== null) {
    // Generate kode member berikutnya
    $nextMemberCode = generateNextMemberCode($lastMemberCode);
} else {
    // If there is no last member code, set it to "mem01"
    $nextMemberCode = "mem01";
}

if(isset($_POST["signUp"]) ) {
  
  if(signUp($_POST) > 0) {
    echo "<script>
    alert('Sign Up berhasil!')
    </script>";
  }else {
    echo "<script>
    alert('Sign Up gagal!')
    </script>";
  }
  
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../assets/bootsrap/bootstrap.min.css" crossorigin="anonymous">
    <script src="../../assets/bootsrap/de8de52639.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Sign In || Admin</title>
    <link rel="stylesheet" href="../../assets/signuser.css">
  </head>

<body>
    <!-- ... (your existing code for navigation) ... -->

    <div class="container mt-5">
        <h1 class="container text-center mb-3 header-text" style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff; position: relative;">
            <img src="../../assets/logourl.png" alt="User Logo" style="width: 24px; height: auto; position: absolute; top: 50%; transform: translateY(-50%); left: 5px;">
            <span style="position: relative; top: 50%; transform: translateY(-50%); margin-left: 30px;">DAFTAR AKUN PENGGUNA</span>
        </h1>

        <div class="card text-white" style="font-family: 'Comic Sans MS', sans-serif; font-weight: lite; color: dark; overflow-y: auto; max-height: 80vh;">
  
    <form action="" method="post" class="row g-3 p-4 needs-validation" novalidate>
    <label for="validationCustom01" class="form-label">Nisn</label>
    <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-hashtag"></i></span>
    <input type="number" class="form-control" name="nisn" id="validationCustom01" required>
    <div class="invalid-feedback">
        Nisn wajib diisi!
    </div>
  </div>
    <label for="validationCustom01" class="form-label">Kode Member</label>
  <div class="input-group mt-0">
    <input type="text" value="<?php echo $nextMemberCode; ?>" class="form-control" name="kode_member" id="validationCustom01" required>
    <div class="invalid-feedback">
        Kode member wajib diisi!
    </div>
  </div>
  <label for="validationCustom02" class="form-label">Nama Lengkap</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
    <input type="text" class="form-control" id="validationCustom02" name="nama" required>
    <div class="invalid-feedback">
        Nama wajib diisi!
    </div>
  </div>
  <label for="validationCustom02" class="form-label">Password</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
    <input type="password" class="form-control" id="validationCustom02" name="password" required>
    <div class="invalid-feedback">
        Password wajib diisi!
    </div>
  </div>
  <label for="validationCustom02" class="form-label">Confirm Password</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
    <input type="password" class="form-control" id="validationCustom02" name="confirmPw" required>
    <div class="invalid-feedback">
        Konfirmasi password wajib diisi!
    </div>
  </div>
  
  <div class="col input-group mb-2">
  <label class="input-group-text" for="inputGroupSelect01">Gender</label>
  <select class="form-select" id="inputGroupSelect01" name="jenis_kelamin">
    <option selected>Choose</option>
    <option value="Laki laki">Laki laki</option>
    <option value="Perempuan">Perempuan</option>
    </select>
  </div>
  
  <div class="col input-group mb-2">
  <label class="input-group-text" for="inputGroupSelect01">Kelas</label>
  <select class="form-select" id="inputGroupSelect01" name="kelas">
    <option selected>Choose</option>
    <option value="X">X</option>
    <option value="XI">XI</option>
    <option value="XII">XII</option>
    <option value="XIII">XIII</option>
    </select>
  </div>
  
  <div class="input-group mb-2">
  <label class="input-group-text" for="inputGroupSelect01">Jurusan</label>
  <select class="form-select" id="inputGroupSelect01" name="jurusan">
    <option selected>Choose</option>
    <option value="Desain Gambar Mesin">Desain Gambar Mesin</option>
    <option value="Teknik Pemesinan">Teknik Pemesinan</option>
    <option value="Teknik Otomotif">Teknik Otomotif</option>
    <option value="Desain Pemodelan Informasi Bangunan">Desain Pemodelan Informasi Bangunan</option>
    <option value="Teknik Konstruksi Perumahan">Teknik Konstruksi Perumahan</option>
    <option value="Teknik Tenaga Listrik">Teknik Tenaga Listrik</option>
    <option value="Teknik Instalasi Tenaga Listrik">Teknik Instalasi Tenaga Listrik</option>
    <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
    <option value="Sistem Informatika Jaringan dan Aplikasi">Sistem Informatika Jaringan dan Aplikasi</option>
    <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
    <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
    </select>
  </div>
  
  <label for="validationCustom01" class="form-label">No Telepon</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
    <input type="number" class="form-control" name="no_tlp" id="validationCustom01" required>
    <div class="invalid-feedback">
        No telepon wajib diisi!
    </div>
  </div>
  
  <label for="validationCustom01" class="form-label">Tanggal Pendaftaran</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
    <input type="date" class="form-control" name="tgl_pendaftaran" id="validationCustom01" required>
    <div class="invalid-feedback">
        Tanggal pendaftaran wajib diisi!
    </div>
  </div>
  
  <div style="position: sticky; bottom: 0; background-color: #3333335e; padding: 10px; text-align: left; border-radius: 10px;">
    
    
    <a href="sign_in.php" class="btn btn-danger" >Kembali</a>
    <div class="tombol" style="height: 110%;display: flex;justify-content: right; margin-top: -40px; margin-left: 60%; gap: 1rem;">
    <input type="reset" class="btn btn-danger text-light" value="Reset"><button class="btn btn-primary" type="submit" name="signUp" >Sign Up</button></div>
  </div>
  
</form>
</div>
  </div>
</body>
  
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>