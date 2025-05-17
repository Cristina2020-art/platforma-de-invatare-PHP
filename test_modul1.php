<?php
session_start();
$user = $_SESSION['user'] ?? 'anonim';

$intrebari = [
    1 => [
        'q' => 'Ce funcție PHP afișează text pe ecran?',
        'a' => ['print()', 'echo', 'show()', 'display()'],
        'c' => 1
    ],
    2 => [
        'q' => 'Care simbol marchează începutul unei variabile?',
        'a' => ['@', '#', '$', '%'],
        'c' => 2
    ],
    3 => [
        'q' => 'Ce tip de date este "42"?',
        'a' => ['string', 'integer', 'float', 'boolean'],
        'c' => 1
    ],
    4 => [
        'q' => 'Care este rezultatul: 3 + 2 * 2?',
        'a' => ['10', '7', '9', '12'],
        'c' => 1
    ],
    5 => [
        'q' => 'Ce structură controlează condițiile?',
        'a' => ['for', 'while', 'if', 'switch'],
        'c' => 2
    ],
    6 => [
        'q' => 'Ce operator verifică egalitatea în PHP?',
        'a' => ['=', '==', '!=', '==='],
        'c' => 1
    ],
    7 => [
        'q' => 'Care este extensia fișierelor PHP?',
        'a' => ['.html', '.txt', '.php', '.css'],
        'c' => 2
    ],
    8 => [
        'q' => 'Cum se scrie un comentariu pe o linie?',
        'a' => ['/* comentariu */', '# comentariu', '// comentariu', '-- comentariu'],
        'c' => 2
    ],
    9 => [
        'q' => 'Care este valoarea booleană a expresiei: (4 > 5)?',
        'a' => ['true', '1', 'false', '0'],
        'c' => 2
    ],
    10 => [
        'q' => 'Care funcție adaugă un element într-un array?',
        'a' => ['add()', 'insert()', 'array_push()', 'append()'],
        'c' => 2
    ]
];

$scor = 0;
$feedback = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($intrebari as $id => $item) {
        $raspuns = $_POST["q$id"] ?? -1;
        if ($raspuns == $item['c']) {
            $scor++;
            $feedback[$id] = true;
        } else {
            $feedback[$id] = false;
        }
    }

    // Salvare scor (opțional)
    $teste = file_exists("scor_teste.json") ? json_decode(file_get_contents("scor_teste.json"), true) : [];
    $teste[$user]['modul1'] = $scor;
    file_put_contents("scor_teste.json", json_encode($teste, JSON_PRETTY_PRINT));
}
?>

<h2>Test grilă – Modul 1 (PHP de bază)</h2>
<form method="POST">
    <?php foreach ($intrebari as $id => $item): ?>
        <p><strong><?= $id ?>. <?= $item['q'] ?></strong></p>
        <?php foreach ($item['a'] as $k => $rasp): ?>
            <label>
                <input type="radio" name="q<?= $id ?>" value="<?= $k ?>">
                <?= htmlspecialchars($rasp) ?>
            </label><br>
        <?php endforeach; ?>

        <?php if (isset($feedback[$id])): ?>
            <p style="color:<?= $feedback[$id] ? 'green' : 'red' ?>">
                <?= $feedback[$id] ? 'Corect!' : 'Greșit! Răspuns corect: ' . $item['a'][$item['c']] ?>
            </p>
        <?php endif; ?>
        <hr>
    <?php endforeach; ?>

    <button type="submit">Trimite testul</button>
</form>

<?php if ($_POST): ?>
    <h3>Scor obținut: <?= $scor ?>/<?= count($intrebari) ?></h3>
<?php endif; ?>