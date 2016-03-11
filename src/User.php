<?php

class User
{
    static private $connection = null;

    static public function SetConnection(mysqli $connection)
    {
        User::$connection = $connection;
    }

}