<?php

use App\controllers\HomeController;
use App\controllers\TableController;
use App\controllers\UserController;
use App\main\AppStartPoint;
use App\router\Router;

// The MVC pattern design has been implemented with the Model-View-Controller architecture
require __DIR__ .'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH',__DIR__ .'/../views');


$router = new Router();

//Home localhost getting  all users and posts that active->localhost:8000/
//Birthday not working route becasus i dont have birthdays in DB->localhost:8000/birthday
//Table route showing the maxuim posts for time and date and grouped by ->localhost:8000/table
$router->get('/',[HomeController::class,'index'])
->get('/birthday',[UserController::class,'index'])
->get('/table',[TableController::class,'index']);



 (new AppStartPoint($router,['uri'=>$_SERVER['REQUEST_URI'],'method'=>$_SERVER['REQUEST_METHOD']]))->run();





