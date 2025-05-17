<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_POST['lectie'])) {
    exit("Acces neautorizat");
}

$user = $_SESSION['user'];
$lectie = $_POST['lectie'];

$progress = json_decode(file_get_contents("progress.json"), true) ?? [];

$progress[$user][$lectie] = true;

file_put_contents("progress.json", json_encode($progress));

echo "Progres salvat pentru $lectie.";
?>