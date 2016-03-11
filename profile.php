<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

$user = User::GetUserById($_SESSION['userId']);


echo("<div class='container'>");

echo("<h2>" . ucfirst($user->getName()) . "</h2>");


echo("</div>");