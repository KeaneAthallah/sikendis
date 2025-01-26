<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Master > OPD > OPD
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 10 Mar 2023
 * Last Update  : 10 Mar 2023
**/
$routes->group('master/opd/opd', ['namespace' => 'App\Modules\Master\OPD\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'OPD::index');
	$gp_routes->add('get-form', 'OPD::getForm');
	$gp_routes->post('get-datatable', 'OPD::getDatatable');
	$gp_routes->post('save', 'OPD::saveData');
	$gp_routes->post('delete', 'OPD::deleteData');
});
