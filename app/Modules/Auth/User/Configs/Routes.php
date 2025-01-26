<?php
/**
 * File			: Routes.php
 * Description  : Route untuk halaman Auth > User
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 10 Mar 2023
 * Last Update  : 10 Mar 2023
**/
$routes->group('auth/user', ['namespace' => 'App\Modules\Auth\User\Controllers', 'filter' => 'myfilter'], function ($gp_routes) {
	$gp_routes->get('/', 'User::index');
	$gp_routes->add('get-form', 'User::getForm');
	$gp_routes->post('get-datatable', 'User::getDatatable');
	$gp_routes->post('save', 'User::saveData');
	$gp_routes->post('delete', 'User::deleteData');
	$gp_routes->post('set-active', 'User::setActive');
	$gp_routes->post('set-login', 'User::setLogin');
	$gp_routes->post('reset-password', 'User::resetPassword');
});
