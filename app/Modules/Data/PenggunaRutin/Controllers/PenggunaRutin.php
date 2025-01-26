<?php namespace App\Modules\Data\PenggunaRutin\Controllers;
/**
 * File			: PenggunaRutin.php
 * Description  : Controller untuk halaman Data > Penggunaan > Pengguna Rutin
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 29 Mar 2023
 * Last Update  : 11 May 2023
**/
use App\Modules\Data\PenggunaRutin\Models\PenggunaRutinModel;
use App\Modules\Master\Kendaraan\Models\KendaraanModel;
use App\Modules\Master\Pengguna\Models\PenggunaModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class PenggunaRutin extends \App\Controllers\MyBaseController {
	private $PenggunaRutinModel;
	private $KendaraanModel;
    private $PenggunaModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->PenggunaRutinModel = new PenggunaRutinModel();
		$this->KendaraanModel = new KendaraanModel();
		$this->PenggunaModel = new PenggunaModel();
		$this->LogModel = new LogModel();
	}
    
	public function index()	{
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
        # jika dibutuhkan data untuk konten   
    	$data_content = [
			'mod' => 'pengguna-rutin',
        ];
        # content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 

		$data = [
			'title' => 'Pengguna Rutin',
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Data</a></li>
								  <li class="breadcrumb-item"><a href="javascript:void(0);">Penggunaan</a></li>
								  <li class="breadcrumb-item active">Pengguna Rutin</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Data\PenggunaRutin\Views\pengguna_rutin_list', $data_content),
			'content_script' => view('App\Modules\Data\PenggunaRutin\Views\pengguna_rutin_script'),
		];
		return view('templates/layout_main', $data);
	}

	public function getDatatable() {
		return $this->PenggunaRutinModel->getDatatable();
	}

	# fungsi untuk modal
	public function getForm() {
		$get = [];
		foreach($_GET as $k => $v) $get[$k] = $this->request->getGet($k);
		$data['mod'] = 'pengguna-rutin';
		$data['sts'] = $get['sts'];
		$data['kendaraan'] = $this->KendaraanModel->where('kelompok_id', 1)->get()->getResultArray();

		if (session()->get('level_id') == 2) # operator
			$data['pengguna'] = $this->PenggunaModel->where('unit_id', session()->get('unit_id'))->get()->getResultArray();
		else
			$data['pengguna'] = $this->PenggunaModel->get()->getResultArray();

	    if ($get['sts'] == 'edit' || $get['sts'] == 'view') {
			$data['data'] = $this->PenggunaRutinModel->getDetail($get['id']);
		}
		
		return view('App\Modules\Data\PenggunaRutin\Views\pengguna_rutin_form', $data);
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
		
		# mendefiniasikan validation $pengguna_rutin
		if (file_exists(APPPATH . 'Modules/Data/PenggunaRutin/Configs/Validation.php')) {
			require APPPATH . 'Modules/Data/PenggunaRutin/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($pengguna_rutin) === FALSE) {
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
			# file bap
			if ($file = $this->request->getFile('file_bap')) {
				if ($file->isValid() && ! $file->hasMoved()) {
				//if (!empty($file->getName())) {
					# buat folder jika belum ada
					$folder_path = ROOTPATH.'public/repository/pengguna-rutin';
					# 0777 artinya RW (full access)
					if (!is_dir($folder_path)) {
						mkdir($folder_path, 0777, TRUE);
					}

					//$new_file = getSlug($post['no_bap']).'.'.$file->getClientExtension();
					$new_file = 'file-bap-'.$file->getRandomName();
					$new_file_full = 'public/repository/pengguna-rutin/'.$new_file;
					# replace jika sudah ada
					if(file_exists($folder_path.'/'.$new_file))
						unlink($folder_path.'/'.$new_file);
					# menyimpan file
					$file->move($folder_path, $new_file);
					$post['file_bap'] = $new_file_full;
				}
			}

			if ($sts == 'add') {
				# menggunakan save karena id autoincrement
				$res = $this->PenggunaRutinModel->save($post);
				# mendapatkan ID
				$id = $this->PenggunaRutinModel->insertID;
			} else {
				$res = $this->PenggunaRutinModel->update($id, $post);
			}

			# pesan error validasi disimpan di respon json karena pake ajax	
			# memberikan pesan, pake ul jadi pake []
			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'reflog_id' => ($sts == 'add' ? 3 : 4), # 3 = Insert, 4 = Update
					'keterangan' => ucwords($sts).' Pengguna Rutin, ID '.$id
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
		$cek = $this->PenggunaRutinModel->isUsed($post['id']);
		if ($cek)
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal dihapus. Kendaraan tersebut sudah dipakai di tabel lain.',
					'errors' => []
				]); 
		# ambil dulu path photo sebelum dihapus
		$file_path = $this->PenggunaRutinModel->where('id', $post['id'])->first()['file_bap'];
		# hapus permanen tidak soft delete
		$res = $this->PenggunaRutinModel->delete($post['id']);
	
      	if ($res) { #true
			# hapus file
			$file = ROOTPATH.$file_path;
			if(is_file($file)) unlink($file);
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => 5, # 5 = Delete
				'keterangan' => 'Delete Pengguna Rutin, ID '.$post['id']
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

    public function viewFile() {
		$file_path = getD64URL($this->request->getGet('file'));
		$this->response->setHeader('Content-Type', 'application/pdf');
		$this->response->setHeader('Content-Disposition', 'inline; filename='.basename($file_path));
		readfile(ROOTPATH.$file_path);
	}
}
