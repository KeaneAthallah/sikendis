<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman login
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 3 Mar 2023
 * Last Update  : 3 Mar 2023
**/
$routes->group('auth/login', ['namespace' => 'App\Modules\Auth\Login\Controllers'], function ($gp_routes) {
	$gp_routes->get('/', 'Login::index');
	$gp_routes->post('do-login', 'Login::doLogin');
});

$routes->get('auth/do-logout', '\App\Modules\Auth\Login\Controllers\Login::doLogout', ['filter' => 'myfilter']);
