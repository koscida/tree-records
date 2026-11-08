<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Files;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');


$routes->get('files/new', 'Files::new');
$routes->post('files/upload', 'Files::upload');
$routes->post('files/delete/(:num)', 'Files::delete/$1');
$routes->get('files', 'Files::index');

$routes->get('fileRows/bulkNew/(:num)', 'FileRows::bulkNew');