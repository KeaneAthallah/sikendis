<?php namespace App\Modules\Dashboard\Controllers;
/**
 * File			: Dashboard.php
 * Description  : Controller untuk halaman Dashboard
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 1 Mar 2023
 * Last Update  : 3 Mei 2023
**/
use App\Modules\Dashboard\Models\DashboardModel;
use CodeIgniter\Config\Services;

class Dashboard extends \App\Controllers\MyBaseController {
    private $DashboardModel;
    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->DashboardModel = new DashboardModel();
	}
    
	public function index()	{
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
        # jika dibutuhkan data untuk konten           
    	$data_content = [
			'mod' => 'dashboard',
			'summary' => $this->DashboardModel->getData(['type' => 'summary']),
			'new_message' => [] //$this->DashboardModel->getData(['type' => 'new_message'])
        ];   
		# content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page   
		$data = [
			'title' => 'Dashboard',
			'breadcrumb_item' => '<li class="breadcrumb-item active">Dashboard</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Dashboard\Views\dashboard', $data_content),
			'content_script' => view('App\Modules\Dashboard\Views\dashboard_script'),
		];
		return view('templates/layout_main', $data);
	}
}
