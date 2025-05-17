<?php
session_start();

// Răspuns așteptat (poate fi mai complex în viitor)
$solutie_corecta = 'echo "Salut lume!";';

$feedback = "";
if ($_POST) {
    ob_start();
    try {
        eval ($_POST['cod']); // Atenție: nu folosi eval în producție fără validare
    } catch (Throwable $e) {
        echo "Eroare: " . $e->getMessage();
    }
    $rezultat = trim(ob_get_clean());

    if ($rezultat === "Salut lume!") {
        $feedback = "Corect!";
    } else {
        $feedback = "Incorect. Verifică sintaxa și textul exact.";
    }
}
?>

<form method="POST">
    <label>Scrie un script PHP care afișează <code>Salut lume!</code></label><br>
    <textarea name="cod" rows="5" cols="60"
        placeholder="Scrie codul PHP aici..."><?php echo $_POST['cod'] ?? ''; ?></textarea><br>
    <button>Verifică</button>
</form>

<?php if ($feedback): ?>
    <div style="margin-top:10px; background:#eef; padding:10px; border-left:4px solid #007bff;">
        <strong>Feedback:</strong> <?php echo $feedback; ?>
    </div>
<?php endif; ?>