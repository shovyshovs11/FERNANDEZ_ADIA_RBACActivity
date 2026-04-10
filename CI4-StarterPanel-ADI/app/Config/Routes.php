<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::index');
$routes->get('logout', 'Auth::logout');
$routes->get('blocked', 'Auth::forbiddenPage');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registration');

$routes->get('dashboard', 'Home::index');
$routes->get('dashboard-v2', 'Home::dashboardV2');
$routes->get('dashboard-v3', 'Home::dashboardV3');

// STUDENT ROUTES
$routes->get('students', 'Student::index');
$routes->post('student/store', 'Student::store');
$routes->post('student/delete/(:num)', 'Student::delete/$1');

// Setting Routes
$routes->group('users', static function ($routes) {
    $routes->get('/', 'Settings::users');
    $routes->post('create-role', 'Settings::createRole');
    $routes->post('update-role', 'Settings::updateRole');
    $routes->delete('delete-role/(:num)', 'Settings::deleteRole/$1');

    $routes->get('role-access', 'Settings::roleAccess');
    $routes->post('create-user', 'Settings::createUser');
    $routes->post('update-user', 'Settings::updateUser');
    $routes->delete('delete-user/(:num)', 'Settings::deleteUser/$1');

    $routes->post('change-menu-permission', 'Settings::changeMenuPermission');
    $routes->post('change-menu-category-permission', 'Settings::changeMenuCategoryPermission');
    $routes->post('change-submenu-permission', 'Settings::changeSubMenuPermission');
});

$routes->group('menu-management', static function ($routes) {
    $routes->get('/', 'Settings::menuManagement');
    $routes->post('create-menu-category', 'Settings::createMenuCategory');
    $routes->post('create-menu', 'Settings::createMenu');
    $routes->post('create-submenu', 'Settings::createSubMenu');
});

$routes->get('menu','Menu::index');

//CRUD ROUTES
$routes->get('records', 'RecordController::index');
$routes->get('records/create', 'RecordController::create');
$routes->post('records/store', 'RecordController::store');
$routes->get('records/show/(:num)', 'RecordController::show/$1');
$routes->get('records/edit/(:num)', 'RecordController::edit/$1');
$routes->post('records/update/(:num)', 'RecordController::update/$1');
$routes->get('records/delete/(:num)', 'RecordController::delete/$1');