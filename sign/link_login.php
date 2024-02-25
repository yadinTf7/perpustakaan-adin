<?php 
session_start();

//Jika member sudah login, tidak boleh kembali ke halaman login ,kecuali logout
if(isset($_SESSION["signIn"]) ) {
  header("Location: ../DashboardMember/dashboardMember.php");
  exit;
}

require "../loginSystem/connect.php";

if(isset($_POST["signIn"]) ) {
  
  $nama = strtolower($_POST["nama"]);
  $password = $_POST["password"];
  $role = $_POST["role"];
  
  if($role === 'member') {
    $result = mysqli_query($connect, "SELECT * FROM member WHERE nama = '$nama'");
    
    if(mysqli_num_rows($result) === 1) {
      //cek pw 
      $pw = mysqli_fetch_assoc($result);
      if(password_verify($password, $pw["password"]) ) {
        // SET SESSION 
        $_SESSION["signIn"] = true;
        $_SESSION["member"]["nama"] = $nama;
        $_SESSION["member"]["nisn"] = $pw["nisn"];
        header("Location: ../DashboardMember/dashboardMember.php");
        exit;
      }
    } else {
      $error = true; // Menandakan bahwa terjadi kesalahan saat sign in
    }
  } else {
    // Jika role bukan member, langsung arahkan ke halaman link_login.php
    header("Location: ../link_login.php");
    exit;
  }
}

// Penanganan notifikasi logout
$logoutMessage = isset($_GET['logout']) && $_GET['logout'] == 3 ? "Anda berhasil logout" : "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/bootsrap/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/bootsrap/de8de52639.js"></script>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Sign In || USER</title>
    <link rel="stylesheet" href="../assets/signuser.css">
</head>

<body>
    <!-- ... (your existing code for navigation) ... -->

    <div class="container mt-5">
        <h1 class="container text-center mb-3 header-text" style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff; position: relative;">
            <img src="../assets/logourl.png" alt="User Logo" style="width: 24px; height: auto; position: absolute; top: 50%; transform: translateY(-50%); left: 5px;">
            <span style="position: relative; top: 50%; transform: translateY(-50%); margin-left: 30px;">HALAMAN LOGIN</span>
        </h1>
        <?php if (!empty($logoutMessage)) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $logoutMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
        <div class="card text-white" style="font-family: 'Comic Sans MS', sans-serif; font-weight: lite; color: dark;">
            <h1 class="pt-3 card-header text-center fw-bold">Sign In </h1>
  
    <form action="" method="post" class="row g-3 p-4 needs-validation" novalidate>
    <?php if (isset($error) && $error) : ?>
        <div class="alert alert-danger" role="alert">
            Password atau nama pengguna salah.
        </div>
    <?php endif; ?>
    <label class="form-label">Sebagai</label>
  <div class="input-group mt-0">
  <select class="form-control" name="role" id="role">
    <option value="member">Member</option>
    <option value="admin">Admin</option>
    <option value="petugas">Petugas</option>
</select>
    </div>
    <p>Nama Lengkap</p>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
    <input type="text" class="form-control" name="nama" required>
    <div class="invalid-feedback">
        Masukkan nama anda!
    </div>
  </div>
  
  <label for="validationCustom02" class="form-label">Password</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
    <input type="password" class="form-control" id="validationCustom02" name="password" required>
    <div class="invalid-feedback">
        Masukkan Password anda!
    </div>
  </div>

  <div class="btn-container">
                  <button class="btn btn-primary" type="submit" name="signIn">Sign In</button>
                    <a class="btn btn-success" href="../link_login.php">Batal</a>        </div>
  <p>Don't have an account yet? <a href="admin/sign_up.php" class="text-decoration-none text-primary">Sign Up</a></p>
</form>
</div>
<?php if(isset($error)) : ?>
      <div class="alert alert-danger mt-2" role="alert">Nama / Nisn / Password tidak sesuai !
      </div>
    <?php endif; ?>
</div>

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
<script>
    document.getElementById('role').addEventListener('change', function() {
        if (this.value === 'admin') {
            window.location.href = 'admin/sign_in.php';
        } else if (this.value === 'petugas') {
            window.location.href = 'petugas/sign_in.php';
        }
    });
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
