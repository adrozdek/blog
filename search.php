<?php

require_once("src/connections.php");
require_once("src/nav.php");

echo("<div class='container'>");

if (isset($_GET['search'])) {
    $search = Security::IsValid(Security::SanitizeString($_GET['search']));
    $posts = Post::SearchPosts($search);

    foreach ($posts as $post) {
        $postId = $post->getId();
        echo("<h3>" . ucfirst($post->getTitle()) . '</h3>');
        echo sprintf("<a href='%s'>Show</a><br>", Param::url(false, ['action' => 'showPost', 'id' => $postId]));
        if ($post->getUserId() == $_SESSION['userId']) {
            echo sprintf("<a href='%s'>Remove</a><br>", Param::url(false, ['action' => 'remove', 'idP' => $postId]));
        }
        echo('<br>' . $post->getPostDate() . '<br><hr>');
    }
}

echo("</div>");