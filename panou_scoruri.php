<?php
$teste = file_exists("scor_teste.json")
    ? json_decode(file_get_contents("scor_teste.json"), true)
    : [];

echo "<h2>Panou scoruri – Teste grilă</h2>";

if (empty($teste)) {
    echo "<p>Nu există scoruri salvate.</p>";
    return;
}

echo "<table border='1' cellpadding='8' style='border-collapse:collapse'>";
echo "<tr><th>Utilizator</th><th>Modul 1</th><th>Modul 2</th><th>Modul 3</th></tr>";

foreach ($teste as $utilizator => $scoruri) {
    echo "<tr>";
    echo "<td><strong>" . htmlspecialchars($utilizator) . "</strong></td>";
    echo "<td>" . ($scoruri['modul1'] ?? '-') . "</td>";
    echo "<td>" . ($scoruri['modul2'] ?? '-') . "</td>";
    echo "<td>" . ($scoruri['modul3'] ?? '-') . "</td>";
    echo "</tr>";
}

echo "</table>";
?>