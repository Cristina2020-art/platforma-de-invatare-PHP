<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM employees WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo "Angajat șters cu succes.";
}
?>

<form method="post">
    ID: <input type="number" name="id"><br>
    <input type="submit" value="Șterge">
</form>