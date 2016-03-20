<?php

require_once("src/connections.php");


if (!isset($_SESSION['userId']) && !isset($_SESSION['adminId'])) {
    header("Location: login.php");
}

if (isset($_GET['idP']) && is_numeric($_GET['idP'])) {
    if ($postToRemove = Post::LoadPostById($_GET['idP'])) {
        if ($postToRemove->getUserId() == $_SESSION['userId'] || isset($_SESSION['adminId'])) {
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
        if ($commentToRemove->getUserId() == $_SESSION['userId'] || isset($_SESSION['adminId'])) {
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
    echo('Access denied');
} else {
    echo('Access denied');
}

require_once('src/nav.php');

