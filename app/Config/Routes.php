<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('auth/login', 'AuthController::login');
$routes->get('auth/logout', 'AuthController::logout'); 

$routes->group('/', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->presenter("ventas", ['controller' => 'Ventas', 'only' => ['index', 'show', 'new', 'create', 'edit', 'update', 'delete']]);
});