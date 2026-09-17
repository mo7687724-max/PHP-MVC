<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$router->dispatch();

