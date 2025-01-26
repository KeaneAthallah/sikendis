<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Master > OPD > Unit
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Mar 2023
 * Last Update  : 15 Mar 2023
**/
$routes->group('master/opd/unit', ['namespace' => 'App\Modules\Master\Unit\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'Unit::index');
	$gp_routes->add('get-form', 'Unit::getForm');
	$gp_routes->post('get-datatable', 'Unit::getDatatable');
	$gp_routes->post('save', 'Unit::saveData');
	$gp_routes->post('delete', 'Unit::deleteData');
});
