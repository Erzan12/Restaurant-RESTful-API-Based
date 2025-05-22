<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// API route
$routes->get('api/users/(:num)', 'UserController::getUser/$1');
$routes->get('api/users', 'UserController::getAllUsers');
$routes->post('api/users', 'UserController::create');
