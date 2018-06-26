<?php

use Simpleframework\Applib\Controller;
use Simpleframework\Helpers\Util;
use Simpleframework\Middleware\Sanitize;

Util::startSession();
class Users extends Controller
{
    private const EMAIL = 'email';
    private const EMAIL_ERR = 'email_err';
    private const PASSWORD = 'password';
    private const PASSWORD_ERR = 'password_err';
    private const USERLOGIN = 'users/login';
    
    public function __construct()
    { 
        $this->userModel = $this->model('User');
    }
    
    public function login()
    {
        if (Util::isPOST())
        {
            $_post = Sanitize::cleanInputArray(INPUT_POST);
            
            $data =[
                self::EMAIL => trim($_post[self::EMAIL]),
                self::PASSWORD => trim($_post[self::PASSWORD]),
                self::EMAIL_ERR => '',
                self::PASSWORD_ERR => '',
            ];
            
            if (empty($data[self::EMAIL]))
            {
                $data[self::EMAIL_ERR] = 'Ange användarenamn';
            }
            
            if (empty($data[self::PASSWORD]))
            {
                $data[self::PASSWORD_ERR] = 'Ange lösenord';
            }
            
            if (empty($data['email_err']) && empty($data['password_err']))
            {
                $loggedInuser = $this->userModel->login($data['email'],$data['password']);
                
 
                if ($loggedInuser)
                {
                    $_SESSION['userlogin'] = true;
                    
                    util::redirect('shops/index');
                    
                }
                else
                {
                    if (isset($_SESSION['userBlocked']) && $_SESSION['userBlocked'])
                    {
                        $error = 'Konto är blockat';
                    }
                    else
                    {
                        $error = 'Fel användare eller lösenord';
                    }
                    $data[self::PASSWORD_ERR] = $error;
                    $this->view(self::USERLOGIN,$data);
                }
                
                $this->view(self::USERLOGIN,$data);
            }
            
            $this->view(self::USERLOGIN,$data);
            
        }
        else
        {
            $data =[
                self::EMAIL => '',
                self::PASSWORD => '',
                self::EMAIL_ERR => '',
                self::PASSWORD_ERR => '',
            ];
            
            $this->view(self::USERLOGIN,$data);
        }
        
    }
    
    public function logout()
    {
        session_regenerate_id(true);
        unset($_SESSION['userlogin']);
        $_SESSION = array();
        unset( $_SESSION);
        util::redirect('Shop');
    }
    
}