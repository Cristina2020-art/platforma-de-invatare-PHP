<?php
session_start();
$user = $_SESSION['user'] ?? 'anonim';

$intrebari = [
    1 => [
        'q' => 'Cum definești o funcție în PHP?',
        'a' => ['function nume() {}', 'func nume() {}', 'define function nume() {}', 'fun nume() {}'],
        'c' => 0
    ],
    2 => [
        'q' => 'Cum adaugi un element la finalul unui array?',
        'a' => ['array_add()', 'array_push()', 'push_array()', 'add_array()'],
        'c' => 1
    ],
    3 => [
        'q' => 'Ce superglobal folosești pentru date trimise prin metodă POST?',
        'a' => ['$_GET', '$_POST', '$_REQUEST', '$_SESSION'],
        'c' => 1
    ],
    4 => [
        'q' => 'Ce funcție PHP verifică dacă o cheie există într-un array?',
        'a' => ['array_key_exists()', 'isset()', 'in_array()', 'array_search()'],
        'c' => 0
    ],
    5 => [
        'q' => 'Cum accesezi primul element dintr-un array $arr?',
        'a' => ['$arr[0]', '$arr[1]', '$arr[first]', '$arr->first'],
        'c' => 0
    ],
    6 => [
        'q' => 'Cum începi o sesiune în PHP?',
        'a' => ['start_session()', 'session_begin()', 'session_start()', 'begin_session()'],
        'c' => 2
    ],
    7 => [
        'q' => 'Ce face funcția trim()?',
        'a' => ['Elimină spațiile albe dintr-un șir', 'Convertește șirul în uppercase', 'Împarte un șir în array', 'Adaugă un spațiu la începutul șirului'],
        'c' => 0
    ],
    8 => [
        'q' => 'Cum verifici dacă o variabilă este goală?',
        'a' => ['empty()', 'isset()', 'is_null()', 'is_empty()'],
        'c' => 0
    ],
    9 => [
        'q' => 'Cum redirecționezi utilizatorul către o altă pagină?',
        'a' => ['redirect("pagina.php")', 'header("Location: pagina.php")', 'goto pagina.php', 'location("pagina.php")'],
        'c' => 1
    ],
    10 => [
        'q' => 'Ce este $_SESSION în PHP?',
        'a' => ['Array pentru stocarea datelor de sesiune', 'Funcție pentru creare sesiune', 'Variabilă globală pentru cookie-uri', 'Funcție pentru criptare date'],
        'c' => 0
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

    // Salvare scor
    $teste = file_exists("scor_teste.json") ? json_decode(file_get_contents("scor_teste.json"), true) : [];
    $teste[$user]['modul2'] = $scor;
    file_put_contents("scor_teste.json", json_encode($teste, JSON_PRETTY_PRINT));
}
?>

<h2>Test grilă – Modul 2 (PHP avansat)</h2>
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