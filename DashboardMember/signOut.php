<?php
// Logout untuk menghilangkan Session
session_start();

// Simpan pesan logout
$_SESSION['logout_message'] = "Anda telah logout.";

$_SESSION = [];
session_unset();
session_destroy();

header("Location: ../sign/link_login.php?logout=3");
exit;
?>
