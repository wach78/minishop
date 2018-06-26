<?php

use Simpleframework\Applib\Database;

class Adminm extends Database
{
    public  function __construct()
    {
        parent::__construct(DBCONFIG);
    }
    
    
    public function addProduct($data)
    {
        $query = 'INSERT INTO product (`Name`, `Price`, `Stock`, `Productumber`, `Description`) VALUES (:Name, :Price, :Stock, :Productumber, :Description)';
        $this->query($query);
        $this->bind(':Name',$data['Name']);
        $this->bind(':Price',$data['Price']);
        $this->bind(':Stock',$data['Stock']);
        $this->bind(':Productumber',$data['Productumber']);
        $this->bind(':Description',$data['Description']);
        return $this->execute();  
    }
    
    public function updateProduct($data)
    {
        $query = 'UPDATE product SET `Name` = :Name, `Price` = :Price, `Stock` = :Stock, `Productumber` = :Productumber, `Description` = :Description WHERE ID = :ID';
        $this->query($query);
        $this->bind(':Name',$data['Name']);
        $this->bind(':Price',$data['Price']);
        $this->bind(':Stock',$data['Stock']);
        $this->bind(':Productumber',$data['Productumber']);
        $this->bind(':Description',$data['Description']);
        $this->bind(':ID',$data['PID'],PDO::PARAM_INT);
        return  $this->execute();  
        
        
    }
    
    public function deleteProduct($ID)
    {
        $query = 'DELETE FROM product WHERE ID = :ID';
        $this->query($query);
        $this->bind(':ID',$ID,PDO::PARAM_INT);
        $this->execute();  
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
        $this->bind(':ID', $ID);
        return $this->single();
        
    }
}