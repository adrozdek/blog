<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

if (isset($_GET['idP']) && is_numeric($_GET['idP'])) {

    if ($postToRemove = Post::LoadPostById($_GET['idP'])) {

        if ($postToRemove->getUserId() == $_SESSION['userId']) {
            if ($postToRemove->removePost()) {
                echo('Post removed');
                return;
            } else {
                echo('Couldn\'t remove this post');
                return;
            }
        }
        echo('Access denied');
    }
} elseif (isset($_GET['idC']) && is_numeric($_GET['idC'])) {

    if ($commentToRemove = Comment::LoadCommentById($_GET['idC'])) {

        if ($commentToRemove->getUserId() == $_SESSION['userId']) {
            if ($commentToRemove->removeComment()) {
                echo('Comment removed');
                return;
            } else {
                echo('Couldn\'t remove this comment');
                return;
            }
        }
        echo('Access denied');
    }
} else {
    echo('Access denied');
}

