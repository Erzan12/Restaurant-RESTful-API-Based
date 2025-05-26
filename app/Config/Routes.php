<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//login/registration route and user validation
$routes->post('api/login', 'AuthController::userLogin');
$routes->post('api/register', 'AuthController::registerUser');

//can be access without token | For the Menu so customer can see menu without token
$routes->get('api/menu', 'MenuController::index');

// Admin Control API endpoints
$routes->group('api/admin', function($routes) {

    // Auth routes here...

    // Protected routes with auth filter
    $routes->group('', ['filter' => 'auth'], function ($routes) {
        $routes->get('user/(:num)', 'Admin\UserController::getUser/$1');
        $routes->post('user/(:num)', 'Admin\UserController::update/$1');
        $routes->resource('user', ['controller' => 'Admin\UserController']);
    });

    // Public or unprotected route (adjust filter as needed)

    // Protected menu routes
    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->get('menu', 'Admin\MenuController::index');
        $routes->post('menu', 'Admin\MenuController::create');
        $routes->put('menu/(:num)', 'Admin\MenuController::update/$1');
        $routes->delete('menu/(:num)', 'Admin\MenuController::delete/$1');
    });

});

