<?php
?>

    <html>
    <head>

        <link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='styles/css/mystyles.css'>

    </head>

<?php

if (isset($_SESSION['userId'])): ?>

    <ul class="nav nav-tabs">

        <li><a id="main" href='./profile.php'>Profile</a></li>
        <li><a id="users" href='./bloggers.php'>Bloggers</a></li>
        <li><a id="tweets" href='./index.php'>Your blog</a></li>
        <li><form action="./search.php"><label>Search by title: <input type="text" name="search"></label><input type="submit"></form></li>
        <li><a id="logout" href='./logout.php'>Logout</a></li>
    </ul>

    <?php else: ?>

    <ul class="nav nav-tabs">
        <li><a id="users" href='./bloggers.php'>Bloggers</a></li>
        <li><form action="search.php"><label>Search by title: <input type="text" name="search"></label></form></li>
        <li><a id="logout" href='./login.php'>Login</a></li>
    </ul>


<?php endif; ?>