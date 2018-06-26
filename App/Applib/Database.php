<?php

namespace Simpleframework\Applib;

class Database 
{
    
    protected $dbh;
    protected $stmt;
    protected $error;
    
    public function __construct($dbconfig)
    {
        $this->dbh = DBconnection::getDB($dbconfig);
    }
    
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    
    public function bind($param,$value,$type = null)
    {
        if (is_null($type))
        {
            switch($type)
            {
                case is_int($value): $type = \PDO::PARAM_INT; break;
                case is_bool($value): $type = \PDO::PARAM_BOOL; break;
                case is_null($value): $type = \PDO::PARAM_NULL; break;
                default:  $type = \PDO::PARAM_STR; break; 
            }
        }
        
        $this->stmt->bindValue($param, $value,$type);
    }
    
    public function execute()
    {
        return $this->stmt->execute();
    }
    
    public function resultSet($feth = \PDO::FETCH_OBJ)
    {
        $this->execute();
        return $this->stmt->fetchAll($feth);
    }
    
    public function single($feth = \PDO::FETCH_OBJ)
    {
        $this->execute();
        $ret = $this->stmt->fetch($feth);
        $this->stmt->closeCursor();
        return $ret;
        
    }
    
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    
    public function getLastID()
    {
        return $this->con->lastInsertId();
    }
}