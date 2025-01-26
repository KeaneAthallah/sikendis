<?php namespace App\Modules\Data\PeminjamanOperasional\Controllers;
/**
 * File			: PeminjamanOperasional.php
 * Description  : Controller untuk halaman Data > Penggunaan > Peminjaman Operasional
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Apr 2023
 * Last Update  : 2 Mei 2023
**/
use App\Modules\Data\PeminjamanOperasional\Models\PeminjamanOperasionalModel;
use App\Modules\Master\Kendaraan\Models\KendaraanModel;
use App\Modules\Master\Pengguna\Models\PenggunaModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class PeminjamanOperasional extends \App\Controllers\MyBaseController {
	private $PeminjamanOperasionalModel;
	private $KendaraanModel;
    private $PenggunaModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->PeminjamanOperasionalModel = new PeminjamanOperasionalModel();
		$this->KendaraanModel = new KendaraanModel();
		$this->PenggunaModel = new PenggunaModel();
		$this->LogModel = new LogModel();
	}
    
	public function index()	{
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
        # jika dibutuhkan data untuk konten   
    	$data_content = [
			'mod' => 'peminjaman-operasional',
        ];
        # content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 

		$data = [
			'title' => 'Peminjaman Operasional',
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Data</a></li>
								  <li class="breadcrumb-item"><a href="javascript:void(0);">Penggunaan</a></li>
								  <li class="breadcrumb-item active">Peminjaman Operasional</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Data\PeminjamanOperasional\Views\peminjaman_operasional_list', $data_content),
			'content_script' => view('App\Modules\Data\PeminjamanOperasional\Views\peminjaman_operasional_script'),
		];
		return view('templates/layout_main', $data);
	}

	public function getDatatable() {
		return $this->PeminjamanOperasionalModel->getDatatable();
	}

	# fungsi untuk modal
	public function getForm() {
		$get = [];
		foreach($_GET as $k => $v) $get[$k] = $this->request->getGet($k);
		$data['mod'] = 'peminjaman-operasional';
		$data['sts'] = $get['sts'];
		$data['kendaraan'] = $this->KendaraanModel->where('kelompok_id', 2)->get()->getResultArray();

	    if ($get['sts'] == 'edit' || $get['sts'] == 'view') {
			$data['data'] = $this->PeminjamanOperasionalModel->getDetail($get['id']);
		}
		
		return view('App\Modules\Data\PeminjamanOperasional\Views\peminjaman_operasional_form', $data);
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
		
		# mendefiniasikan validation $peminjaman_operasional
		if (file_exists(APPPATH . 'Modules/Data/PeminjamanOperasional/Configs/Validation.php')) {
			require APPPATH . 'Modules/Data/PeminjamanOperasional/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($peminjaman_operasional) === FALSE) {
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
			# file disposisi
			if ($file = $this->request->getFile('file_disposisi')) {
				if ($file->isValid() && ! $file->hasMoved()) {
				//if (!empty($file->getName())) {
					# buat folder jika belum ada
					$folder_path = ROOTPATH.'public/repository/peminjaman-operasional';
					# 0777 artinya RW (full access)
					if (!is_dir($folder_path)) {
						mkdir($folder_path, 0777, TRUE);
					}

					//$new_file = getSlug($file->getName()).'-'.strtotime("now").'.'.$file->getClientExtension();
					$new_file = 'file-disposisi-'.$file->getRandomName();
					$new_file_full = 'public/repository/peminjaman-operasional/'.$new_file;
					# replace jika sudah ada
					if(file_exists($folder_path.'/'.$new_file))
						unlink($folder_path.'/'.$new_file);
					# menyimpan file
					$file->move($folder_path, $new_file);
					$post['file_disposisi'] = $new_file_full;
				}
			}

			# file permohonan
			if ($file = $this->request->getFile('file_permohonan')) {
				if ($file->isValid() && ! $file->hasMoved()) {
				//if (!empty($file->getName())) {
					# buat folder jika belum ada
					$folder_path = ROOTPATH.'public/repository/peminjaman-operasional';
					# 0777 artinya RW (full access)
					if (!is_dir($folder_path)) {
						mkdir($folder_path, 0777, TRUE);
					}

					//$new_file = getSlug($file->getName()).'-'.strtotime("now").'.'.$file->getClientExtension();
					$new_file = 'file-permohonan-'.$file->getRandomName();
					$new_file_full = 'public/repository/peminjaman-operasional/'.$new_file;
					# replace jika sudah ada
					if(file_exists($folder_path.'/'.$new_file))
						unlink($folder_path.'/'.$new_file);
					# menyimpan file
					$file->move($folder_path, $new_file);
					$post['file_permohonan'] = $new_file_full;
				}
			}

			if ($sts == 'add') {
				# menggunakan save karena id autoincrement
				$res = $this->PeminjamanOperasionalModel->save($post);
				# mendapatkan ID
				$id = $this->PeminjamanOperasionalModel->insertID;
			} else {
				$res = $this->PeminjamanOperasionalModel->update($id, $post);
			}

			# pesan error validasi disimpan di respon json karena pake ajax	
			# memberikan pesan, pake ul jadi pake []
			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'reflog_id' => ($sts == 'add' ? 3 : 4), # 3 = Insert, 4 = Update
					'keterangan' => ucwords($sts).' Peminjaman Operasional, ID '.$id
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
		$cek = $this->PeminjamanOperasionalModel->isUsed($post['id']);
		if ($cek)
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal dihapus. Kendaraan tersebut sudah dipakai di tabel lain.',
					'errors' => []
				]); 
		# ambil dulu path photo sebelum dihapus
		$file_path = $this->PeminjamanOperasionalModel->where('id', $post['id'])->first();
		# hapus permanen tidak soft delete
		$res = $this->PeminjamanOperasionalModel->delete($post['id']);
	
      	if ($res) { #true
			# hapus file disposisi
			$file1 = ROOTPATH.$file_path['file_disposisi'];
			if(is_file($file1)) unlink($file1);
			# hapus file disposisi
			$file2 = ROOTPATH.$file_path['file_permohonan'];
			if(is_file($file2)) unlink($file2);
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => 5, # 5 = Delete
				'keterangan' => 'Delete Peminjaman Operasional, ID '.$post['id']
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
