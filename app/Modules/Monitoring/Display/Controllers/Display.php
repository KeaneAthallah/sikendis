<?php namespace App\Modules\Monitoring\Display\Controllers;
/**
 * File			: Display.php
 * Description  : Controller untuk halaman Monitoring > Display
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Mei 2023
 * Last Update  : 4 Mei 2023
**/
use App\Modules\Monitoring\Display\Models\DisplayModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class Display extends \App\Controllers\MyBaseController {
	private $DisplayModel;
    private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->DisplayModel = new DisplayModel();
		$this->LogModel = new LogModel();
	}
    
	public function index()	{
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
        # jika dibutuhkan data untuk konten   
    	$data_content = [
			'mod' => 'display'
        ];

		$data = [
			'title' => 'Display',
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Monitoring</a></li>
								  <li class="breadcrumb-item active">Display</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Monitoring\Display\Views\display_list', $data_content),
			'content_script' => view('App\Modules\Monitoring\Display\Views\display_script'),
		];

		return view('templates/layout_main', $data);
	}

	public function getDatatable() {
		return $this->DisplayModel->getDatatable();
	}

	public function viewFile() {
		$file_path = getD64URL($this->request->getGet('file'));
		$this->response->setHeader('Content-Type', 'application/pdf');
		$this->response->setHeader('Content-Disposition', 'inline; filename='.basename($file_path));
		readfile(ROOTPATH.$file_path);
	}
}
