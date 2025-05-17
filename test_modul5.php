<?php
session_start();
$user = $_SESSION['user'] ?? 'anonim';

$intrebari = [
    1 => ['q' => 'Ce este SQL Injection?', 'a' => ['Atac prin inserare cod SQL rău intenționat', 'Tip de criptare', 'Metodă de optimizare', 'Protocol de comunicare'], 'c' => 0],
    2 => ['q' => 'Cum previi SQL Injection?', 'a' => ['folosind prepared statements', 'folosind strip_tags()', 'folosind htmlentities()', 'folosind isset()'], 'c' => 0],
    3 => ['q' => 'Ce face funcția htmlspecialchars()?', 'a' => ['Converteste caractere speciale HTML', 'Encodează URL-uri', 'Verifică variabile', 'Șterge spații albe'], 'c' => 0],
    4 => ['q' => 'Cum protejezi o sesiune împotriva furtului?', 'a' => ['Regenerând ID-ul sesiunii', 'Salvând parola în $_SESSION', 'Folosind variabile globale', 'Dezactivând sesiunea'], 'c' => 0],
    5 => ['q' => 'Ce este Cross-Site Scripting (XSS)?', 'a' => ['Atac injectare cod JavaScript', 'Tip de server web', 'Metodă de caching', 'Funcție PHP'], 'c' => 0],
    6 => ['q' => 'Cum previi atacurile XSS?', 'a' => ['Folosind htmlspecialchars() la afișare', 'Folosind md5() pe date', 'Folosind session_start()', 'Folosind cookies'], 'c' => 0],
    7 => ['q' => 'Ce este CSRF?', 'a' => ['Atac de falsificare a cererii', 'Tip de criptare', 'Metodă de autentificare', 'Protocol de transfer'], 'c' => 0],
    8 => ['q' => 'Cum protejezi formularele împotriva CSRF?', 'a' => ['Token CSRF în formulare', 'Folosești cookies', 'Folosind sessions', 'Dezactivezi JavaScript'], 'c' => 0],
    9 => ['q' => 'Ce face funcția password_hash()?', 'a' => ['Creează un hash pentru parolă', 'Decriptează parola', 'Compară parole', 'Generează parole'], 'c' => 0],
    10 => ['q' => 'Ce metodă recomandată folosești pentru autentificare sigură?', 'a' => ['Autentificare cu token și HTTPS', 'Autentificare cu HTTP simplu', 'Stocare parole în text clar', 'Autentificare fără parolă'], 'c' => 0],
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

    $teste = file_exists("scor_teste.json") ? json_decode(file_get_contents("scor_teste.json"), true) : [];
    $teste[$user]['modul5'] = $scor;
    file_put_contents("scor_teste.json", json_encode($teste, JSON_PRETTY_PRINT));
}
?>

<h2>Test grilă – Modul 5 (Securitate în PHP)</h2>
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