<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$database_name = "perpustakaan";
$connection = mysqli_connect($host, $username, $password, $database_name);

// === FUNCTION KHUSUS ADMIN START ===

// MENAMPILKAN DATA KATEGORI BUKU
function queryReadData($dataKategori) {
  global $connection;
  $result = mysqli_query($connection, $dataKategori);
  $items = [];
  while($item = mysqli_fetch_assoc($result)) {
    $items[] = $item;
  }     
  return $items;
}

// Menambahkan data buku 
function tambahBuku($dataBuku) {
  global $connection;
  
  $cover = upload();
  $idBuku = htmlspecialchars($dataBuku["id_buku"]);
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = htmlspecialchars($dataBuku["judul"]);
  $pengarangBuku = htmlspecialchars($dataBuku["pengarang"]);
  $penerbitBuku = htmlspecialchars($dataBuku["penerbit"]);
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = htmlspecialchars($dataBuku["buku_deskripsi"]);
  $isi_buku = upload_isi();

  if(!$cover || !$isi_buku) {
    return 0;
} 
  
  $queryInsertDataBuku = "INSERT INTO buku VALUES('$cover', '$idBuku', '$kategoriBuku', '$judulBuku', '$pengarangBuku', '$penerbitBuku', '$tahunTerbit', $jumlahHalaman, '$deskripsiBuku','$isi_buku')";
  
  mysqli_query($connection, $queryInsertDataBuku);
  return mysqli_affected_rows($connection);
  
}       

// Function upload gambar 
function upload() {
  $namaFile = $_FILES["cover"]["name"];
  $ukuranFile = $_FILES["cover"]["size"];
  $error = $_FILES["cover"]["error"];
  $tmpName = $_FILES["cover"]["tmp_name"];
  
  // cek apakah ada gambar yg diupload
  if($error === 4) {
    echo "<script>
    alert('Silahkan upload cover buku terlebih dahulu!')
    </script>";
    return 0;
  }
  
  // cek kesesuaian format gambar
  $jpg = "jpg";
  $jpeg = "jpeg";
  $png = "png";
  $svg = "svg";
  $bmp = "bmp";
  $psd = "psd";
  $tiff = "tiff";
  $formatGambarValid = [$jpg, $jpeg, $png, $svg, $bmp, $psd, $tiff];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  
  if(!in_array($ekstensiGambar, $formatGambarValid)) {
    echo "<script>
    alert('Format file tidak sesuai');
    </script>";
    return 0;
  }
  
  // batas ukuran file
  if($ukuranFile > 2000000) {
    echo "<script>
    alert('Ukuran file terlalu besar!');
    </script>";
    return 0;
  }
  
   //generate nama file baru, agar nama file tdk ada yg sama
  $namaFileBaru = uniqid();
  $namaFileBaru .= ".";
  $namaFileBaru .= $ekstensiGambar;
  
  move_uploaded_file($tmpName, '../../imgDB/' . $namaFileBaru);
  return $namaFileBaru;
} 

