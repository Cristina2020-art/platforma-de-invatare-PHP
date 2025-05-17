<?php
session_start();

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['utilizator_id'])) {
    header("Location: cont.html");
    exit();
}

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

// Procesarea formularului de schimbare a parolei
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parola_veche = trim($_POST['parola_veche']);
    $parola_noua = trim($_POST['parola_noua']);
    $confirmare_parola = trim($_POST['confirmare_parola']);

    if (empty($parola_veche) || empty($parola_noua) || empty($confirmare_parola)) {
        $mesaj = "Te rugăm să completezi toate câmpurile.";
    } elseif ($parola_noua !== $confirmare_parola) {
        $mesaj = "Parolele noi nu coincid.";
    } else {
        $utilizator_id = $_SESSION['utilizator_id'];

        // Obține parola curentă din baza de date
        $stmt = $conn->prepare("SELECT parola FROM utilizatori WHERE id = ?");
        $stmt->bind_param("i", $utilizator_id);
        $stmt->execute();
        $stmt->bind_result($parola_hash);
        $stmt->fetch();
        $stmt->close();

        // Verifică dacă parola veche este corectă
        if (password_verify($parola_veche, $parola_hash)) {
            // Hash pentru noua parolă
            $parola_noua_hash = password_hash($parola_noua, PASSWORD_DEFAULT);

            // Actualizează parola în baza de date
            $stmt = $conn->prepare("UPDATE utilizatori SET parola = ? WHERE id = ?");
            $stmt->bind_param("si", $parola_noua_hash, $utilizator_id);

            if ($stmt->execute()) {
                $mesaj = "Parola a fost schimbată cu succes.";
            } else {
                $mesaj = "A apărut o eroare la actualizarea parolei.";
            }

            $stmt->close();
        } else {
            $mesaj = "Parola veche este incorectă.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Schimbare parolă</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 50px;
        }

        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .mesaj {
            text-align: center;
            margin-bottom: 15px;
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Schimbare parolă</h2>
        <?php if (isset($mesaj)) {
            echo '<div class="mesaj">' . $mesaj . '</div>';
        } ?>
        <form action="parola.php" method="post">
            <label for="parola_veche">Parola veche:</label>
            <input type="password" id="parola_veche" name="parola_veche" required>

            <label for="parola_noua">Parola nouă:</label>
            <input type="password" id="parola_noua" name="parola_noua" required>

            <label for="confirmare_parola">Confirmă parola nouă:</label>
            <input type="password" id="confirmare_parola" name="confirmare_parola" required>

            <button type="submit">Schimbă parola</button>
        </form>
    </div>

</body>

</html>