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
echo sprintf("<a href='%s'>Show profile</a><br><hr>", Param::url(false, ['action' => 'profile', 'id' => $userId]));

$posts = $user->loadAllUserPosts();

foreach ($posts as $post) {
    $postId = $post->getId();
    echo('<h3>' . $post->getTitle() . '</h3>');
    echo($post->getPostText() . '<br>');
    echo sprintf("<a href='%s'>Show</a><br>", Param::url(false, ['action' => 'showPost', 'id' => $postId]));
    if ($post->getUserId() == $_SESSION['userId'] || isset($_SESSION['adminId'])) {
        echo sprintf("<a href='%s'>Remove</a><br>", Param::url(false, ['action' => 'remove', 'idP' => $postId]));
    }
    echo('<br>' . $post->getPostDate() . '<br><hr>');
}

echo("</div>");

