<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
//$routes->set404Override();
$routes->set404Override(function() {
    return view('errors/html/error_404');
});
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');
# Route default
$routes->get('/', '\App\Modules\Dashboard\Controllers\Dashboard::index', ['filter' => 'myfilter']);

/*
 * --------------------------------------------------------------------
 * Load Route Otomatis
 * --------------------------------------------------------------------
 * Load route otomatis dari folder app/Modules/[ModulePath]/[ModuleName]/Configs/Routes.php
 * created by   : Ruhaendi (titasictech.com)
 * created date : 1 Mar 2023
 * last update  : 1 Mar 2023
 */
$routes_path = APPPATH . 'Modules/{**/*,*}/Configs/Routes.php';
foreach (glob($routes_path, GLOB_BRACE) as $file) {
	if (file_exists($file)) {
		require $file;
	} else {
		continue;
	}
}

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
