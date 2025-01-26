<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman alert
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 10 Mar 2023
 * Last Update  : 10 Mar 2023
**/
$routes->group('misc', ['namespace' => 'App\Modules\Alert\Controllers'], function ($gp_routes) {
	$gp_routes->get('/', 'Alert::index');
	$gp_routes->add('(:any)', 'Alert::index/$1');
});
