<?php

require_once("src/connections.php");
require_once("src/nav.php");

if (isset($_SESSION['userId']) != true) {
    header("Location: login.php");
}

echo("<div class='container'>");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $postToShow = Post::LoadPostById($id);

    $userId = (int)($postToShow->getUserId());
    $user = User::GetUserById($userId);

    echo("<h1> {$user->getName()}</h1>");
    echo($postToShow->getPostText() . "<br />");
    echo($postToShow->getPostDate() . "<br />");

    echo("
        <form method='post'>
            <label>
                <input type='text' name='comment' placeholder='write your comment'>
            </label>
            <input type='submit'>
        </form>
    ");

}
echo("</div>");


?>

