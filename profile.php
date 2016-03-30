<?php

require_once("src/connections.php");
require_once("src/nav.php");

echo("<div class='container'>");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = User::GetUserById($userId);
} elseif (isset($_SESSION['userId'])) {
    $user = User::GetUserById($_SESSION['userId']);
    $userId = $user->getId();
    echo sprintf("<a href='%s'>Add new post</a>", Param::url(false, ['action' => 'newPost']));
} else {
    echo "Log in or choose blogger";
    return;
}

echo("<h2>" . ucfirst($user->getName()) . "</h2>");
echo("<h3> Number of posts: " . count($user->loadAllUserPosts()) . "</h3>");
echo('Description: ' . $user->getDescription() . '<br>');
echo sprintf("<a href='%s'>Show posts</a>", Param::url(false, ['id' => $userId]));

echo("</div>");