<?php namespace App\Modules\Auth\User\Controllers;
/**
 * File			: User.php
 * Description  : Controller untuk halaman Auth > User 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 10 Mar 2023
 * Last Update  : 19 Mar 2023
**/
use App\Modules\Auth\User\Models\UserModel;
use App\Modules\Auth\Level\Models\LevelModel;
use App\Modules\Master\Unit\Models\UnitModel;
use App\Modules\Auth\Log\Models\LogModel;
use CodeIgniter\Config\Services;

class User extends \App\Controllers\MyBaseController {
	private $UserModel;
	private $LevelModel;
	private $UnitModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->UserModel = new UserModel();
		$this->LevelModel = new LevelModel();
		$this->UnitModel = new UnitModel();
		$this->LogModel = new LogModel();
	}

	public function index()	{
		# jika sudah menu dinamis diisi dari array hasil query
		$data_menu = []; 
		# jika dibutuhkan data untuk konten    
		$data_content = [
			'mod' => 'user',
	    ];  
		# content_script untuk memudahkan mengelola code javascript atau lainnya.
		# jadi setiap script terpisah untuk masing-masing content/page 
		$data = [
			'title' => 'User',
			'breadcrumb_item' => '<li class="breadcrumb-item"><a href="javascript:void(0);">Auth</a></li>
								  <li class="breadcrumb-item active">User</li>',
			'menu' => view('contents/menu', $data_menu),
			'content' => view('App\Modules\Auth\User\Views\user_list', $data_content),
			'content_script' => view('App\Modules\Auth\User\Views\user_script'),
		];
		return view('templates/layout_main', $data);
	}
	
	public function getDatatable() {
		return $this->UserModel->getDatatable();
	}

	# fungsi untuk modal
	public function getForm() {
		$get = [];
		foreach($_GET as $k => $v) $get[$k] = $this->request->getGet($k);
		$data['mod'] = 'user';
		$data['sts'] = $get['sts'];

	    if ($get['sts'] == 'edit' || $get['sts'] == 'view') {
			$data['data'] = $this->UserModel->getDetail($get['id']);
			//$data['for_select'] = (new XModel)->getFn($par);
		}
		
		$data['level'] = $this->LevelModel->get()->getResultArray();
		$data['unit'] = $this->UnitModel->get()->getResultArray();

		return view('App\Modules\Auth\User\Views\user_form', $data);
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
		
		# mendefiniasikan validation $user 
		if (file_exists(APPPATH . 'Modules/Auth/User/Configs/Validation.php')) {
			require APPPATH . 'Modules/Auth/User/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($user) === FALSE) {
			# pesan error validasi disimpan di respon json karena pake ajax
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal disimpan.', 
					'errors' => $this->form_validation->getErrors()
				]); 
        } else {
			$sts = $post['sts'];
			$id = $post['id'];
			# checkbox is_active jika tidak dicentang, is_active tidak terkirim ke server
			$post['is_active'] = $post['is_active'] ?? 'F';
			# tidak disertakan dalam penyimpanan
			unset($post['sts']);
			unset($post['csrf_token_name']);

			if ($sts == 'add') {
				# saat tambah user, password default "123"
				# nanti diubah sendiri oleh user masing-masing
				$post['password'] = password_hash("123", PASSWORD_DEFAULT);
				# menggunakan save karena id autoincrement
				$res = $this->UserModel->save($post); 
				# mendapatkan ID
				$id = $this->UserModel->insertID;
			} else {
				$res = $this->UserModel->update($id, $post);
			}

			# pesan error validasi disimpan di respon json karena pake ajax	
			# memberikan pesan, pake ul jadi pake []
			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'reflog_id' => ($sts == 'add' ? 3 : 4), # 3 = Insert, 4 = Update
					'keterangan' => ucwords($sts).' User, ID '.$id
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
		$cek = $this->LogModel->checkLog($post['id']);
		if ($cek > 0)
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Data gagal dihapus. User tersebut sudah pernah input data.',
					'errors' => []
				]); 
		
		# hapus permanen tidak soft delete
		$res = $this->UserModel->delete($post['id']);
	
      	if ($res) { #true
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => 5, # 5 = Delete
				'keterangan' => 'Delete User, ID '.$post['id']
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

	public function setActive() {
		# jika tidak ajax ditolak
		if (!$this->request->isAJAX()) return "Invalid.";

		# agar cepat, pakai metode foreach.
        $post = [];
		foreach($_POST as $k => $v) $post[$k] = $this->request->getPost($k);
		unset($post['csrf_token_name']);
		$res = $this->UserModel->setActive($post['id'], $post['is_active']);
		$desc = ($post['is_active'] == 'T' ? 'diaktifkan' : 'dinonaktifkan');

		if ($res) { #true
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => (4), # 4 = Update
				'keterangan' => 'User '.$desc.', ID '.$post['id']
			]);

			return $this->setMsg([
					'rc' => '1', 
					'rd' => 'User berhasil '.$desc.'.', 
					'errors' => []
				]); 
		} else {
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'User gagal '.$desc.'.', 
					'errors' => ['Error eksekusi ke database.']
				]);
		}
	}

	public function setLogin() {
		# hanya bisa logout paksa
		# jika tidak ajax ditolak
		if (!$this->request->isAJAX()) return "Invalid.";

		# agar cepat, pakai metode foreach.
        $post = [];
		foreach($_POST as $k => $v) $post[$k] = $this->request->getPost($k);
		unset($post['csrf_token_name']);
		$res = $this->UserModel->setLogin($post['id'], $post['is_login']);
		
		if ($res) { #true
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => (4), # 4 = Update
				'keterangan' => 'Logout paksa User, ID '.$post['id']
			]);

			return $this->setMsg([
					'rc' => '1', 
					'rd' => 'User berhasil dilogout.', 
					'errors' => []
				]); 
		} else {
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'User gagal dilogout.', 
					'errors' => ['Error eksekusi ke database.']
				]);
		}
	}

	public function resetPassword() {
		# jika tidak ajax ditolak
		if (!$this->request->isAJAX()) return "Invalid.";

		# agar cepat, pakai metode foreach.
        $post = [];
		foreach($_POST as $k => $v) $post[$k] = $this->request->getPost($k);
		# reset password default "123"
		# nanti diubah sendiri oleh user masing-masing
		$post['password'] = password_hash("123", PASSWORD_DEFAULT);
		unset($post['csrf_token_name']);
		$res = $this->UserModel->update($post['id'], $post);

		if ($res) { #true
			# simpan ke user log
			$this->LogModel->saveLog([
				'reflog_id' => (4), # 4 = Update
				'keterangan' => 'Reset password User, ID '.$post['id']
			]);

			return $this->setMsg([
					'rc' => '1', 
					'rd' => 'Reset password berhasil.', 
					'errors' => []
				]); 
		} else {
			return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Reset password gagal.', 
					'errors' => ['Error eksekusi ke database.']
				]);
		}
	}
}
