<?php namespace App\Modules\Master\Unit\Controllers;
/**
 * File			: Unit.php
 * Description  : Controller untuk halaman Master > OPD > Unit
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Mar 2023
 * Last Update  : 29 Mar 2023
**/
use App\Modules\Master\Unit\Models\UnitModel;
use App\Modules\Master\OPD\Models\OPDModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class Unit extends \App\Controllers\MyBaseController {
	private $UnitModel;
    private $OPDModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->UnitModel = new UnitModel();
		$this->OPDModel = new OPDModel();
		$this->LogModel = new LogModel();
	}
    
	public function index()	{
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
        # jika dibutuhkan data untuk konten   
    	$data_content = [
			'mod' => 'unit'
        ];
        # content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 
		$data = [
			'title' => 'Master Unit',
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
								  <li class="breadcrumb-item"><a href="javascript:void(0);">OPD</a></li>
								  <li class="breadcrumb-item active">Unit</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Master\Unit\Views\unit_list', $data_content),
			'content_script' => view('App\Modules\Master\Unit\Views\unit_script'),
		];
		return view('templates/layout_main', $data);
	}

	public function getDatatable() {
		return $this->UnitModel->getDatatable();
	}

	# fungsi untuk modal
	public function getForm() {
		$get = [];
		foreach($_GET as $k => $v) $get[$k] = $this->request->getGet($k);
		$data['mod'] = 'unit';
		$data['sts'] = $get['sts'];
		$data['opd'] = $this->OPDModel->get()->getResultArray();

	    if ($get['sts'] == 'edit' || $get['sts'] == 'view') {
			$data['data'] = $this->UnitModel->getDetail($get['id']);
		}
		
		return view('App\Modules\Master\Unit\Views\unit_form', $data);
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
		
		# mendefiniasikan validation $unit
		if (file_exists(APPPATH . 'Modules/Master/Unit/Configs/Validation.php')) {
			require APPPATH . 'Modules/Master/Unit/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($unit) === FALSE) {
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
				# menggunakan save karena id autoincrement
				$res = $this->UnitModel->save($post);
				# mendapatkan ID
				$id = $this->UnitModel->insertID;
			} else {
				$res = $this->UnitModel->update($id, $post);
			}

			# pesan error validasi disimpan di respon json karena pake ajax	
			# memberikan pesan, pake ul jadi pake []
			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'reflog_id' => ($sts == 'add' ? 3 : 4), # 3 = Insert, 4 = Update
					'keterangan' => ucwords($sts).' Unit, ID '.$id
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
		$cek = $this->UnitModel->isUsed($post['id']);
		if ($cek)
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal dihapus. Unit tersebut sudah dipakai di tabel lain.',
					'errors' => []
				]); 
		
		# hapus permanen tidak soft delete
		$res = $this->UnitModel->delete($post['id']);
	
      	if ($res) { #true
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => 5, # 5 = Delete
				'keterangan' => 'Delete Unit, ID '.$post['id']
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
