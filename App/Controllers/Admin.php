<?php

use Simpleframework\Applib\Controller;
use Simpleframework\Helpers\Util;
use Simpleframework\Middleware\Csrf;
use Simpleframework\Middleware\Sanitize;
use Simpleframework\Middleware\Validate;
use Simpleframework\RABC\PrivilegedUser;


class Admin extends Controller
{
    private const NAME = 'Name';
    private const PRICE = 'Price';
    private const STOCK = 'Stock';  
    private const PRODUCTNUMBER = 'Productumber';
    private const DESCRIPTION = 'Description';
    
    private const NAME_ERR = 'Name_err';
    private const PRICE_ERR = 'Price_err';
    private const STOCK_ERR = 'Stock_err';
    private const PRODUCTNUMBER_ERR = 'Productumber_err';
    private const DESCRIPTION_ERR = 'Description_err';
    
  
    public function __construct()
    {
        $privuser = new PrivilegedUser();
        $privuserID = $_SESSION['UserID'] ?? 0;
        $privuser->getPriUserByID($privuserID);
        
        if (!$privuser->hasPrivileage('adminsettings'))
        {
            util::redirect('Shops/index');
        }
        
        $this->adminModel = $this->model('Adminm');
    }
    
    public function addproduct()
    {
        if (util::isPOST())
        {
            Csrf::exitOnCsrfTokenFailure();
            $_post = Sanitize::cleanInputArray(INPUT_POST);
            
            $data = [
                self::NAME => trim($_post[self::NAME]),
                self::PRICE => trim($_post[self::PRICE]),
                self::STOCK => trim($_post[self::STOCK]),
                self::PRODUCTNUMBER => trim($_post[self::PRODUCTNUMBER]),
                self::DESCRIPTION  => trim($_post[self::DESCRIPTION]),
                self::NAME_ERR => '',
                self::PRICE_ERR => '',
                self::STOCK_ERR => '',
                self::PRODUCTNUMBER_ERR => '',
                self::DESCRIPTION_ERR  => '',
            ];
            
            $error = false;
            
            if (empty($data[self::NAME]))
            {
               $data[self::NAME_ERR] = 'Namn kan inte vara tom';
               $error = true;
            }
            
            if (empty($data[self::PRICE]))
            {
                $data[self::PRICE_ERR] = 'Pris kan inte vara tom';
                $error = true;
            }
            
           
  
            if( !Validate::validateFloat($data[self::PRICE]))
            {
                $data[self::PRICE_ERR] = 'Endast siffror (ex 45.50)';
                $error = true;
            }
            
            
            if(!empty($data[self::STOCK]) && !Validate::validateInt ($data[self::STOCK]))
            {
                $data[self::STOCK_ERR] = 'Endast siffror';
                $error = true;
            }
            
            
            
            if($error)
            {
                $this->view('admin/addproduct',$data);
                exit();
            }
            
            
            if ($this->adminModel->addProduct($data))
            {
                util::flash('addpro','Produkt tillagd');
                $this->view('Admin/addproduct',$data);
            }
            
        }
        else 
        {
            
            $data = [
                self::NAME => '',
                self::PRICE => '',
                self::STOCK => '',
                self::PRODUCTNUMBER => '',
                self::DESCRIPTION  => '',
                self::NAME_ERR => '',
                self::PRICE_ERR => '',
                self::STOCK_ERR => '',
                self::PRODUCTNUMBER_ERR => '',
                self::DESCRIPTION_ERR  => '',
            ];
            
            $this->view('admin/addproduct',$data);
        }
    }
    
    public function showproducts()
    {
        $d = $this->adminModel->showAllProducts();
        $columnarr = ['ID', 'Name', 'Productumber','Price', 'Stock',  'Description'];
        
        $data = [
                    'tabledata' => $d,
                    'datacolumns' =>$columnarr 
                ];
        
        $this->view('admin/showproducts',$data);
    }
    
