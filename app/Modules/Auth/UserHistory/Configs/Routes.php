<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman User History 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Dec 2022
 * Last Update  : 25 Dec 2022
**/
$routes->group('auth/user-history', ['namespace' => 'App\Modules\Auth\UserHistory\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'UserHistory::index');
	$gp_routes->add('list', 'UserHistory::listData');
	$gp_routes->post('get-datatable', 'UserHistory::getDatatable');
});