<?php

use Simpleframework\Applib\Controller;



class Errors extends Controller
{
    public function __construct()
    {

    }
    
    public function error()
    {

        $data = [
            'err' => 'något gick fel' ,
        ];
        $this->view('errors/error',$data);
    }
    
    
   
}
