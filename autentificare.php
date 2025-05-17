<?php
session_start();

// Setările pentru conexiunea la baza de date
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'demo';

// Crearea conexiunii
$conn = new mysqli($host, $user, $password, $database);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Verificarea dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preluarea și validarea datelor din formular
    $email = trim($_POST['email']);
    $parola = trim($_POST['parola']);

    if (empty($email) || empty($parola)) {
        echo "Te rugăm să completezi toate câmpurile.";
    } else {
        // Pregătirea declarației SQL pentru a preveni SQL injection
        $stmt = $conn->prepare("SELECT id, parola FROM utilizatori WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Verificarea dacă utilizatorul există
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $parola_hash);
            $stmt->fetch();

            // Verificarea parolei
            if (password_verify($parola, $parola_hash)) {
                // Autentificare reușită
                $_SESSION['utilizator_id'] = $id;
                $_SESSION['email'] = $email;
                header("Location: pagina_protejata.php");
                exit();
            } else {
                echo "Parolă incorectă.";
            }
        } else {
            echo "Nu există un cont asociat cu acest email.";
        }

        $stmt->close();
    }
}

$conn->close();
?>