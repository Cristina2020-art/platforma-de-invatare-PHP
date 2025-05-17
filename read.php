<?php
require 'config.php';

$stmt = $pdo->query('SELECT * FROM employees');
while ($row = $stmt->fetch()) {
    echo $row['id'] . ' - ' . $row['name'] . ' - ' . $row['address'] . ' - ' . $row['salary'] . "<br>";
}
?>