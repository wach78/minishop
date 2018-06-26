<?php

$dotenv = new Dotenv\Dotenv('../../../env/minishop/');
$dotenv->load();

$urlroot = getenv('URLROOT');


define('APPROOT',dirname(dirname(__FILE__)));
define('URLROOT',$urlroot);
define('SITENAME','minishop');
define('VIEWINCLUDE',APPROOT.DS.'Views'.DS.'inc'.DS);
define('HELPERS',APPROOT.DS.'Helpers');
define('APPLIB',APPROOT .DS.'Applib');
define('RBAC',APPROOT .DS.'RBAC');
define('MODELS',APPROOT .DS . 'Models');
define('MIDDLEWARE',APPROOT . DS.'Middleware' .DS);
define('CONTOLLER',APPROOT.DS.'Controller');

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$charset = 'utf8mb4';
$port = getenv('DB_PORT');


$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

define('DBCONFIG',['dbname' => $db, 'dsn'=> $dsn,'dbuser' => getenv('DB_USER'), 'dbpass' => getenv('DB_PASS')]);










