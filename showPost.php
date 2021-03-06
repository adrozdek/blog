<?php

use Agata\Models\Post;

require_once("src/connections.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentText = Security::IsValid(Security::SanitizeString($_POST['commentText']));
    if ($commentText) {
        if (Comment::CreateComment($_GET['id'], $commentText)) {
            echo('Comment added.');
        } else {
            echo('Couldn\'t add comment');
        }
    }
}

echo("<div class='container'>");
require_once("src/nav.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $postToShow = Post::LoadPostById($id);
    $userId = (int)($postToShow->getUserId());
    $user = User::GetUserById($userId);

    echo("<h1>" . ucfirst($user->getName()) . "</h1>");
    echo($postToShow->getPostText() . "<br />");
    echo($postToShow->getPostDate() . "<br />");
    if (isset($_SESSION['userId'])) {
        if ($postToShow->getUserId() == $_SESSION['userId'] || isset($_SESSION['adminId'])) {
            echo sprintf("<a href='%s'>Edit</a><br>", Param::url(false, ['action' => 'editPost', 'id' => $id]));
            echo sprintf("<a href='%s'>Remove</a><br>", Param::url(false, ['action' => 'remove', 'idP' => $id]));
        }
    }

    $headline = 'Add comment:';
    $form_action = 'showPost.php?id=' . $id;
    require_once './Template/comment_form.php';

    echo("<h3>Comments: </h3>");
    $comments = $postToShow->getAllComments();
    foreach ($comments as $comment) {
        $userCommentId = $comment->getUserId();
        $commentId = $comment->getId();
        $commentingUser = User::GetUserById($userCommentId);
        echo("<h4>" . ucfirst($commentingUser->getName()) . '</h4>>');
        echo($comment->getCommentText() . '<br>');
        echo($comment->getCommentDate() . '<br>');
        if (isset($_SESSION['userId'])) {
            if ($userCommentId == $_SESSION['userId'] || isset($_SESSION['adminId'])) {
                echo sprintf("<a href='%s'>Edit</a><br>", Param::url(false, ['action' => 'editComment', 'id' => $commentId]));
                echo sprintf("<a href='%s'>Remove</a><br>", Param::url(false, ['action' => 'remove', 'idC' => $commentId]));
            }
        }
        echo("<hr>");
    }
} else {
    echo('Post doesn\'t exist');
}

echo("</div>");

