<?php
$filePath = 'scoruri.json';

// Verifică dacă fișierul există și conține date valide
if (!file_exists($filePath)) {
    die("Fișierul scoruri.json nu există.");
}

$data = json_decode(file_get_contents($filePath), true);
if ($data === null) {
    die("Conținutul fișierului scoruri.json nu este valid JSON.");
}
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Scoruri toate modulele</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Scoruri Teste – utilizatori (Module 1-6)</h2>
    <table>
        <tr>
            <th>Utilizator</th>
            <th>Modul 1</th>
            <th>Modul 2</th>
            <th>Modul 3</th>
            <th>Modul 4</th>
            <th>Modul 5</th>
            <th>Modul 6</th>
        </tr>
        <?php foreach ($data as $user => $moduleScores): ?>
            <tr>
                <td><?= htmlspecialchars($user) ?></td>
                <td><?= $moduleScores['modul1'] ?? '-' ?></td>
                <td><?= $moduleScores['modul2'] ?? '-' ?></td>
                <td><?= $moduleScores['modul3'] ?? '-' ?></td>
                <td><?= $moduleScores['modul4'] ?? '-' ?></td>
                <td><?= $moduleScores['modul5'] ?? '-' ?></td>
                <td><?= $moduleScores['modul6'] ?? '-' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>