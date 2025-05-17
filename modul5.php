<?php
// Date conexiune - adaptează după serverul tău
$host = 'localhost';
$db = 'testdb';  // Numele bazei tale de date
$user = 'root';    // Username
$pass = '';        // Parola
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Erori ca excepții
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch asociativ
    PDO::ATTR_EMULATE_PREPARES => false,                  // Protecție SQL Injection
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Eroare conexiune DB: " . $e->getMessage();
    exit;
}

// Creare tabel dacă nu există
$pdo->exec("CREATE TABLE IF NOT EXISTS utilizatori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Inserare utilizator (CREATE)
if (isset($_POST['adauga'])) {
    $nume = trim($_POST['nume']);
    $email = trim($_POST['email']);

    if ($nume !== '' && $email !== '') {
        // Pregătim interogarea pentru a evita SQL Injection
        $stmt = $pdo->prepare("INSERT INTO utilizatori (nume, email) VALUES (?, ?)");
        try {
            $stmt->execute([$nume, $email]);
            echo "<p style='color:green;'>Utilizator adăugat cu succes!</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Eroare la inserare: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Completați toate câmpurile!</p>";
    }
}

// Citire utilizatori (READ)
$stmt = $pdo->query("SELECT * FROM utilizatori ORDER BY id DESC");
$utilizatori = $stmt->fetchAll();

if ($utilizatori) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nume</th><th>Email</th></tr>";
    foreach ($utilizatori as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['nume']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nu există utilizatori în baza de date.</p>";
}
?>