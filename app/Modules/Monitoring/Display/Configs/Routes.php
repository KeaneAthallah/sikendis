<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Monitoring > Display
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Mei 2023
 * Last Update  : 4 Mei 2023
 * Note 		: untuk kendaraan operasional saja
**/
$routes->group('monitoring/display', ['namespace' => 'App\Modules\Monitoring\Display\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'Display::index');
	$gp_routes->post('get-datatable', 'Display::getDatatable');
	$gp_routes->get('view-file', 'Display::viewFile');
});
