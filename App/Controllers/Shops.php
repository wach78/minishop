<?php
use Simpleframework\Applib\Controller;
use Simpleframework\Helpers\Json;
use Simpleframework\Helpers\Util;
use Simpleframework\Middleware\Csrf;
use Simpleframework\Middleware\Sanitize;


class Shops extends Controller
{
    public function __construct()
    {
        $this->shopModel = $this->model('Shop');
    }
    
    public function index()
    {
        
        $d = $this->shopModel->showAllProducts();
        
        $data = [
            'tabledata' => $d,
        ];
        
        $this->view('shop/index',$data);
    }
    
    public function addtochart()
    {
        if (Util::isPOST())
        {
            Csrf::exitOnCsrfTokenFailure();
            
            $_post = Sanitize::cleanInputArray(INPUT_POST);
            
            $ID = (int)$_post['PID'];
            $data = [
                'PID' => $ID
                
                ];
            
        }
    }
    
    public function ajaxgetoneproduct()
    {
        if (Util::isPOST())
        {
            Csrf::exitOnCsrfTokenFailure();
            
            $_post = Sanitize::cleanInputArray(INPUT_POST);
            
            $ID = (int)$_post['PID'];
            $d = $this->shopModel->getOneProduct($ID);
         
            echo Json::toJson($d);
            
        }
    }
}