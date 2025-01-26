<?php namespace App\Modules\Master\Pengguna\Controllers;
/**
 * File			: Pengguna.php
 * Description  : Controller untuk halaman Master > Pengguna
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Mar 2023
 * Last Update  : 11 May 2023
**/
use App\Modules\Master\Pengguna\Models\PenggunaModel;
use App\Modules\Master\OPD\Models\OPDModel;
use App\Modules\Master\Unit\Models\UnitModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class Pengguna extends \App\Controllers\MyBaseController {
	private $PenggunaModel;
	private $OPDModel;
	private $UnitModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->PenggunaModel = new PenggunaModel();
		$this->OPDModel = new OPDModel();
		$this->UnitModel = new UnitModel();
		$this->LogModel = new LogModel();
	}

	public function index()	{
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
		# jika dibutuhkan data untuk konten    
		$data_content = [
			'mod' => 'pengguna',
	    ];  
		# content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 
		$data = [
			'title' => 'Pengguna',
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
								  <li class="breadcrumb-item active">Pengguna</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Master\Pengguna\Views\pengguna_list', $data_content),
			'content_script' => view('App\Modules\Master\Pengguna\Views\pengguna_script'),
		];
		return view('templates/layout_main', $data);
	}
	
	public function getDatatable() {
		return $this->PenggunaModel->getDatatable();
	}

	# fungsi untuk modal
	public function getForm() {
		$get = [];
		foreach($_GET as $k => $v) $get[$k] = $this->request->getGet($k);
		$data['mod'] = 'pengguna';
		$data['sts'] = $get['sts'];

	    if ($get['sts'] == 'edit' || $get['sts'] == 'view') {
			$data['data'] = $this->PenggunaModel->getDetail($get['id']);
			//$data['for_select'] = (new XModel)->getFn($par);
		}
		
		if (session()->get('level_id') == 2) # operator
			$data['unit'] = $this->UnitModel->where('id', session()->get('unit_id'))->get()->getResultArray();
		else
			$data['unit'] = $this->UnitModel->get()->getResultArray();

		return view('App\Modules\Master\Pengguna\Views\pengguna_form', $data);
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
		
		# mendefinisikan validation $pengguna
		if (file_exists(APPPATH . 'Modules/Master/Pengguna/Configs/Validation.php')) {
			require APPPATH . 'Modules/Master/Pengguna/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($pengguna) === FALSE) {
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
			# photo pengguna
			if ($file = $this->request->getFile('photo')) {
				if ($file->isValid() && ! $file->hasMoved()) {
				//if (!empty($file->getName())) {
					# buat folder jika belum ada
					$folder_path = ROOTPATH.'public/repository/pengguna';
					# 0777 artinya RW (full access)
					if (!is_dir($folder_path)) {
						mkdir($folder_path, 0777, TRUE);
					}

					$new_file = $post['nip'].'.'.$file->getClientExtension();
					$new_file_full = 'public/repository/pengguna/'.$new_file;
					# replace jika sudah ada
					if(file_exists($folder_path.'/'.$new_file))
						unlink($folder_path.'/'.$new_file);
					# menyimpan file
					$file->move($folder_path, $new_file);
					$post['photo'] = $new_file_full;
				}
			}

			if ($sts == 'add') {
				# menggunakan save karena id autoincrement
				$res = $this->PenggunaModel->save($post);
				# mendapatkan ID
				$id = $this->PenggunaModel->insertID;
			} else {
				$res = $this->PenggunaModel->update($id, $post);
			}

			# pesan error validasi disimpan di respon json karena pake ajax	
			# memberikan pesan, pake ul jadi pake []
			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'reflog_id' => ($sts == 'add' ? 3 : 4), # 3 = Insert, 4 = Update
					'keterangan' => ucwords($sts).' Pengguna, ID '.$id
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
		$cek = $this->PenggunaModel->isUsed($post['id']);
		if ($cek)
			return $this->setMsg([
					'rc' => '0',
					'rd' => 'Data gagal dihapus. Pengguna tersebut sudah dipakai di tabel lain.',
					'errors' => []
				]);

		# ambil dulu path photo sebelum dihapus
		$photo_path = $this->PenggunaModel->where('id', $post['id'])->first()['photo'];
		# hapus permanen tidak soft delete
		$res = $this->PenggunaModel->delete($post['id']);
	
      	if ($res) { #true
			# hapus file
			$file = ROOTPATH.$photo_path;
			if(is_file($file)) unlink($file);
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => 5, # 5 = Delete
				'keterangan' => 'Delete Pengguna, ID '.$post['id']
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