//upload isi buku dengan format pdf
function upload_isi(){
  $namaFile = $_FILES['isi_buku']['name'];
  $x = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($x));
  $ukuranFile = $_FILES['isi_buku']['size'];
  $file_tmp = $_FILES['isi_buku']['tmp_name'];

  // Lokasi Penempatan file
  $dirUpload = "../../isi-buku/";
  $linkBerkas = $dirUpload . $namaFile;

  // Validasi Format File (contoh: hanya menerima format PDF)
  if ($ekstensiFile !== 'pdf') {
      echo "<script>
      alert('Format file tidak sesuai. Hanya file PDF yang diperbolehkan.');
      </script>";
      return 0;
  }

  // Kontrol Ukuran File (contoh: maksimum 2MB)
  if ($ukuranFile > 20000000000) {
      echo "<script>
      alert('Ukuran file terlalu besar. Maksimum 2MB.');
      </script>";
      return 0;
  }

  // Menyimpan file
  if (move_uploaded_file($file_tmp, $linkBerkas)) {
      return $namaFile;
  } else {
      echo "<script>
      alert('Gagal mengunggah file. Silakan coba lagi.');
      </script>";
      return 0;
  }
}
// MENAMPILKAN SESUATU SESUAI DENGAN INPUTAN USER PADA * SEARCH ENGINE *
function search($keyword) {
  // search data buku
  $querySearch = "SELECT * FROM buku 
  WHERE
  judul LIKE '%$keyword%' OR
  kategori LIKE '%$keyword%'
  ";
  return queryReadData($querySearch);
  
  // search data pengembalian || member
  $dataPengembalian = "SELECT * FROM pengembalian 
  WHERE 
  id_pengembalian '%$keyword%' OR
  id_buku LIKE '%$keyword%' OR
  judul LIKE '%$keyword%' OR
  kategori LIKE '%$keyword%' OR
  nisn LIKE '%$keyword%' OR
  nama LIKE '%$keyword%' OR
  nama_admin LIKE '%$keyword%' OR
  tgl_pengembalian LIKE '%$keyword%' OR
  keterlambatan LIKE '%$keyword%' OR
  denda LIKE '%$keyword%'";
  return queryReadData($dataPengembalian);
}

function searchMember ($keyword) {
     // search member terdaftar || admin
   $searchMember = "SELECT * FROM member WHERE 
   nisn LIKE '%$keyword%' OR 
   kode_member LIKE '%$keyword%' OR
   nama LIKE '%$keyword%' OR 
   jurusan LIKE '%$keyword%'
   ";
   return queryReadData($searchMember);
}


// DELETE DATA Buku
function delete($bukuId) {
  global $connection;
  
  // Delete related records from peminjaman table
  $queryDeletePeminjaman = "DELETE FROM peminjaman WHERE id_buku = '$bukuId'";
  mysqli_query($connection, $queryDeletePeminjaman);
  
  // Delete the book from the buku table
  $queryDeleteBuku = "DELETE FROM buku WHERE id_buku = '$bukuId'";
  mysqli_query($connection, $queryDeleteBuku);
  
  return mysqli_affected_rows($connection);
}


// UPDATE || EDIT DATA BUKU 
function updateBuku($dataBuku) {
  global $connection;

  $gambarLama = htmlspecialchars($dataBuku["coverLama"]);
  $idBuku = htmlspecialchars($dataBuku["id_buku"]);
  $kategoriBuku = $dataBuku["kategori"];
  $judulBuku = htmlspecialchars($dataBuku["judul"]);
  $pengarangBuku = htmlspecialchars($dataBuku["pengarang"]);
  $penerbitBuku = htmlspecialchars($dataBuku["penerbit"]);
  $tahunTerbit = $dataBuku["tahun_terbit"];
  $jumlahHalaman = $dataBuku["jumlah_halaman"];
  $deskripsiBuku = htmlspecialchars($dataBuku["buku_deskripsi"]);
  
  
  // pengecekan mengganti gambar || tidak
  if($_FILES["cover"]["error"] === 4) {
    $cover = $gambarLama;
  }else {
    $cover = upload();
  }
  // 4 === gagal upload gambar
  // 0 === berhasil upload gambar
  
  $queryUpdate = "UPDATE buku SET 
  cover = '$cover',
  id_buku = '$idBuku',
  kategori = '$kategoriBuku',
  judul = '$judulBuku',
  pengarang = '$pengarangBuku',
  penerbit = '$penerbitBuku',
  tahun_terbit = '$tahunTerbit',
  jumlah_halaman = $jumlahHalaman,
  buku_deskripsi = '$deskripsiBuku'
  WHERE id_buku = '$idBuku'
  ";
  
  mysqli_query($connection, $queryUpdate);
  return mysqli_affected_rows($connection);
}

