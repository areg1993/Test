<?php

use App\Core\Router;
$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('sign_in', ['controller' => 'User', 'action' => 'signIn']);
$router->add('login', ['controller' => 'User', 'action' => 'login']);
$router->add('logout', ['controller' => 'User', 'action' => 'logout']);
$router->add('getTasks', ['controller' => 'Tasks', 'action' => 'index']);
$router->add('addTask', ['controller' => 'Tasks', 'action' => 'create']);
$router->add('getTask', ['controller' => 'Tasks', 'action' => 'getTask']);
$router->add('editTask', ['controller' => 'Tasks', 'action' => 'editTask']);

$router->dispatch();
