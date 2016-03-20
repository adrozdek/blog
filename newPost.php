<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = $_POST['postText'];
    $title = $_POST['title'];
    if (Security::IsValid(Security::SanitizeString($post)) && Security::IsValid(Security::SanitizeString($title))) {
        if (Post::CreatePost($title, $post)) {
            echo("Post created");
        } else {
            echo("Couldn't create post");
        }
    } else {
        echo("Post is not valid. Please try again.");
    }
}

$form_action = "newPost.php";
$headline = 'New post: ';

require_once("./Template/post_form.php");

