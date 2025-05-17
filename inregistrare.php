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
    $nume = trim($_POST['nume']);
    $email = trim($_POST['email']);
    $parola = trim($_POST['parola']);
    $confirmare_parola = trim($_POST['confirmare_parola']);

    if (empty($nume) || empty($email) || empty($parola) || empty($confirmare_parola)) {
        echo "Te rugăm să completezi toate câmpurile.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresa de email nu este validă.";
    } elseif ($parola !== $confirmare_parola) {
        echo "Parolele nu coincid.";
    } else {
        // Verificarea dacă emailul există deja în baza de date
        $stmt = $conn->prepare("SELECT id FROM utilizatori WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Există deja un cont asociat cu acest email.";
        } else {
            // Hasharea parolei
            $parola_hash = password_hash($parola, PASSWORD_DEFAULT);

            // Inserarea noului utilizator în baza de date
            $stmt = $conn->prepare("INSERT INTO utilizatori (nume, email, parola) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nume, $email, $parola_hash);

            if ($stmt->execute()) {
                echo "Înregistrare reușită. Te poți autentifica acum.";
                // Redirecționare către pagina de autentificare
                header("Location: cont.html");
                exit();
            } else {
                echo "A apărut o eroare la înregistrare: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>