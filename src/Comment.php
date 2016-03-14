<?php

class Comment
{

    static private $connection = null;

    static public function SetConnection(mysqli $connection)
    {
        Comment::$connection = $connection;
    }


}