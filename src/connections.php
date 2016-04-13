<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__DIR__) . "/Models/User.php");
require_once(dirname(__DIR__) . "/Models/Post.php");
require_once(dirname(__DIR__) . "/Models/Comment.php");
require_once(dirname(__FILE__) . "/Security.php");
require_once(dirname(__DIR__) . "/Models/Admin.php");
require_once(dirname(__DIR__) . "/Models/Application.php");

$connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($connection->connect_errno) {
    die("Db connection not initialized properly " . $connection->connect_error);
}


\Models\Post::SetConnection($connection);
Comment::SetConnection($connection);
Admin::SetConnection($connection);



