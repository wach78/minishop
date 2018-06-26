<?php
use Simpleframework\Applib\Database;



class Shop extends Database
{
    public  function __construct()
    {
        parent::__construct(DBCONFIG);
    }
    
    public function showAllProducts()
    {
        $query = 'SELECT `ID`, `Name`, `Price`, `Stock`, `Productumber`, `Description` FROM product';
        $this->query($query);
        return $this->resultSet();
    }
    
    public function getOneProduct($ID)
    {
        $query = 'SELECT `ID`, `Name`, `Price`, `Stock`, `Productumber`, `Description` FROM product WHERE ID = :ID';
        $this->query($query);
        $this->bind(':ID', $ID,PDO::PARAM_INT);
        return $this->single(PDO::FETCH_ASSOC);
        
    }
    
    
}