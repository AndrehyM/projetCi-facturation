<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Page par défaut
$route['default_controller'] = 'Welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// 🔹 Authentification
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';
$route['auth/forgot_password'] = 'auth/forgot_password';
$route['auth/reset_password/(:any)'] = 'auth/reset_password/$1';

// 🔹 Dashboard selon rôle
$route['admin/dashboard'] = 'dashboard/admin';    // contrôleur Dashboard/Admin
$route['user/dashboard'] = 'dashboard/user';      // contrôleur Dashboard/User

// 🔹 Gestion clients
$route['clients'] = 'clients/index';
$route['clients/add'] = 'clients/add';
$route['clients/edit/(:num)'] = 'clients/edit/$1';
$route['clients/delete/(:num)'] = 'clients/delete/$1';

// 🔹 Gestion catégories
$route['categories'] = 'categories/index';
$route['categories/add'] = 'categories/add';
$route['categories/edit/(:num)'] = 'categories/edit/$1';
$route['categories/delete/(:num)'] = 'categories/delete/$1';

// 🔹 Gestion produits
$route['products'] = 'products/index';
$route['products/add'] = 'products/add';
$route['products/edit/(:num)'] = 'products/edit/$1';
$route['products/delete/(:num)'] = 'products/delete/$1';

// 🔹 Gestion factures
$route['factures'] = 'factures/index';
$route['factures/add'] = 'factures/add';
$route['factures/view/(:num)'] = 'factures/view/$1';
$route['factures/delete/(:num)'] = 'factures/delete/$1';
