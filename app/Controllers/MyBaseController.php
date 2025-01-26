<?php namespace App\Controllers;
/**
 * File			: MyBaseController.php
 * Description  : Controller dasar untuk semua controller yang akan dibangun
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 1 Mar 2023
 * Last Update  : 1 Mar 2023
**/
class MyBaseController extends BaseController {
	# --------------------------------------------------------------------
	# Helpers 
	# --------------------------------------------------------------------
	# agar bisa menggunakan helper form_open(), base_url(), dll
	# agar bisa dipakai di semua controller dan views
	protected $helpers = ['form', 'url', 'titasictech']; 
	protected $session = null;
	
	public function __construct() {
		# --------------------------------------------------------------------
		# Manage Cache
		# --------------------------------------------------------------------
		# jika no-cache berarti setiap request browser langsung ke server
	    # jika pake cache berarti setiap request browser tidak langsung ke server,
		# tapi cek dl di local, ini akan menambah performance / kecepatan load
		# 1. tanpa cache
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("If-Modified-Since: Mon, 22 Jan 2008 00:00:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Cache-Control: private");
		header("Pragma: no-cache");
		
		# 2. pakai cache
		/*Cache aset statis yang tidak dapat diubah untuk waktu yang lama, 
		seperti 30 hari = 2592000 detik.
		//header("Cache-Control: public, max-age=2592000");*/
		
		# jika error post/ajax, uncoment saja
        /*
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
		*/
		
		# --------------------------------------------------------------------
		# Load Session dan Form Validation
		# --------------------------------------------------------------------
		# diusahakan OOP dan MVC
		# bisa menggunakan metode helper
		# $this->session = sessions()
		$this->session = \Config\Services::session();
		$this->form_validation = \Config\Services::validation();
	}
	# fungsi untuk respon ajax dengan menyertakan csrf token
	public function setMsg($res) {
		return json_encode([
				'rc' => $res['rc'], 
				'rd' => $res['rd'], 
				'errors' => $res['errors'],
				'csrf_name' => 'X-CSRF-TOKEN', 
				'csrf_content' => (\Config\Services::security())->getCSRFHash()
			]);
	}
}
