<?php

/*
* Mysql database class - only one connection allowed
*/

class Database
{
    private $connection;
    private static $instance = null; //The single instance
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'coderslab';
    private $database = 'blog';

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (self::$instance == null) { // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Private Constructor
    //to prevent initiation with outer code.
    private function __construct()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        mysqli_set_charset($this->connection, 'utf8');

        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
        throw new Exception("Can't clone a singleton");
    }

    // Get mysqli connection
    public function getConnection()
    {
        return $this->connection;
    }


    public function queryParams($query, $types = null, $params = null)
    {
        $connection = $this->getConnection();
        $statement = $connection->prepare($query);
        if ($params != null) {

            $types = $types ?: str_repeat('s', count($params));
            $statement->bind_param($types, ...$params);
        }

        if(!$statement->execute()) {
            return false;
        } else {
            $result = $statement->get_result();
            $statement->close();
            return $result ;
        }

    }

}