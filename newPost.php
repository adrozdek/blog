<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = $_POST['postText'];
    if (Security::SanitizeString($post) && Security::IsValid($post)) {
        if (Post::CreatePost($post)) {
            echo("Post created");
        } else {
            echo("Couldn't create post");
        }
    } else {
        echo("Post is not valid. Please try again.");
    }
}

?>

<div class='container'>
    <h3>New post:</h3>
    <form action='newPost.php' method='post'>
        <label>
            <textarea name='postText' rows='30' cols='100'></textarea>
        </label>
        <input type='submit'>
    </form>
</div>

