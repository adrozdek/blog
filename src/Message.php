<?php

class Message
{

    static private $connection = null;

    static public function SetConnection(mysqli $connection)
    {
        Message::$connection = $connection;
    }
}