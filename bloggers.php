<?php

require_once("src/connections.php");
require_once("src/nav.php");

$users = User::GetAllUsers();
//var_dump($users);

foreach ($users as $user) {
    $userId = $user->getId();
    echo('<h2>' . ucfirst($user->getName()) . '</h2>');
    echo("<a href='blog.php?id=$userId'>Show posts</a><br>");
    echo("<a href='profile.php?id=$userId'>Show profile</a><br><hr>");
}