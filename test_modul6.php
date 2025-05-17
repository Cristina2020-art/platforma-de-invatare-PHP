<?php
session_start();
$user = $_SESSION['user'] ?? 'anonim';

$intrebari = [
    1 => ['q' => 'Ce este Laravel?', 'a' => ['Framework PHP MVC', 'SGBD', 'Server web', 'Limbaj programare'], 'c' => 0],
    2 => ['q' => 'Ce este un controller în MVC?', 'a' => ['Partea care gestionează logica', 'Partea care afișează datele', 'Baza de date', 'Fișier CSS'], 'c' => 0],
    3 => ['q' => 'Cum definești o rută în Laravel?', 'a' => ['Route::get()', 'route_define()', 'define_route()', 'Route::start()'], 'c' => 0],
    4 => ['q' => 'Ce este Composer?', 'a' => ['Manager de pachete PHP', 'Framework PHP', 'Server web', 'Editor de text'], 'c' => 0],
    5 => ['q' => 'Ce este un ORM?', 'a' => ['Mapare obiect-relatională', 'Sistem de template-uri', 'Server web', 'Editor de cod'], 'c' => 0],
    6 => ['q' => 'Ce motor de template folosește Laravel?', 'a' => ['Blade', 'Twig', 'Smarty', 'Mustache'], 'c' => 0],
    7 => ['q' => 'Cum lansezi serverul local în Laravel?', 'a' => ['php artisan serve', 'php serve', 'php start', 'laravel start'], 'c' => 0],
    8 => ['q' => 'Ce este Symfony?', 'a' => ['Framework PHP modular', 'Editor de text', 'Limbaj programare', 'Server web'], 'c' => 0],
    9 => ['q' => 'Ce este un bundle în Symfony?', 'a' => ['Pachet reutilizabil de cod', 'Tip de controller', 'Baza de date', 'Motor de template'], 'c' => 0],
    10 => ['q' => 'Cum gestionezi dependențele în proiectele PHP moderne?', 'a' => ['Composer', 'npm', 'pip', 'gem'], 'c' => 0],
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
    $teste[$user]['modul6'] = $scor;
    file_put_contents("scor_teste.json", json_encode($teste, JSON_PRETTY_PRINT));
}
?>

<h2>Test grilă – Modul 6 (Framework-uri PHP)</h2>
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