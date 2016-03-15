<?php

require_once("src/connections.php");
require_once("src/nav.php");

echo("<div class='container'>");

if(isset($_GET['search'])) {
    $search = Security::IsValid(Security::SanitizeString($_GET['search']));

    $posts = Post::SearchPosts($search);

    foreach($posts as $post) {

        $postId = $post->getId();
        echo("<h3>" . ucfirst($post->getTitle()) . '</h3>');
        echo("<a href='showPost.php?id=$postId'>Show</a><br>");
        if($post->getUserId() == $_SESSION['userId']) {
            echo("<a href='remove.php?idP=$postId'>Remove</a><br>");
        }
        echo('<br>' . $post->getPostDate() . '<br><hr>');

    }

}

echo("</div>");