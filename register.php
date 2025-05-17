<?php
if ($_POST) {
    $users = json_decode(file_get_contents("users.json"), true) ?? [];

    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (isset($users[$user])) {
        echo "Utilizatorul există deja!";
    } else {
        $users[$user] = $pass;
        file_put_contents("users.json", json_encode($users));
        echo "Cont creat cu succes!";
    }
}
?>
<form method="POST">
  <input name="username" placeholder="Username" required><br>
  <input name="password" type="password" placeholder="Parola" required><br>
  <button>Înregistrează</button>
</form>
