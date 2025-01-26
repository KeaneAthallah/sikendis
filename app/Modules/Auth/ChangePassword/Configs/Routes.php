<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman ubah password
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 7 Mar 2023
 * Last Update  : 7 Mar 2023
**/
$routes->group('auth/change-password', ['namespace' => 'App\Modules\Auth\ChangePassword\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'ChangePassword::index');
	$gp_routes->post('set-password', 'ChangePassword::setPassword');
});
