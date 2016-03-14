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
    echo("<a href='newPost.php'>Dodaj nowy wpis</a>");

} else {
    echo "Log in or choose blogger";
    return;
}

echo("<h2>" . ucfirst($user->getName()) . "</h2>");
echo("<a href='profile.php?id=$userId'>Show profile</a><br><hr>");
//var_dump($user);
$posts = $user->loadAllUserPosts();
//var_dump($posts);

foreach($posts as $post) {
    $postId = $post->getId();
    echo($post->getPostText() . '<br>');
    echo("<a href='showPost.php?id=$postId'>Show</a><br>");
    if($post->getUserId() == $_SESSION['userId']) {
        echo("<a href='remove.php?idP=$postId'>Remove</a><br>");
    }
    echo('<br>' . $post->getPostDate() . '<br><hr>');

}

echo("</div>");


?>
