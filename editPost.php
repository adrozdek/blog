<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

if (isset($_GET['id']) && is_numeric($_GET['id'])):
    $id = $_GET['id'];
    $postToEdit = Post::LoadPostById($id);

    if ($postToEdit->getUserId() == $_SESSION['userId'] || isset($_SESSION['adminId'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $_POST['postText'];
            $title = $_POST['title'];
            if (Security::SanitizeString($post) && Security::IsValid($post) && Security::SanitizeString($title) && Security::IsValid($title)) {
                if ($postToEdit->updatePost($title, $post)) {
                    echo("Post updated:");
                } else {
                    echo("Couldn't update post");
                }
            } else {
                echo("New post is not valid. Please try again.");
            }
        }

        echo("
    <div class='container'>
        <h3>Edit post:</h3>
        <form action='editPost.php?id=$id' method='post'>
            <p>
                <label>
                Title:
                    <input type='text' name='title' value='{$postToEdit->getTitle()}'>
                </label>
            </p>
            <label>
                <textarea name='postText' rows='30' cols='100'>{$postToEdit->getPostText()}</textarea>
            </label>
            <input type='submit'>
        </form>
    </div>
    ");

    }


endif;