// Hapus member yang terdaftar
function deleteMember($nisnMember) {
  global $connection;
  
  $deleteMember = "DELETE FROM member WHERE nisn = $nisnMember";
  mysqli_query($connection, $deleteMember);
  return mysqli_affected_rows($connection);
}

// Hapus history pengembalian data BUKU
function deleteDataPengembalian($idPengembalian) {
  global $connection;
  
  $deleteDataPengembalianBuku = "DELETE FROM pengembalian WHERE id_pengembalian = $idPengembalian";
  mysqli_query($connection, $deleteDataPengembalianBuku);
  return mysqli_affected_rows($connection);
}


// === FUNCTION KHUSUS ADMIN END ===

// Peminjaman BUKU
function pinjamBuku($dataBuku) {
  global $connection;
  
  $idBuku = $dataBuku["id_buku"];
  $nisn = $dataBuku["nisn"];
  $idAdmin = $dataBuku["nama_admin"];
  $tglPinjam = $dataBuku["tgl_peminjaman"];
  $tglKembali = $dataBuku["tgl_pengembalian"];
  $status = "Belum konfirmasi";
  $harga = $dataBuku["harga"];
  // Periksa apakah buku yang akan dipinjam sudah ada dalam daftar peminjaman pengguna
  $queryCekPeminjaman = "SELECT * FROM peminjaman WHERE id_buku = '$idBuku' AND nisn = '$nisn' AND (status = 'Belum konfirmasi' OR status = 'Konfirmasi')";
  $resultCekPeminjaman = mysqli_query($connection, $queryCekPeminjaman);
  
  // Jika buku sudah ada dalam daftar peminjaman pengguna, beri peringatan
  if(mysqli_num_rows($resultCekPeminjaman) > 0) {
    echo "<script>alert('Anda sudah meminjam buku ini');</script>";
    return 0; // Kembalikan 0 sebagai tanda bahwa buku tidak bisa dipinjam
  }
  
  // Perbaikan query INSERT INTO dengan menambahkan kolom status
  $queryPinjam = "INSERT INTO peminjaman (id_buku, nisn, nama_admin, tgl_peminjaman, tgl_pengembalian, status, harga) 
                VALUES ('$idBuku', '$nisn', '$idAdmin', '$tglPinjam', '$tglKembali', '$status', '$harga')";
  
  // Eksekusi query INSERT INTO
  if (mysqli_query($connection, $queryPinjam)) {
    return mysqli_affected_rows($connection);
  } else {
    // Jika terjadi error, tampilkan pesan error SQL
    echo "Error: " . $queryPinjam . "<br>" . mysqli_error($connection);
    return 0;
  }
}



// Logika untuk mengubah status menjadi "Waktu habis" saat tanggal pengembalian telah lewat
function pengembalian() {
  global $connection;

  // Ambil waktu saat ini
  $waktuSekarang = date("Y-m-d H:i:s");

  // Query untuk mendapatkan peminjaman yang waktu pengembaliannya sudah berakhir
  $queryPeminjamanBerakhir = "SELECT * FROM peminjaman WHERE tgl_pengembalian < '$waktuSekarang'";
  $resultPeminjamanBerakhir = mysqli_query($connection, $queryPeminjamanBerakhir);

  // Jika ada peminjaman yang sudah berakhir, simpan ke dalam tabel pengembalian dan hapus dari tabel peminjaman
  while ($row = mysqli_fetch_assoc($resultPeminjamanBerakhir)) {
      $idPeminjaman = $row['id_peminjaman'];

      // Update status peminjaman menjadi "Waktu habis"
      $queryUpdateStatus = "UPDATE peminjaman SET status = 'Waktu habis' WHERE id_peminjaman = '$idPeminjaman'";
      mysqli_query($connection, $queryUpdateStatus);
  }
}





// === FUNCTION KHUSUS MEMBER END ===
?>


