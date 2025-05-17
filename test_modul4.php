<?php
session_start();
$user = $_SESSION['user'] ?? 'anonim';

$intrebari = [
  1 => ['q' => 'Ce metodă HTTP se folosește pentru a obține date dintr-un API REST?', 'a' => ['POST', 'GET', 'PUT', 'DELETE'], 'c' => 1],
  2 => ['q' => 'Cum setezi un header JSON în PHP?', 'a' => ['header("Content-Type: text/html")', 'header("Content-Type: application/json")', 'set_header_json()', 'json_header()'], 'c' => 1],
  3 => ['q' => 'Ce funcție PHP decodează un JSON în array?', 'a' => ['json_encode()', 'json_decode()', 'decode_json()', 'json_parse()'], 'c' => 1],
  4 => ['q' => 'Ce cod de stare HTTP indică succes?', 'a' => ['200', '404', '500', '301'], 'c' => 0],
  5 => ['q' => 'Cum se trimite un request POST prin cURL în PHP?', 'a' => ['curl_setopt($ch, CURLOPT_POST, true)', 'curl_post()', 'curl_send_post()', 'post_curl()'], 'c' => 0],
  6 => ['q' => 'Ce este un endpoint în contextul API?', 'a' => ['O adresă URL pentru acces API', 'Un tip de autentificare', 'Un fișier PHP', 'Un parametru POST'], 'c' => 0],
  7 => ['q' => 'Cum se verifică dacă un parametru există în URL?', 'a' => ['isset($_GET["param"])', 'empty($_GET["param"])', '$_POST["param"]', 'isset($_POST["param"])'], 'c' => 0],
  8 => ['q' => 'Ce metodă HTTP folosești pentru actualizarea completă a unei resurse?', 'a' => ['PATCH', 'PUT', 'POST', 'GET'], 'c' => 1],
  9 => ['q' => 'Cum generezi un răspuns JSON în PHP?', 'a' => ['echo json_encode($data)', 'echo json_decode($data)', 'print_r($data)', 'var_dump($data)'], 'c' => 0],
  10 => ['q' => 'Ce este CORS?', 'a' => ['Politică de securitate a browserului pentru resurse cross-domain', 'Tip de autentificare', 'Protocol de transfer date', 'Format de date JSON'], 'c' => 0],
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
  $teste[$user]['modul4'] = $scor;
  file_put_contents("scor_teste.json", json_encode($teste, JSON_PRETTY_PRINT));
}
?>

<h2>Test grilă – Modul 4 (PHP & API REST)</h2>
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
