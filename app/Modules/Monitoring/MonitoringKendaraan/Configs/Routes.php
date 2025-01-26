<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Monitoring > Monitoring Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Apr 2023
 * Last Update  : 15 Apr 2023
 * Note 		: Belum bisa pakai master/kendaraan/(:any), jadi bikin route dobel
**/
$routes->group('monitoring/monitoring-kendaraan-rutin', ['namespace' => 'App\Modules\Monitoring\MonitoringKendaraan\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'MonitoringKendaraan::index');
	$gp_routes->post('get-datatable', 'MonitoringKendaraan::getDatatable');
	$gp_routes->get('view-file', 'MonitoringKendaraan::viewFile');
});

$routes->group('monitoring/monitoring-kendaraan-operasional', ['namespace' => 'App\Modules\Monitoring\MonitoringKendaraan\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'MonitoringKendaraan::index');
	$gp_routes->post('get-datatable', 'MonitoringKendaraan::getDatatable');
	$gp_routes->get('view-file', 'MonitoringKendaraan::viewFile');
});
