<?php

require_once("src/connections.php");
require_once("src/nav.php");

$users = User::GetAllUsers();
//var_dump($users);

foreach ($users as $user) {
    $userId = $user->getId();
    echo('<h2>' . ucfirst($user->getName()) . '</h2>');
    echo sprintf("<a href='%s'>Show posts</a><br>", Param::url(false, ['id' => $userId]));
    echo sprintf("<a href='%s'>Show profile</a><br><hr>", Param::url(false, ['action' => 'profile', 'id' => $userId]));
}