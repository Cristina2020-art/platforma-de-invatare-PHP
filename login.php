<?php
session_start();
if ($_POST) {
    $users = json_decode(file_get_contents("users.json"), true) ?? [];
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (isset($users[$user]) && password_verify($pass, $users[$user])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        echo "Login greșit!";
    }
}
?>
<form method="POST">
    <input name="username" placeholder="Username" required><br>
    <input name="password" type="password" placeholder="Parola" required><br>
    <button>Login</button>
</form>