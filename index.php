
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootsrap/bootstrap.min.css" crossorigin="anonymous">
    <script src="assets/bootsrap/de8de52639.js" crossorigin="anonymous"></script>
    <title>Aksara Sastra - Dashboard</title>
    <link rel="icon" href="assets/memberLogo.png" type="image/png">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .navbar-brand {
            margin-left: 15px;
            font-family: 'Pacifico', cursive;
            font-size: 24px;
        }

        .menu-button {
            background-color: transparent;
            border: none;
            font-family: 'Times New Roman', sans-serif;
            font-size: 16px;
            color: #343a40;
            cursor: pointer;
        }

        .menu-button:hover {
            color: #007bff;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #f8f9fa;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.25rem;
            padding: 0.5rem 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            display: none;
        }

        .dropdown-menu a {
            display: block;
            padding: 0.5rem 1rem;
            color: #343a40;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dropdown-menu a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .dropdown-menu.show {
            display: block;
        }

        @media (max-width: 576px) {
            .navbar {
                position: relative;
            }

            .menu-button {
                position: absolute;
                right: 0;
                top: 0;
                margin-right: 15px;
                margin-top: 8px;
            }
        }
    </style>
</head>

<body>
    <header>
        <!--Navbar-->
        <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary shadow-sm justify-content-between">
            <div class="container-fluid">
                <h5 class="container text-left"
                    style="font-family: 'Comic Sans MS', sans-serif; font-weight: bold; color: dark;">
                    sastra mesin<img src="assets/header.png" alt="Logo"
                        style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
                </h5>
                <button class="menu-button" onclick="toggleDropdownMenu()">MENU</button>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="sign/link_login.php" class="dropdown-item">Sign - In</a>
                    <a href="sign/member/sign_up.php" class="dropdown-item">Sign - Up</a>
                </div>
            </div>
        </nav>
        
    </header>
    <?php
    require "config/config.php";
    // query read semua buku
    $buku = queryReadData("SELECT * FROM buku ORDER BY id_buku DESC");
    //search buku
    if (isset($_POST["search"])) {
        $buku = search($_POST["keyword"]);
    }
    //read buku informatika
    if (isset($_POST["informatika"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'informatika'");
    }
    //read buku bisnis
    if (isset($_POST["bisnis"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'bisnis'");
    }
    //read buku filsafat
    if (isset($_POST["filsafat"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'filsafat'");
    }
    //read buku novel
    if (isset($_POST["novel"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'novel'");
    }
    //read buku sains
    if (isset($_POST["sains"])) {
        $buku = queryReadData("SELECT * FROM buku WHERE kategori = 'sains'");
    }
    ?>
    <!-- Btn filter data kategori buku -->
    <section id="homeSection" class="p-3">
        <h1 class="container text-center mb-3 header-text"
            style="font-family: 'times new roman', sans-serif; font-size: 2rem; font-weight: bold; color: #fff;">DAFTAR
            BUKU PERPUSTAKAAN</h1>

        <!-- Form and Buttons -->
        <!-- Tombol Kategori -->
        <form action="" method="post">
       <div class="input-group d-flex justify-content-center mb-3">
         <input style="width:38%;" class="border p-2 rounded rounded-end-0 bg-tertiary" type="text" name="keyword" id="keyword" placeholder="cari data buku...">
         <button class="border border-start-0 bg-light rounded rounded-start-0" type="submit" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
       </div>
      </form>
        <form action="" method="post">
            <div class="container kategori-buttons text-dark"
                style="font-family: 'Comic Sans MS', sans-serif; font-weight: bold; color: dark;">
                <button class="btn btn-light text-dark border-dark" type="submit">Semua</button>
                <button type="submit" name="informatika" class="border-dark btn btn-light">Informatika</button>
                <button type="submit" name="bisnis" class="btn btn-light border-dark">Bisnis</button>
                <button type="submit" name="filsafat" class="btn btn-light border-dark">Filsafat</button>
                <button type="submit" name="novel" class="btn btn-light border-dark">Novel</button>
                <button type="submit" name="sains" class="btn btn-light border-dark">Sains</button>
            </div>
        </form>

        <!-- Card buku -->
        <div class="container custom-container">
            <form action="" method="post">
                <?php
                $bukuCount = count($buku); // Inisialisasi delay
                ?>
                <div class="layout-card-custom <?php echo $bukuCount > 0 ? 'scrolling-animation' : ''; ?>"
                    style="overflow-x: auto; white-space: nowrap;">
                    <?php foreach ($buku as $item) : ?>
                    <div class="card border-dark" style="width: 14rem; margin-right: 1.5rem;">
                        <a href="sign/link_login.php">
                            <img src="imgDB/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku"
                                style="object-fit: cover; height: 200px;">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title text-dark"
                                style="white-space: normal; overflow: hidden; text-overflow: ellipsis;"><?= $item["judul"]; ?>
                            </h6>
                        </div>
                        <ul align="center" style="font-family: 'Comic Sans MS', sans-serif; color: dark;"
                            class="list-group list-group-flush">
                            <li class="list-group-item text-dark">Kategori : <?= $item["kategori"]; ?></li>
                        </ul>
                    </div>

                    <?php endforeach; ?>
                </div>
            </form>
        </div><br><br>
        <footer id="footer" class="p-1 bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center mt-2">
                    <p class="text-light"><i>Copyright © 2023 SULTHAN MADYA.</i></p>
                </div>
            </div>
        </footer>
    </section>
    <script>
        function toggleDropdownMenu() {
            var dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.matches('.menu-button')) {
                var dropdownMenu = document.getElementById('dropdownMenu');
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                }
            }
        }
    </script>
</body>

</html>
