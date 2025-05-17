<?php
$file = 'users.json';
if (file_exists($file)) {
    $data = file_get_contents($file);
    $users = json_decode($data, true);
    // Continuă cu logica de autentificare
} else {
    echo "Fișierul users.json nu există.";
}
?>