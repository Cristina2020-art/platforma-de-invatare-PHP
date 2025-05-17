<?php
session_start();
$user = $_SESSION['user'] ?? 'anonim';

$intrebari = [
    1 => [
        'q' => 'Ce funcție PHP se folosește pentru a conecta la o bază de date MySQL?',
        'a' => ['mysqli_connect()', 'db_connect()', 'mysql_connect()', 'connect_db()'],
        'c' => 0
    ],
    2 => [
        'q' => 'Cum începi o sesiune în PHP?',
        'a' => ['session_start()', 'session_begin()', 'start_session()', 'begin_session()'],
        'c' => 0
    ],
    3 => [
        'q' => 'Care este sintaxa corectă pentru definirea unei clase în PHP?',
        'a' => ['class Nume {}', 'function class Nume {}', 'def class Nume {}', 'class = Nume {}'],
        'c' => 0
    ],
    4 => [
        'q' => 'Cum accesezi o proprietate publică a unui obiect $ob?',
        'a' => ['$ob->proprietate', '$ob.proprietate', '$ob[proprietate]', '$ob:proprietate'],
        'c' => 0
    ],
    5 => [
        'q' => 'Cum ștergi o variabilă de sesiune numită "user"?',
        'a' => ['unset($_SESSION["user"])', 'delete $_SESSION["user"]', 'remove($_SESSION["user"])', 'unset_session("user")'],
        'c' => 0
    ],
    6 => [
        'q' => 'Ce metodă magică este apelată automat la crearea unui obiect?',
        'a' => ['__construct()', '__init()', '__start()', '__create()'],
        'c' => 0
    ],
    7 => [
        'q' => 'Ce face metoda fetch_assoc() în mysqli?',
        'a' => ['Returnează rândul curent ca array asociativ', 'Execută o interogare', 'Închide conexiunea', 'Returnează numărul de rânduri'],
        'c' => 0
    ],
    8 => [
        'q' => 'Cum pregătești o interogare SQL pentru a preveni SQL Injection?',
        'a' => ['folosești prepared statements', 'folosești addslashes()', 'folosești htmlentities()', 'folosești strip_tags()'],
        'c' => 0
    ],
    9 => [
        'q' => 'Cum afișezi o excepție prinsă în PHP?',
        'a' => ['echo $e->getMessage();', 'print($e);', 'echo $e;', 'exception_print($e);'],
        'c' => 0
    ],
    10 => [
        'q' => 'Cum verifici dacă o sesiune este activă?',
        'a' => ['isset($_SESSION)', 'session_status() == PHP_SESSION_ACTIVE', 'session_active()', 'is_session_started()'],
        'c' => 1
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
    $teste[$user]['modul3'] = $scor;
    file_put_contents("scor_teste.json", json_encode($teste, JSON_PRETTY_PRINT));
}
?>

<h2>Test grilă – Modul 3 (Baze de date, Sesiuni, OOP)</h2>
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