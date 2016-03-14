<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . "/User.php");
require_once(dirname(__FILE__) . "/Post.php");
require_once(dirname(__FILE__) . "/Comment.php");
require_once(dirname(__FILE__) . "/Message.php");
require_once(dirname(__FILE__) . "/Security.php");


$connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if($connection->connect_errno){
    die("Db connection not initialized properly " . $connection->connect_error);
}

User::SetConnection($connection);
Post::SetConnection($connection);
Comment::SetConnection($connection);
Message::SetConnection($connection);


