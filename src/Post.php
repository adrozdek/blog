<?php

class Post
{
    static private $connection = null;

    static public function SetConnection(mysqli $connection)
    {
        Post::$connection = $connection;
    }
}