<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Master > Pengguna
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Mar 2023
 * Last Update  : 25 Mar 2023
**/
$routes->group('master/pengguna', ['namespace' => 'App\Modules\Master\Pengguna\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'Pengguna::index');
	$gp_routes->add('get-form', 'Pengguna::getForm');
	$gp_routes->post('get-datatable', 'Pengguna::getDatatable');
	$gp_routes->post('save', 'Pengguna::saveData');
	$gp_routes->post('delete', 'Pengguna::deleteData');
});
