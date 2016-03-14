<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

echo("<div class='container'>");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = User::GetUserById($userId);

} elseif (isset($_SESSION['userId'])) {
    $user = User::GetUserById($_SESSION['userId']);
    $userId = $user->getId();
    echo("<a href='newPost.php'>Dodaj nowy wpis</a>");

} else {
    echo "Log in or choose blogger";
    return;
}


echo("<h2>" . ucfirst($user->getName()) . "</h2>");
echo("<h3> Number of posts: " . count($user->loadAllUserPosts()) . "</h3>");
echo('Description: ' . $user->getDescription() . '<br>');
echo("<a href='blog.php?id=$userId'>Show posts</a>");


echo("</div>");