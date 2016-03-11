<?php

require_once("src/connections.php");
require_once("src/nav.php");


echo("<div class='container'>");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = User::GetUserById($userId);

} elseif (isset($_SESSION['userId'])) {
    $user = User::GetUserById($_SESSION['userId']);

    echo("<h2>" . ucfirst($user->getName()) . "</h2>");

    echo("<a href='newPost.php'>Dodaj nowy wpis</a>");


} else {
    echo("Log in or choose blogger");
}

echo("</div>");


?>
