<?php
?>

<html>
<head>

    <link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='styles/css/mystyles.css'>

</head>

<?php
$userToUse = $_SESSION['userId'];

if(isset($_SESSION['userId'])): ?>

    <ul class="nav nav-tabs">

        <li><a id="main" href=#>Profile</a></li>
        <li><a id="messages" href=#>Messages</a></li>
        <li><a id="users" href=#>Bloggers</a></li>
        <li><a id="tweets" href=#>Your blog</a></li>
        <li><a id="logout" href='../blog/logout.php'>Wyloguj</a></li>
    </ul>



<?php endif; ?>