<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $address, $salary]);

    echo "Angajat adăugat cu succes.";
}
?>

<form method="post">
    Nume: <input type="text" name="name"><br><br>
    Adresă: <input type="text" name="address"><br><br>
    Salariu: <input type="number" name="salary"><br><br>
    <input type="submit" value="Adaugă angajat">
    <input type="reset" value="Resetează">
</form>