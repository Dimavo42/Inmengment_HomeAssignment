<?php

use App\controllers\HomeController;
use App\controllers\TableController;
use App\controllers\UserController;
use App\main\AppStartPoint;
use App\router\Router;


require __DIR__ .'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH',__DIR__ .'/../views');


$router = new Router();


$router->get('/',[HomeController::class,'index'])
->get('/birthday',[UserController::class,'index'])
->get('/table',[TableController::class,'index']);



 (new AppStartPoint($router,['uri'=>$_SERVER['REQUEST_URI'],'method'=>$_SERVER['REQUEST_METHOD']]))->run();





