<?php namespace App\Modules\Alert\Controllers;
/**
 * File			: Alert.php
 * Description  : Controller untuk halaman alert
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 10 Mar 2023
 * Last Update  : 10 Mar 2023
**/
use CodeIgniter\Config\Services;

class Alert extends \App\Controllers\MyBaseController {
    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
	}

	public function index($type) {
		switch ($type) {
			case 'access-denied':
				$msg = [
						'msg_title' => 'Kembali',
						'msg_content' => '<div class="alert alert-danger" role="alert"><i class="bx bx-error"></i> Anda tidak memiliki hak akses untuk menu ini.</div>'
				];
				break;
		}
		# toPageAlert ada di helper
		return toPageAlert($msg);
	}
}
