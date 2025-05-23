<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// // API route
// $routes->get('api/users/(:num)', 'UserController::getUser/$1');
// $routes->get('api/users', 'UserController::getAllUsers');
// $routes->post('api/users', 'UserController::createUser');
// $routes->put('api/users/(:num)', 'UserController::updateUser/$1');
// $routes->delete('api/users/(:num)', 'UserController::deleteUser/$1');

//login/registration route and user validation
$routes->post('login', 'AuthController::userLogin');
$routes->post('register', 'AuthController::registerUser');

// API route with JWT auth
$routes->group('api', ['filter' => 'auth'], function ($routes) {
    $routes->get('users/(:num)', 'UserController::getUser/$1');
    $routes->resource('users', ['controller' => 'UserController']);
});


