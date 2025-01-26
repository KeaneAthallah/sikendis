<?php namespace App\Modules\Auth\Level\Controllers;
/**
 * File			: Level.php
 * Description  : Controller untuk halaman Auth > Level
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 24 Nov 2022
 * Last Update  : 10 Dec 2022
**/
use App\Modules\Auth\Level\Models\LevelModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class Level extends \App\Controllers\MyBaseController {
    private $LevelModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->LevelModel = new LevelModel();
		$this->LogModel = new LogModel();
	}
    
	public function index()	{
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
        # jika dibutuhkan data untuk konten   
    	$data_content = [
			'mod' => 'level',
        ];
        # content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 
		$data = [
			'title' => 'Level',
			'breadcrumb_item' => '<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Home</a></li>
								  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Auth</a></li>
            					  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Level</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Auth\Level\Views\level_list', $data_content),
			'content_script' => view('App\Modules\Auth\Level\Views\level_script'),
		];
		return view('templates/layout_main', $data);
	}

	public function getDatatable() {
		return $this->LevelModel->getDatatable();
	}

	# fungsi untuk modal
	public function getForm() {
		$get = [];
		foreach($_GET as $k => $v) $get[$k] = $this->request->getGet($k);
		$data['mod'] = 'level';
		$data['sts'] = $get['sts'];

	    if ($get['sts'] == 'edit' || $get['sts'] == 'view') {
			$data['data'] = $this->LevelModel->getDetail($get['id']);
		}
		
		return view('App\Modules\Auth\Level\Views\level_form', $data);
	}

	public function saveData() {
		# rc = result code
		# rd = result description
		# jika pakai AJAK POST sertakan token csrf baru dalam respon,
		# agar tidak error saat submit kembali

		# jika tidak ajax ditolak
		if (!$this->request->isAJAX()) return "Invalid.";
	
		# agar cepat, pakai metode foreach.
		$post = [];
		foreach($_POST as $k => $v) $post[$k] = $this->request->getPost($k);
		
		# mendefiniasikan validation $level 
		if (file_exists(APPPATH . 'Modules/Auth/Level/Configs/Validation.php')) {
			require APPPATH . 'Modules/Auth/Level/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($level) === FALSE) {
			# pesan error validasi disimpan di respon json karena pake ajax
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal disimpan.', 
					'errors' => $this->form_validation->getErrors()
				]); 
        } else {
			$sts = $post['sts'];
			$id = $post['id'];
			# tidak disertakan dalam penyimpanan
			unset($post['sts']);
			unset($post['csrf_token_name']);

			if ($sts == 'add') {
				# cek id, tidak pake is_unique di validation
				# soalnya id bukan int auto increment
				# jadi error tidak bisa simpan saat edit data
				if ($this->LevelModel->isUnique('id', $id)) 
					return $this->setMsg([
							'rc' => '0', 
							'rd' => 'Data gagal disimpan.', 
							'errors' => ['id' => 'ID tersebut sudah digunakan.'], 
						]); 
				# menggunakan save jika ID auto increment
				# menggunakan insert jika ID tidak auto increment
				# $returnID = false, agar nilai kembalian bukan id tapi result boolean
				$res = $this->LevelModel->insert($post, false); # (data, returnID)
			} else {
				$res = $this->LevelModel->update($id, $post);
			}

			# pesan error validasi disimpan di respon json karena pake ajax	
			# memberikan pesan, pake ul jadi pake []
			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'code' => ($sts == 'add' ? 3 : 4), # 3 = Insert, 4 = Update
					'description' => ucwords($sts).' Level, ID '.$id
				]);
				
				return $this->setMsg([
						'rc' => '1', 
						'rd' => 'Data berhasil disimpan.', 
						'errors' => []
					]); 
			} else {
				return $this->setMsg([
						'rc' => '0', 
						'rd' => 'Data gagal disimpan.', 
						'errors' => ['Error eksekusi ke database.']
					]); 
			}
		}
	}

	public function deleteData() {
		# rc = result code
		# rd = result description
		# jika pakai AJAK POST sertakan token csrf baru dalam respon,
		# agar tidak error saat submit kembali
		
		# jika tidak ajax ditolak
		if (!$this->request->isAJAX()) return "Invalid.";
		
		# agar cepat, pakai metode foreach.
        $post = [];
		foreach($_POST as $k => $v) $post[$k] = $this->request->getPost($k);
		
		# cek jika sudah ada di table lain
		$cek = $this->LevelModel->isUsed($post['id']);
		if ($cek)
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal dihapus. Level tersebut sudah dipakai di tabel lain.',
					'errors' => []
				]); 
		
		# hapus permanen tidak soft delete
		$res = $this->LevelModel->delete($post['id']);
	
      	if ($res) { #true
			# simpan ke user log
			$this->LogModel->saveLog([
				'code' => 5, # 5 = Delete
				'description' => 'Delete Level, ID '.$post['id']
			]);

			return $this->setMsg([
					'rc' => '1', 
					'rd' => 'Data berhasil dihapus.', 
					'errors' => []
				]); 
		} else {
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal dihapus.', 
					'errors' => ['Error eksekusi ke database.']
				]);
		}
    }
}
