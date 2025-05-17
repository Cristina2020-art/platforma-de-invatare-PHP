<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
echo "Bine ai venit, " . $_SESSION['user'];
?>
<br><a href="logout.php">Logout</a>