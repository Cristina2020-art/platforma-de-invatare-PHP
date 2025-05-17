<?php
session_start();
$user = $_SESSION['user'] ?? null;
$lectie = $_GET['lectie'] ?? null;

if (!$user || !$lectie) {
    echo "false";
    exit;
}

$progress = json_decode(file_get_contents("progress.json"), true) ?? [];
echo isset($progress[$user][$lectie]) && $progress[$user][$lectie] ? "true" : "false";
?>