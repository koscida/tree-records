<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Files;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// // // //
// Files

// View get all
$routes->get('files', 'Files::index');
// View get one
$routes->get('files/(:num)', 'Files::get/$1');
// View create page
$routes->get('files/new', 'Files::new');

// Create action
$routes->post('files/upload', 'Files::upload');
// Delete action
$routes->post('files/delete/(:num)', 'Files::delete/$1');


// // // //
// File Rows
$routes->get('fileRows/bulkNew/(:num)', 'FileRows::bulkNew');