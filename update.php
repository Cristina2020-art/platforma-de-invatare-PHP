<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $salary = $_POST['salary'];

    $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $address, $salary, $id]);

    echo "Angajat actualizat cu succes.";
}
?>

<form method="post">
    ID: <input type="number" name="id"><br><br>
    Nume: <input type="text" name="name"><br><br>
    Adresă: <input type="text" name="address"><br><br>
    Salariu: <input type="number" name="salary"><br><br>
    <input type="submit" value="Actualizează">
</form>