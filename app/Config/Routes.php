<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//login/registration route and user validation
$routes->post('api/login', 'AuthController::userLogin');
$routes->post('api/register', 'AuthController::registerUser');


// **** GLOBAL API ENDPOINTS **** //
//show menu without auth
$routes->get('api/menu', 'MenuController::index');
//show category without auth
$routes->get('categories', 'CategoryController::index');
$routes->get('category/(:segment)', 'CategoryController::show/$1');
// Orders API endpoints No Auth/Token | Optional maybe later will be added
$routes->group('api', function($routes) {

    //show menu
    $routes->get('menu', 'MenuController::index');

    // orders api endpoint
    $routes->group('', function($routes) {
        $routes->get('orders', 'OrdersController::showOrders');
        $routes->post('orders', 'OrdersController::createOrder');
    });

    // customers api endpoint
    $routes->group('', function($routes) {
        $routes->get('orders/yourorder/(:segment)', 'CustomerController::checkOrderStatus/$1'); // instead of :customer_id use (:segment) as :customer_id is not a valid syntax for codeigniter4! correct params (:segment) (:num)'
        $routes->get('orders/yourorder/(:segment)/status', 'CustomerController::checkSpecificOrderStatus/$1');
        $routes->put('orders/yourorder/(:segment)/updateorder', 'CustomerController::updateOrder');
    });
});
// **** GLOBAL API ENDPOINTS **** //


// ** !! ADMIN ONLY!! API ENDPOINTS *** //
//Menu, Category, User api endpoints | On Admin | Protected Auth Routes
$routes->group('api',  function($routes) {

    //menu api endpoints
    $routes->group('admin', ['filter' => 'auth'], function($routes) {
        $routes->get('menu', 'MenuController::index');
        $routes->get('menu/(:segment)', 'Admin\MenuController::show/$1');
        $routes->post('menu', 'Admin\MenuController::create');
        $routes->put('menu/(:segment)', 'Admin\MenuController::update/$1');
        $routes->delete('menu/(:segment)', 'Admin\MenuController::delete/$1');
    });

    //category api endpoints
    $routes->group('admin', ['filter' => 'auth'], function($routes) {
        $routes->get('category', 'CategoryController::index');
        $routes->get('category/(:segment)', 'CategoryController::show/$1');
        $routes->post('category/newcategory', 'CategoryController::create');
        $routes->put('category/(:segment)', 'CategoryController::update/$1');
        $routes->delete('category/(:segment)', 'CategoryController::delete/$1');
    });

    // Protected routes with auth filter
    $routes->group('admin', ['filter' => 'auth'], function ($routes) {
        $routes->get('user/(:num)', 'Admin\UserController::getUser/$1');
        $routes->post('user/(:num)', 'Admin\UserController::update/$1');
        $routes->resource('user', ['controller' => 'Admin\UserController']);
    });

    // CHEF Endpoint
    // $routes->group('chef', ['filter' => 'auth'], function ($routes) {
    //     $routes->get('orders/(:num)', 'Chef\UserController::showOrders');
    //     $routes->post('orders/(:num)', 'Chef\UserController::update/$1');
    //     $routes->resource('order', ['controller' => 'Admin\UserController']);
    // });
});

// ** !! ADMIN ONLY!! API ENDPOINTS *** //

