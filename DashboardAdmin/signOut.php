<?php 
session_start();
$_SESSION = [];
session_unset();
session_destroy();
header("Location: ../sign/admin/sign_in.php?logout=1");
exit;
?>
