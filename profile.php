<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

$user = User::GetUserById($_SESSION['userId']);
$userId = $user->getId();

echo("<div class='container'>");

echo("<h2>" . ucfirst($user->getName()) . "</h2>");
echo("<h3> Number of posts: " . count($user->loadAllUserPosts()) . "</h3>");
echo('Description: ' . $user->getDescription() . '<br>');
echo("<a href='blog.php?id=$userId'>Show posts</a>");


echo("</div>");