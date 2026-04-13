<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Auth::login', ['filter' => 'guest']);
$routes->get('login', 'Auth::login', ['filter' => 'guest']);
$routes->post('login', 'Auth::attemptLogin', ['filter' => 'guest']);
$routes->get('register', 'Auth::register', ['filter' => 'guest']);
$routes->post('register', 'Auth::attemptRegister', ['filter' => 'guest']);
$routes->get('logout', 'Auth::logout');
$routes->get('unauthorized', 'Auth::unauthorized');

$routes->group('', ['filter' => 'auth|student'], function ($routes) {
    $routes->get('student/dashboard', 'StudentController::dashboard');
    $routes->get('profile', 'Profile::show');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
});

$routes->group('', ['filter' => 'auth|teacher'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('records', 'Records::index');
    $routes->get('records/create', 'Records::create');
    $routes->post('records/store', 'Records::store');
    $routes->get('records/show/(:num)', 'Records::show/$1');
    $routes->get('records/edit/(:num)', 'Records::edit/$1');
    $routes->post('records/update/(:num)', 'Records::update/$1');
    $routes->get('records/delete/(:num)', 'Records::delete/$1');
    $routes->get('students', 'StudentManagementController::index');
    $routes->get('students/show/(:num)', 'StudentManagementController::show/$1');
});

$routes->group('admin', ['filter' => 'auth|admin'], function ($routes) {
    $routes->get('roles', 'Admin\RoleController::index');
    $routes->get('roles/create', 'Admin\RoleController::create');
    $routes->post('roles/store', 'Admin\RoleController::store');
    $routes->get('roles/edit/(:num)', 'Admin\RoleController::edit/$1');
    $routes->post('roles/update/(:num)', 'Admin\RoleController::update/$1');
    $routes->get('roles/delete/(:num)', 'Admin\RoleController::delete/$1');
    $routes->get('users', 'Admin\UserAdminController::index');
    $routes->post('users/assign-role/(:num)', 'Admin\UserAdminController::assignRole/$1');
});