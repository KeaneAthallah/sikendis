<?php namespace App\Modules\Master\Kendaraan\Controllers;
/**
 * File			: Kendaraan.php
 * Description  : Controller untuk halaman Master > Kendaraan > Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 19 Mar 2023
 * Last Update  : 12 Apr 2023
**/
use App\Modules\Master\Kendaraan\Models\KendaraanModel;
use App\Modules\Master\AsalUsul\Models\AsalUsulModel;
use App\Modules\Master\Roda\Models\RodaModel;
use App\Modules\Master\BahanBakar\Models\BahanBakarModel;
use App\Modules\Master\Kelompok\Models\KelompokModel;
# belum dibuat menunya jadi dicomment dl
//use App\Modules\Data\PenggunaanRutin\Models\PenggunaanRutinModel;
//use App\Modules\Data\PeminjamanOperasional\Models\PeminjamanOperasionalModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class Kendaraan extends \App\Controllers\MyBaseController {
	private $KendaraanModel;
    private $AsalUsulModel;
	private $RodaModel;
	private $BahanBakarModel;
	private $KelompokModel;
	//private $PenggunaanRutinModel;
	//private $PeminjamanOperasionalModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->KendaraanModel = new KendaraanModel();
		$this->AsalUsulModel = new AsalUsulModel();
		$this->RodaModel = new RodaModel();
		$this->BahanBakarModel = new BahanBakarModel();
		$this->KelompokModel = new KelompokModel();
		$this->LogModel = new LogModel();
	}
    
	public function index()	{
		# karena menu kendaraan rutin dan kendaraan operasional disatukan
		# maka ada tambahan $title untuk pembeda
		$segment = getSegment();
		$title = ucwords(str_replace('-', ' ', $segment[2]));
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
        # jika dibutuhkan data untuk konten   
    	$data_content = [
			'mod' => 'kendaraan',
			'title' => $title,
        ];
        # content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 

		$data = [
			'title' => $title,
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
								  <li class="breadcrumb-item"><a href="javascript:void(0);">Kendaraan</a></li>
								  <li class="breadcrumb-item active">'.$title.'</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Master\Kendaraan\Views\kendaraan_list', $data_content),
			'content_script' => view('App\Modules\Master\Kendaraan\Views\kendaraan_script'),
		];
		return view('templates/layout_main', $data);
	}

	public function getDatatable() {
		# kelompok kendaraan diambil dari url
		$segment = getSegment();
		$kelompok_id = $this->KelompokModel->where('keterangan', str_replace('-', ' ', $segment[2]))->first()['id'];
		return $this->KendaraanModel->getDatatable(['kelompok_id' => $kelompok_id]);
	}

	# fungsi untuk modal
	public function getForm() {
		$get = [];
		foreach($_GET as $k => $v) $get[$k] = $this->request->getGet($k);
		$data['mod'] = 'kendaraan';
		$data['sts'] = $get['sts'];
		$data['asal_usul'] = $this->AsalUsulModel->get()->getResultArray();
		$data['roda'] = $this->RodaModel->get()->getResultArray();
		$data['bahan_bakar'] = $this->BahanBakarModel->get()->getResultArray();

	    if ($get['sts'] == 'edit' || $get['sts'] == 'view') {
			$data['data'] = $this->KendaraanModel->getDetail($get['id']);
		}
		
		return view('App\Modules\Master\Kendaraan\Views\kendaraan_form', $data);
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
		
		# mendefiniasikan validation $kendaraan
		if (file_exists(APPPATH . 'Modules/Master/Kendaraan/Configs/Validation.php')) {
			require APPPATH . 'Modules/Master/Kendaraan/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($kendaraan) === FALSE) {
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
			# photo kendaraan
			if ($file = $this->request->getFile('photo')) {
				if ($file->isValid() && ! $file->hasMoved()) {
				//if (!empty($file->getName())) {
					# buat folder jika belum ada
					$folder_path = ROOTPATH.'public/repository/kendaraan';
					# 0777 artinya RW (full access)
					if (!is_dir($folder_path)) {
						mkdir($folder_path, 0777, TRUE);
					}

					$new_file = 'photo-kendaraan-'.$file->getRandomName();
					$new_file_full = 'public/repository/kendaraan/'.$new_file;
					# replace jika sudah ada
					if(file_exists($folder_path.'/'.$new_file))
						unlink($folder_path.'/'.$new_file);
					# menyimpan file
					$file->move($folder_path, $new_file);
					$post['photo'] = $new_file_full;
				}
			}
			# photo stnk
			if ($file = $this->request->getFile('photo_stnk')) {
				if ($file->isValid() && ! $file->hasMoved()) {
				//if (!empty($file->getName())) {
					# buat folder jika belum ada
					$folder_path = ROOTPATH.'public/repository/kendaraan';
					# 0777 artinya RW (full access)
					if (!is_dir($folder_path)) {
						mkdir($folder_path, 0777, TRUE);
					}

					$new_file = 'photo-stnk-'.$file->getRandomName();
					$new_file_full = 'public/repository/kendaraan/'.$new_file;
					# replace jika sudah ada
					if(file_exists($folder_path.'/'.$new_file))
						unlink($folder_path.'/'.$new_file);
					# menyimpan file
					$file->move($folder_path, $new_file);
					$post['photo_stnk'] = $new_file_full;
				}
			}
			# photo bpkb
			if ($file = $this->request->getFile('photo_bpkb')) {
				if ($file->isValid() && ! $file->hasMoved()) {
				//if (!empty($file->getName())) {
					# buat folder jika belum ada
					$folder_path = ROOTPATH.'public/repository/kendaraan';
					# 0777 artinya RW (full access)
					if (!is_dir($folder_path)) {
						mkdir($folder_path, 0777, TRUE);
					}

					$new_file = 'photo-bpkb-'.$file->getRandomName();
					$new_file_full = 'public/repository/kendaraan/'.$new_file;
					# replace jika sudah ada
					if(file_exists($folder_path.'/'.$new_file))
						unlink($folder_path.'/'.$new_file);
					# menyimpan file
					$file->move($folder_path, $new_file);
					$post['photo_bpkb'] = $new_file_full;
				}
			}

			if ($sts == 'add') {
				# kelompok kendaraan diambil dari url
				$segment = getSegment();
				$post['kelompok_id'] = $this->KelompokModel->where('keterangan', str_replace('-', ' ', $segment[2]))->first()['id'];
				# menggunakan save karena id autoincrement
				$res = $this->KendaraanModel->save($post);
				# mendapatkan ID
				$id = $this->KendaraanModel->insertID;
			} else {
				$res = $this->KendaraanModel->update($id, $post);
			}

			# pesan error validasi disimpan di respon json karena pake ajax	
			# memberikan pesan, pake ul jadi pake []
			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'reflog_id' => ($sts == 'add' ? 3 : 4), # 3 = Insert, 4 = Update
					'keterangan' => ucwords($sts).' Kendaraan, ID '.$id
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
		$cek = $this->KendaraanModel->isUsed($post['id']);
		if ($cek)
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal dihapus. Kendaraan tersebut sudah dipakai di tabel lain.',
					'errors' => []
				]); 
		# ambil dulu path photo sebelum dihapus
		$file_path = $this->KendaraanModel->where('id', $post['id'])->first();
		# hapus permanen tidak soft delete
		$res = $this->KendaraanModel->delete($post['id']);
	
      	if ($res) { #true
			/* INI GA BISA SIMPAN SAAT ADD DATA, KARENA ID BELUM DIGENERATE.
			 * SOALNYA ID DIGENERATE SAAT SIMPAN (AUTO INCREMENT)
			# S: hapus folder sesuai id
			$folder_path = ROOTPATH.'public/repository/kendaraan/'.$post['id'];
			# tidak bisa delete sekaligus, harus delete filr satu-satu dulu
			foreach(glob($folder_path . '/*') as $file) {
				if(is_file($file)) unlink($file);
			}
			# hapus folder
			if(is_dir($folder_path)) rmdir($folder_path);
			# E: hapus folder sesuai id
			*/
			# hapus photo kendaraan
			$file1 = ROOTPATH.$file_path['photo'];
			if(is_file($file1)) unlink($file1);
			# hapus photo stnk
			$file2 = ROOTPATH.$file_path['photo_stnk'];
			if(is_file($file2)) unlink($file2);
			# hapus photo bpkb
			$file3 = ROOTPATH.$file_path['photo_bpkb'];
			if(is_file($file3)) unlink($file3);

			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => 5, # 5 = Delete
				'keterangan' => 'Delete Kendaraan, ID '.$post['id']
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
