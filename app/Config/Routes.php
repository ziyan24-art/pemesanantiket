<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::processLogin');

$routes->get('/logout', 'Auth::logout');
// Dashboard route
$routes->get('dashboard', 'Dashboard::index');



// route admin

$routes->get('messages', 'Admin\EticketController::index');
$routes->post('messages/search', 'Admin\EticketController::search');
$routes->post('messages/confirm', 'Admin\EticketController::confirm');


$routes->group('admin', function ($routes) {
    $routes->get('rute', 'Admin\RuteController::index');
    $routes->get('rute/create', 'Admin\RuteController::create');
    $routes->post('rute/store', 'Admin\RuteController::store');
    $routes->get('rute/edit/(:num)', 'Admin\RuteController::edit/$1');
    $routes->post('rute/update/(:num)', 'Admin\RuteController::update/$1');
    $routes->get('rute/delete/(:num)', 'Admin\RuteController::delete/$1');
});

$routes->group('admin/users', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'Admin\UserController::index');
    $routes->get('create', 'Admin\UserController::create');
    $routes->post('store', 'Admin\UserController::store');
    $routes->get('edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('delete/(:num)', 'Admin\UserController::delete/$1');
});
$routes->group('admin', function ($routes) {
    $routes->get('popular-ticket', 'Admin\PopularTicketController::index');
    $routes->get('popular-ticket/create', 'Admin\PopularTicketController::create');
    $routes->post('popular-ticket/store', 'Admin\PopularTicketController::store');
    $routes->get('popular-ticket/edit/(:num)', 'Admin\PopularTicketController::edit/$1');
    $routes->post('popular-ticket/update/(:num)', 'Admin\PopularTicketController::update/$1');
    $routes->get('popular-ticket/delete/(:num)', 'Admin\PopularTicketController::delete/$1');
});
$routes->group('admin', function ($routes) {
    $routes->get('paymentmethod', 'Admin\PaymentMethod::index');
    $routes->get('paymentmethod/create', 'Admin\PaymentMethod::create');
    $routes->post('paymentmethod/store', 'Admin\PaymentMethod::store');
    $routes->get('paymentmethod/edit/(:num)', 'Admin\PaymentMethod::edit/$1');
    $routes->post('paymentmethod/update/(:num)', 'Admin\PaymentMethod::update/$1');
    $routes->get('paymentmethod/delete/(:num)', 'Admin\PaymentMethod::delete/$1');
});







// user route

$routes->get('user/routes', 'User\RouteController::index');
// Halaman utama user
$routes->get('user/dashboard', 'User\UserController::index');
$routes->get('/booking/form/(:num)', 'Booking::form/$1');

// Booking Form
$routes->get('/booking', 'Booking::index');

// Proses Submit Booking
$routes->post('/booking/submit', 'Booking::submit');

// Halaman Sukses Booking & E-Tiket
$routes->get('/booking/success/(:num)', 'Booking::success/$1');

// Cetak E-Tiket berdasarkan Kode Unik
$routes->get('/booking/print/(:segment)', 'Booking::print/$1');
