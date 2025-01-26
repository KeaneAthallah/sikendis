<?php namespace App\Modules\Auth\UserHistory\Controllers;
/**
 * File			: UserHistory.php
 * Description  : Controller untuk halaman User History
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Dec 2022
 * Last Update  : 5 Jan 2023
**/
use App\Modules\Auth\UserHistory\Models\UserHistoryModel;
use App\Modules\Auth\User\Models\UserModel;
use App\Modules\Auth\Level\Models\LevelModel;
use App\Modules\Master\Area\Models\AreaModel;
use App\Modules\Master\Mitra\Models\MitraModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class UserHistory extends \App\Controllers\MyBaseController {
	private $UserHistoryModel;
	private $UserModel;
	private $LevelModel;
	private $AreaModel;
	private $MitraModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->UserHistoryModel = new UserHistoryModel();
		$this->UserModel = new UserModel();
		$this->LevelModel = new LevelModel();
		$this->AreaModel = new AreaModel();
		$this->MitraModel = new MitraModel();
		$this->LogModel = new LogModel();
	}

	public function index() {
		# hanya untuk admin
		if (session()->get('level_id') != '0') {
			$msg = [
				'msg_title' => 'Peringatan',
				'msg_content' => '<div class="alert alert-danger text-white" role="alert"><i class="fas fa-exclamation-triangle"></i> Anda tidak memiliki hak akses untuk menu ini.</div>'
			];
			# toPageInfo ada di helper
			return toPageInfo($msg);
		}
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
		# filter user kecuali share service
		if (isset($_GET['level_id']) && $this->request->getGet('level_id') != '') {
			$user = $this->UserModel->where('level_id', $this->request->getGet('level_id'))->get()->getResultArray();
		} else {
			$user = $this->UserModel->where("level_id > 0 AND level_id <> 3")->get()->getResultArray();
		}

		# jika dibutuhkan data untuk konten    
		$data_content = [
			'mod' => 'user-history',
			'level' => $this->LevelModel->where("id > 0 AND id <> 3")->get()->getResultArray(),
			'user' => $user,
			'area' => $this->AreaModel->get()->getResultArray(),
			'mitra' => $this->MitraModel->get()->getResultArray()
	    ];  
		# content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 
		$data = [
			'title' => 'User History',
			'breadcrumb_item' => '<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Home</a></li>
								  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Auth</a></li>
            					  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">User History</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Auth\UserHistory\Views\user_history_list', $data_content),
			'content_script' => view('App\Modules\Auth\UserHistory\Views\user_history_script'),
		];
		return view('templates/layout_main', $data);
	}
	
	public function getDatatable() {
		$level_id = (isset($_GET['level_id']) ? $this->request->getGet('level_id') : '');
		$user_id = (isset($_GET['user_id']) ? $this->request->getGet('user_id') : '');
		$data = [
			'level_id' => $level_id,
			'user_id' => $user_id
		];
		return $this->UserHistoryModel->getDatatable($data);
	}
}