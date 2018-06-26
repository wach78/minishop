<?php
/**
 * Base Contoller
 * Loads the models and views
 */
namespace Simpleframework\Applib;
class Controller
{
    private const FILETYPE = '.php';   
    protected function model($model)
    {
        $path = '..' .DS. 'App'. DS. 'Models' . DS. $model . self::FILETYPE;
        require_once $path;
        return new $model();
    }
    
    protected function view($view,$data = [])
    {
        $path = '..' .DS. 'App' .DS .'Views' .DS. $view .self::FILETYPE;
        if (file_exists($path))
        {
            require_once $path;
        }
        else
        {
            die('View does not exits');
        }
    }
}