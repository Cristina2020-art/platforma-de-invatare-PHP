<?php
session_start();
$user = $_SESSION['user'] ?? 'anonim'; // fallback pentru testare locală

function executaCod($cod)
{
    ob_start();
    try {
        eval ($cod);
    } catch (Throwable $e) {
        return "Eroare: " . $e->getMessage();
    }
    return trim(ob_get_clean());
}

// Răspunsuri corecte
$asteptate = [
    1 => "Salut lume!",
    2 => "10",
    3 => "Impar",
    4 => "Salut, Ion!",
    5 => "Mic",
    6 => "1\n2\n3\n4\n5",
    7 => "Bună ziua!",
    8 => "mere\npere\nprune",
    9 => "8",
    10 => "Bun venit, Maria!"
];

// Încarcă scoruri existente
$scoruri = file_exists("scor_exercitii.json")
    ? json_decode(file_get_contents("scor_exercitii.json"), true)
    : [];

$rezultate = [];

if ($_POST) {
    $nr = $_POST['ex'];
    $cod = $_POST['cod'];
    $rezultat = executaCod($cod);
    $corect = ($rezultat === $asteptate[$nr]);

    $rezultate[$nr] = $corect ? "Corect!" : "Incorect. Răspuns: $rezultat";

    // Salvează progres
    $scoruri[$user][$nr] = $corect;
    file_put_contents("scor_exercitii.json", json_encode($scoruri, JSON_PRETTY_PRINT));
}
?>

<h2>Exerciții PHP Interactive</h2>
<p>Bine ai venit, <strong><?= htmlspecialchars($user) ?></strong>. Progresul tău este salvat automat.</p>

<?php
for ($i = 1; $i <= 10; $i++):
    ?>

    <h3>Exercițiul <?= $i ?></h3>
    <p>
        <?php
        switch ($i) {
            case 1:
                echo 'Afișează: Salut lume!';
                break;
            case 2:
                echo 'Afișează suma dintre 7 și 3.';
                break;
            case 3:
                echo 'Verifică dacă 9 este par sau impar.';
                break;
            case 4:
                echo 'Creează o variabilă $nume = "Ion" și afișează: Salut, Ion!';
                break;
            case 5:
                echo 'Dacă $x = 5, afișează "Mic" dacă e sub 10.';
                break;
            case 6:
                echo 'Afișează numerele de la 1 la 5, fiecare pe rând nou.';
                break;
            case 7:
                echo 'Creează funcția salut() care afișează: Bună ziua!';
                break;
            case 8:
                echo 'Afișează fiecare element din array-ul ["mere", "pere", "prune"].';
                break;
            case 9:
                echo 'Calculează media dintre 10, 8 și 6.';
                break;
            case 10:
                echo 'Cu $nume = "Maria", afișează: Bun venit, Maria!';
                break;
        }
        ?>
    </p>

    <form method="POST">
        <textarea name="cod" rows="5"
            cols="60"><?= $_POST['ex'] == $i ? htmlspecialchars($_POST['cod']) : '' ?></textarea><br>
        <input type="hidden" name="ex" value="<?= $i ?>">
        <button>Verifică</button>
    </form>

    <?php if (isset($rezultate[$i])): ?>
        <div style="background:#eef; padding:10px; margin-top:5px; border-left:4px solid #007bff;">
            <strong>Feedback:</strong> <?= $rezultate[$i] ?>
        </div>
    <?php endif; ?>

    <?php if (isset($scoruri[$user][$i]) && $scoruri[$user][$i] === true): ?>
        <p style="color:green;">Acest exercițiu este finalizat corect.</p>
    <?php endif; ?>

    <hr>

<?php endfor; ?>