<?php
/**
 * App Core Class
 * Creates URL AND loads core controller
 * URL FORMAT - /controller/method/params
 */
namespace Simpleframework\Applib;
use Simpleframework\Helpers\Util;



class Core
{
    private $currentController = 'Shops';
    private $currentMethod = 'index';
    private $params = [];
    
    private const FILETYPE = '.php';
    public function __construct()
    {
        $url = $this->getUrl();
      
        $file = ucwords(strtolower($url[0]));
        
        if ($url != null && file_exists('../App/Controllers/' .$file.self::FILETYPE))
        {
            $this->currentController = $file;
            unset($url[0]);
            unset($file);
        }
        
      
        require_once '../App/Controllers/'.$this->currentController .self::FILETYPE;
        $this->currentController = new $this->currentController;
        
        
        if (isset($url[1]) && method_exists($this->currentController, $url[1]))
        {
            $this->currentMethod = $url[1];
            unset($url[1]);
           
        }
        
        $this->params = $url ? array_values($url) : [];
        try
        {
            call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
        }
        catch (\ArgumentCountError $ex)
        {
            //Handle exeptions
            Util::redirect('errors/error');
        }
        
    }
    
    private function getUrl()
    {
        $url = null;
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/',$url);    
        }
        return $url;
    }
    
}