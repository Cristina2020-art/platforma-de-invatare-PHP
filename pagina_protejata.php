<?php
session_start();

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['user'])) {
    // Dacă nu este, redirecționăm spre pagina de login
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8" />
    <title>Pagină Protejată</title>
</head>

<body>
    <h1>Bine ai venit, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
    <p>Aceasta este o pagină protejată, accesibilă doar utilizatorilor autentificați.</p>

    <p><a href="logout.php">Deconectare</a></p>
</body>

</html>