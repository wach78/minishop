<?php
use Simpleframework\Applib\Database;
use Simpleframework\Helpers\Util;

Util::startSession();

class User extends Database
{
    private const PARAMUSERNAME = ':username';
    
    private const DBHASH = PASSWORD_ARGON2I;
    private const DBHASHOPTIONS = [
        'memory_cost' => 1<<17, // 128 Mb
        'time_cost'   => 8,
        'threads'     => 3,
    ];
    
    
    public  function __construct()
    {
        parent::__construct(DBCONFIG);
    }
    
    
    private function hashPass($pass): string
    {
        return password_hash($pass, self::DBHASH, self::DBHASHOPTIONS);
    }
    
    private function getHash($username)
    {
        $query = 'SELECT pass FROM users WHERE Username = :username';
        $this->query($query);
        $this->bind(self::PARAMUSERNAME,$username);
        $this->execute();
        $result =  $this->single();
        
        if (!empty($result))
        {
            return $result->pass;
        }
    }
    
    public function checkIfUserExits($username)
    {
        $query = 'SELECT COUNT(ID) AS n FROM users WHERE Username = :username';
        
        $this->query($query);
        $this->bind(self::PARAMUSERNAME,$username);
        $this->execute();
        $result =  $this->single();
        
        return $result->n > 0;
    }
    
    public function createUser($username,$pass)
    {
        if (!$this->checkIfUserExits($username))
        {
            $pass =  $this->hashPass($pass);
            $query = 'INSERT INTO users (Username,Pass) VALUES (?,?)';
            $this->query($query);
            $this->bind(1,$username);
            $this->bind(2,$pass);
            $this->execute();
        }
        else
        {
            return false;
        }
    }
    
    public function verifiedPass($pass,$username)
    {
        $username = trim($username);
        $hash = $this->getHash($username);
        return password_verify($pass, $hash);
    }
    
    private function rehash($username,$pass,$userID)
    {
        $hash = $this->getHash($username);
        if (password_needs_rehash($hash, self::DBHASH, self::DBHASHOPTIONS))
        {
            $this->changePassword($userID,$pass);
        }
    }
    
    private function addingNumberOfLogonAttempt($username)
    {
        $query = "UPDATE users SET NumberOfLoginAttempt = NumberOfLoginAttempt+1 WHERE Username = :username";
        $this->query($query);
        $this->bind(self::PARAMUSERNAME,$username);
        $this->execute();
    }
    
    private function blockUser($username)
    {
        $query =  "UPDATE users SET IsBlocked = :isBlocked WHERE Username = :username AND NumberOfLoginAttempt >= :attempt ";
        $isBlocked = 1;
        $attempt = 5;
        $this->query($query);
        $this->bind(':isBlocked',$isBlocked);
        $this->bind(self::PARAMUSERNAME,$username);
        $this->bind(':attempt',$attempt);
        $this->execute();
        
        return $this->rowCount();
    }
    
    private function zeroNumberOfLogonAttempt($username)
    {
        $query = "UPDATE users SET NumberOfLoginAttempt = :zero WHERE Username = :username";
        $zero = 0;
        $this->query($query);
        $this->bind(':zero',$zero);
        $this->bind(self::PARAMUSERNAME,$username);
        $this->execute();
    }
    
    private function isUserBlocked($username)
    {
        $query = 'SELECT IsBlocked FROM users WHERE Username = :username';
        $this->query($query);
        $this->bind(self::PARAMUSERNAME,$username);
        $this->execute();
    }
    
    public function login($username,$pass)
    {
        $loginOK = false;
        
        if ($this->isUserBlocked($username))
        {
            $_SESSION['userBlocked'] = true;
            return false;
        }
        
        // $this->createUser($username, 'abc123');
        
        $userallowed = $this->verifiedPass($pass, $username);
        
        $this->createUser('minishop@vadman.nu', 'abc123');
        
        if ($userallowed)
        {
            $query = " SELECT ID FROM users WHERE Username = :username AND IsBlocked  = :isBlocked";
            
            $isBlocked = 0;
            
            $this->query($query);
            $this->bind(self::PARAMUSERNAME,$username,PDO::PARAM_STR);
            $this->bind(':isBlocked',$isBlocked,PDO::PARAM_INT);
            
            $this->execute();
            
            $result = $this->single();
            
            $userID = isset($result->ID) ? $result->ID : 0 ;
            
            $this->rehash($username, $pass,$userID);
            

            if ($userID != 0)
            {
                $this->zeroNumberOfLogonAttempt($username);
                $_SESSION['UserID'] = (int)$userID;
                
                $loginOK = true;
            }
            else
            {
                $loginOK = false;
            }
        }
        else
        {
            $this->addingNumberOfLogonAttempt($username);
        }
        
        $blocked = $this->blockUser($username);
        
        
        
        if ($blocked == 1)
        {
            $_SESSION['userBlocked'] = true;
            return false;
        }
        
        return $loginOK;
    }
    
    
    
}