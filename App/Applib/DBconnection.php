<?php
namespace Simpleframework\Applib;


abstract class DBconnection
{
    private static $connections = [];
    private static function createDatabas($config)
    { 
       $opt = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_EMULATE_PREPARES   => false,
              ];
       
       try
       {
           return new \PDO($config['dsn'], $config['dbuser'], $config['dbpass'], $opt);
           
       }
       catch(\PDOException $ex)
       {
           var_dump($ex->getMessage());
       } 
    }

    public static function getDB(array $config)
    {
        if (!isset(self::$connections[$config['dbname']]))
        {
            self::$connections[$config['dbname']] = self::createDatabas($config);
        }
        
        return self::$connections[$config['dbname']]; 
    }
    
  
    private function __clone() 
    { 
        // Magic method clone is empty to prevent duplication of connection
    }
}