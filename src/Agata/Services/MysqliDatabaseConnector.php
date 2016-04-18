<?php

namespace Agata\Services;


use Agata\Core\IDbLoader;

/*
* Mysql database class - only one connection allowed
*/
class MysqliDatabaseConnector implements IDbLoader
{
    private $connection;
    private static $instance = null; //The single instance
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'blog';

    // Private Constructor
    //to prevent initiation with outer code.
    private function __construct()
    {
        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database);
        mysqli_set_charset($this->connection, 'utf8');

        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
        throw new \Exception("Can't clone a singleton");
    }

    //Get an instance of the Database
    /**
     * @return \mysqli
     */
    public static function loadDb()
    {
        if (self::$instance == null) { // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get mysqli connection
    public function getConnection()
    {
        return $this->connection;
    }

    private function refValues($arr)
    {
        if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach ($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

    public function queryParams($query, $params = null)
    {
        $connection = $this->getConnection();
        $statement = $connection->prepare($query);

        if ($params != null) {
//   od 5.6?   $types = $types ?: str_repeat('s', count($params));
//            $statement->bind_param($types, ...$params);

            $params = array_merge(array(str_repeat('s', count($params))), $params);
            //var_dump($params);

            call_user_func_array(array(&$statement, 'bind_param'), $this->refValues($params));
        }

        if ($statement->execute()) {
            $result = $statement->get_result();
            //var_dump($result);
            $statement->close();

            if ($result == false) {
                return true;
            }
            return $result;
        }
        return false;
    }
}