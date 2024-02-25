<?php
session_start();

if(isset($_SESSION["signIn"])) {
  header("Location: ../../DashboardAdmin/dashboardAdmin.php");
  exit;
}

require "../../loginSystem/connect.php";

// Penanganan form sign in
// Penanganan form sign in
if(isset($_POST["signIn"])) {
  $role = isset($_POST["role"]) ? $_POST["role"] : null;
  $nama = strtolower($_POST["nama_admin"]);
  $password = $_POST["password"];
  
  $result = null;
  if ($role == 'admin') {
      $result = mysqli_query($connect, "SELECT * FROM admin WHERE nama_admin = '$nama' AND password = '$password'");
  } elseif ($role == 'petugas') {
      $result = mysqli_query($connect, "SELECT * FROM admin WHERE nama_admin = '$nama' AND password = '$password'");
  }
  
  if ($result && mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      $_SESSION["signIn"] = true;
      $_SESSION["nama_admin"] = $nama; // Simpan nama_admin ke dalam session
      
      switch ($role) {
          case 'admin':
              $_SESSION["admin"] = true;
              header("Location: ../../DashboardAdmin/dashboardAdmin.php");
              break;
          case 'petugas':
              header("Location: ../../petugas/index.php");
              break;
          default:
              // Jika role tidak sesuai, arahkan ke halaman default
              header("Location: link_login.php");
              break;
      }
  
      exit;
  } else {
      $error = true; // Menandakan bahwa terjadi kesalahan saat sign in
  }
  
}


// Penanganan notifikasi logout
$logoutMessage = isset($_GET['logout']) && $_GET['logout'] == 1 ? "Anda berhasil logout" : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../assets/bootsrap/bootstrap.min.css" rel="stylesheet">
    <script src="../../assets/bootsrap/de8de52639.js"></script>
    <link rel="stylesheet" href="../../assets/style.css">
    <title>Sign In || USER</title>
    <link rel="stylesheet" href="../../assets/signuser.css">
</head>

<body>
    <!-- ... (your existing code for navigation) ... -->

    <div class="container mt-5">
        <h1 class="container text-center mb-3 header-text" style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff; position: relative;">
            <img src="../../assets/logourl.png" alt="User Logo" style="width: 24px; height: auto; position: absolute; top: 50%; transform: translateY(-50%); left: 5px;">
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
  <select class="form-control" name="role" id="role" required>
    <option value="admin">Admin</option>
    <option value="petugas">Petugas</option>
    <option value="member">Member</option>
</select>
    </div>
    <p>Username</p>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
    <input type="text" class="form-control" id="nama_admin" name="nama_admin" required>
    <div class="invalid-feedback">
        Masukkan nama anda!
    </div>
  </div>
  
  <label for="validationCustom02" class="form-label">Password</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
    <input type="password" class="form-control" id="password" name="password" required>
    <div class="invalid-feedback">
        Masukkan Password anda!
    </div>
  </div>

  <div class="btn-container">
                  <button class="btn btn-primary" type="submit" name="signIn">Sign In</button>
                    <a class="btn btn-success" href="../../index.php">Batal</a>        </div>

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
        if (this.value === 'member') {
            window.location.href = '../link_login.php';
        } else if (this.value === 'petugas') {
            window.location.href = '../petugas/sign_in.php';
        }
    });
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
