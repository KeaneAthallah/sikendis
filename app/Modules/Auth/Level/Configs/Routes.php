<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Auth > Level
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 24 Nov 2022
 * Last Update  : 25 Nov 2022
**/
$routes->group('auth/level', ['namespace' => 'App\Modules\Auth\Level\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'Level::index');
	$gp_routes->add('get-form', 'Level::getForm');
	$gp_routes->post('get-datatable', 'Level::getDatatable');
	$gp_routes->post('save', 'Level::saveData');
	$gp_routes->post('delete', 'Level::deleteData');
});