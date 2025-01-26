<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Master > Kendaraan > Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 19 Mar 2023
 * Last Update  : 21 Mar 2023
 * Note 		: Belum bisa pakai master/kendaraan/(:any), jadi bikin route dobel
**/
$routes->group('master/kendaraan/kendaraan-rutin', ['namespace' => 'App\Modules\Master\Kendaraan\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'Kendaraan::index');
	$gp_routes->add('get-form', 'Kendaraan::getForm');
	$gp_routes->post('get-datatable', 'Kendaraan::getDatatable');
	$gp_routes->post('save', 'Kendaraan::saveData');
	$gp_routes->post('delete', 'Kendaraan::deleteData');
	$gp_routes->get('view-file', 'Kendaraan::viewFile');
});

$routes->group('master/kendaraan/kendaraan-operasional', ['namespace' => 'App\Modules\Master\Kendaraan\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'Kendaraan::index');
	$gp_routes->add('get-form', 'Kendaraan::getForm');
	$gp_routes->post('get-datatable', 'Kendaraan::getDatatable');
	$gp_routes->post('save', 'Kendaraan::saveData');
	$gp_routes->post('delete', 'Kendaraan::deleteData');
	$gp_routes->get('view-file', 'Kendaraan::viewFile');
});
