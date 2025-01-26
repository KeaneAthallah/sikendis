<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman utama
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 1 Mar 2023
 * Last Update  : 1 Mar 2023
**/
$routes->group('dashboard', ['namespace' => 'App\Modules\Dashboard\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'Dashboard::index');
});
