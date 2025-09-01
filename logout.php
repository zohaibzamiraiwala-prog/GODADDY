<?php
// logout.php - Logout script
session_start();
session_destroy();
echo "<script>location.href='index.php';</script>";
?>
