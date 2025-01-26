<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Data > Penggunaan > Pengguna Rutin
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 29 Mar 2023
 * Last Update  : 29 Mar 2023
**/
$routes->group('data/penggunaan/pengguna-rutin', ['namespace' => 'App\Modules\Data\PenggunaRutin\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'PenggunaRutin::index');
	$gp_routes->add('get-form', 'PenggunaRutin::getForm');
	$gp_routes->post('get-datatable', 'PenggunaRutin::getDatatable');
	$gp_routes->post('save', 'PenggunaRutin::saveData');
	$gp_routes->post('delete', 'PenggunaRutin::deleteData');
	$gp_routes->get('view-file', 'PenggunaRutin::viewFile');
});
