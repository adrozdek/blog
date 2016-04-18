<?php

namespace Agata\Core;

use Agata\Services\MysqliDatabaseConnector;

class DbConnection
{
     /**
      * @var \mysqli
      */
    protected  $db;
    
    public function __construct()
    {
        $dbInstance = MysqliDatabaseConnector::loadDb();
        $this->db = $dbInstance;

        return $dbInstance;
    }
}