<?php

require_once("src/connections.php");

if (!isset($_SESSION['userId']) && !isset($_SESSION['adminId'])) {
    header("Location: login.php");
}

if (isset($_GET['id']) && is_numeric($_GET['id'])):
    $id = $_GET['id'];
    $commentToEdit = Comment::LoadCommentById($id);

    if ($commentToEdit->getUserId() == $_SESSION['userId'] || isset($_SESSION['adminId'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $commentText = $_POST['commentText'];
            if (Security::SanitizeString($commentText) && Security::IsValid($commentText)) {
                if ($commentToEdit->updateComment($commentText)) {
                    echo("Comment updated:");
                } else {
                    echo("Couldn't update comment");
                }
            } else {
                echo("New comment is not valid. Please try again.");
            }
        }

        echo("
        <div class='container'>
            <h3>Edit comment:</h3>
            <form action='editComment.php?id=$id' method='post'>
                <label>
                    <input type='text' name='commentText' value='{$commentToEdit->getCommentText()}'>
                </label>
                <input type='submit'>
            </form>
        </div>
            ");

    }

endif;

require_once("src/nav.php");