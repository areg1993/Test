<?php

session_start();

define('ROOT', __DIR__ . '/');
define('VIEWS', ROOT . '../views/');
define('MODELS', ROOT . 'models/');
define('CONTROLLERS', ROOT . 'controllers/');
define("PUBLIC_URL", BASE_URL . "/assets/");
define("JS_URL", PUBLIC_URL . "js/");
define("CSS_URL", PUBLIC_URL . "css/");
define("IMG_URL", PUBLIC_URL . "images/");

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;


$capsule->addConnection([
    "driver" => "mysql",
    "host" => DB_HOST,
    "database" => DB_NAME,
    "username" => DB_USER,
    "password" => DB_PASS
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();