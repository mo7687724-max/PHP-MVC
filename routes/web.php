<?php

/*
|--------------------------------------------------------------------------
| Home & Auth
|--------------------------------------------------------------------------
*/

$router->get(
    '/',
    [HomeController::class, 'index']
);

$router->get(
    '/login',
    [HomeController::class, 'login']
);

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/

$router->get(
    '/users',
    [UserController::class, 'index'],
    [Authenticate::class]
);

$router->get(
    '/users/show',
    [UserController::class, 'show'],
    [Authenticate::class]
);

$router->get(
    '/users/create',
    [UserController::class, 'create'],
    [Authenticate::class]
);

$router->post(
    '/users',
    [UserController::class, 'store'],
    [Authenticate::class]
);

$router->get(
    '/users/edit',
    [UserController::class, 'edit'],
    [Authenticate::class]
);

$router->post(
    '/users/update',
    [UserController::class, 'update'],
    [Authenticate::class]
);

$router->post(
    '/users/delete',
    [UserController::class, 'delete'],
    [Authenticate::class]
);

