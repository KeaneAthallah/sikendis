<?php namespace App\Modules\Monitoring\MonitoringKendaraan\Controllers;
/**
 * File			: MonitoringKendaraan.php
 * Description  : Controller untuk halaman Monitoring > Monitoring Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Apr 2023
 * Last Update  : 15 Apr 2023
**/
use App\Modules\Monitoring\MonitoringKendaraan\Models\MonitoringKendaraanModel;
use App\Modules\Master\Kelompok\Models\KelompokModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class MonitoringKendaraan extends \App\Controllers\MyBaseController {
	private $MonitoringKendaraanModel;
    private $KelompokModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->MonitoringKendaraanModel = new MonitoringKendaraanModel();
		$this->KelompokModel = new KelompokModel();
		$this->LogModel = new LogModel();
	}
    
	public function index()	{
		# karena menu kendaraan rutin dan kendaraan operasional disatukan
		# maka ada tambahan $title untuk pembeda
		$segment = getSegment();
		$title = ucwords(str_replace('-', ' ', $segment[1]));
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
        # jika dibutuhkan data untuk konten   
    	$data_content = [
			'mod' => 'monitoring-kendaraan',
			'title' => $title,
        ];
        # content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 

		$data = [
			'title' => $title,
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Monitoring</a></li>
								  <li class="breadcrumb-item active">'.$title.'</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Monitoring\MonitoringKendaraan\Views\monitoring_kendaraan_list', $data_content),
			'content_script' => view('App\Modules\Monitoring\MonitoringKendaraan\Views\monitoring_kendaraan_script'),
		];
		return view('templates/layout_main', $data);
	}

	public function getDatatable() {
		# kelompok kendaraan diambil dari url
		$segment = getSegment();
		$kelompok_id = $this->KelompokModel->where('keterangan', str_replace('monitoring ', '', str_replace('-', ' ', $segment[1])))->first()['id'];
		return $this->MonitoringKendaraanModel->getDatatable(['kelompok_id' => $kelompok_id]);
	}

	public function viewFile() {
		$file_path = getD64URL($this->request->getGet('file'));
		$this->response->setHeader('Content-Type', 'application/pdf');
		$this->response->setHeader('Content-Disposition', 'inline; filename='.basename($file_path));
		readfile(ROOTPATH.$file_path);
	}
}