    public function deleteproduct($id)
    {
        if (util::isPOST())
        {
            Csrf::exitOnCsrfTokenFailure();
            
            $id = Sanitize::cleanInt($id);
            
            $this->adminModel->deleteProduct($id);
            
            $d = $this->adminModel->showAllProducts();
            $columnarr = ['ID', 'Name', 'Productumber','Price', 'Stock',  'Description'];
            
            $data = [
                'tabledata' => $d,
                'datacolumns' =>$columnarr
            ];
            
            $this->view('admin/showproducts',$data);
            
        }
    }
    /*
    public function editproduct($id)
    {
        if (util::isPOST())
        {
            Csrf::exitOnCsrfTokenFailure();
            
            $id = Sanitize::cleanInt($id);
            
            $productData = $this->adminModel->getOneProduct($id);
            
            
            $data = [
                self::NAME => Sanitize::cleanOutput($productData->Name),
                self::PRICE => Sanitize::cleanOutput($productData->Price),
                self::STOCK => Sanitize::cleanOutput($productData->Stock),
                self::PRODUCTNUMBER => Sanitize::cleanOutput($productData->Productumber),
                self::DESCRIPTION  => Sanitize::cleanOutput($productData->Description),
                'PID' => $id
            ];
            
            $this->view('admin/editproduct',$data);
           
        }
    }
    */
    
    public function editproduct($id)
    {
        if (util::isPOST() && isset($_POST[self::NAME]))
        {
            Csrf::exitOnCsrfTokenFailure();
            
            $_post = Sanitize::cleanInputArray(INPUT_POST);
           
            $data = [
                'PID' => (int)$_post['PID'],
                self::NAME => trim($_post[self::NAME]),
                self::PRICE => trim($_post[self::PRICE]),
                self::STOCK => trim($_post[self::STOCK]),
                self::PRODUCTNUMBER => trim($_post[self::PRODUCTNUMBER]),
                self::DESCRIPTION  => trim($_post[self::DESCRIPTION]),
                self::NAME_ERR => '',
                self::PRICE_ERR => '',
                self::STOCK_ERR => '',
                self::PRODUCTNUMBER_ERR => '',
                self::DESCRIPTION_ERR  => '',
            ];
      
            $error = false;
            
            if (empty($data[self::NAME]))
            {
                $data[self::NAME_ERR] = 'Namn kan inte vara tom';
                $error = true;
            }
            
            if (empty($data[self::PRICE]))
            {
                $data[self::PRICE_ERR] = 'Pris kan inte vara tom';
                $error = true;
            }
            
            
            
            if( !Validate::validateFloat($data[self::PRICE]))
            {
                $data[self::PRICE_ERR] = 'Endast siffror (ex 45.50)';
                $error = true;
            }
            
            
            if(!empty($data[self::STOCK]) && !Validate::validateInt ($data[self::STOCK]))
            {
                $data[self::STOCK_ERR] = 'Endast siffror';
                $error = true;
            }
       
            
            if($error)
            {
                $this->view('admin/editproduct',$data);
                exit();
            }
           
            if ($this->adminModel->updateProduct($data))
            {
                $d = $this->adminModel->showAllProducts();
                $columnarr = ['ID', 'Name', 'Productumber','Price', 'Stock',  'Description'];
                
                $data = [
                    'tabledata' => $d,
                    'datacolumns' =>$columnarr
                ];
                
                $this->view('admin/showproducts',$data);
            }

        }
        elseif (util::isPOST())
        {
            Csrf::exitOnCsrfTokenFailure();
            
            $id = Sanitize::cleanInt($id);
            
            $productData = $this->adminModel->getOneProduct($id);
            
            
            $data = [
                self::NAME => Sanitize::cleanOutput($productData->Name),
                self::PRICE => Sanitize::cleanOutput($productData->Price),
                self::STOCK => Sanitize::cleanOutput($productData->Stock),
                self::PRODUCTNUMBER => Sanitize::cleanOutput($productData->Productumber),
                self::DESCRIPTION  => Sanitize::cleanOutput($productData->Description),
                'PID' => $id
            ];
            
            $this->view('admin/editproduct',$data);
            
        }
        
    }
    
}

