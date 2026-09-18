<?php

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

$router->get(
    '/',
    [HomeController::class, 'index']
);

$router->get('/about', [HomeController::class, 'about']);

$router->get('/product', [ProductController::class, 'index']);