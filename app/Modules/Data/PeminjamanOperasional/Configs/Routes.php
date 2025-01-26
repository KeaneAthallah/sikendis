<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Data > Penggunaan > Peminjaman Operasional
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Apr 2023
 * Last Update  : 4 Apr 2023
**/
$routes->group('data/penggunaan/peminjaman-operasional', ['namespace' => 'App\Modules\Data\PeminjamanOperasional\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'PeminjamanOperasional::index');
	$gp_routes->add('get-form', 'PeminjamanOperasional::getForm');
	$gp_routes->post('get-datatable', 'PeminjamanOperasional::getDatatable');
	$gp_routes->post('save', 'PeminjamanOperasional::saveData');
	$gp_routes->post('delete', 'PeminjamanOperasional::deleteData');
	$gp_routes->get('view-file', 'PeminjamanOperasional::viewFile');
});
