<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// API route
$routes->get('api/users/(:num)', 'UserController::show/$1');
$routes->post('api/users', 'UserController::create');
