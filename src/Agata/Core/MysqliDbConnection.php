<?php

namespace Agata\Core;

use Agata\Services\MysqliDatabaseConnector;

class MysqliDbConnection
{
     /**
      * @var \mysqli
      */
    protected  $db;
    
    public function __construct()
    {
        $dbConnection = MysqliDatabaseConnector::loadDb();
        $this->db = $dbConnection;

        return $this->db;
    }
}