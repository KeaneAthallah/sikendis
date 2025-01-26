<?php namespace App\Modules\Auth\ChangePassword\Controllers;
/**
 * File			: ChangePassword.php
 * Description  : Controller untuk halaman ubah password 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 7 Mar 2023
 * Last Update  : 8 Mar 2023
**/
use App\Modules\Auth\User\Models\UserModel;
use App\Modules\Auth\Log\Models\LogModel;

class ChangePassword extends \App\Controllers\MyBaseController {
	private $UserModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->UserModel = new UserModel();
		$this->LogModel = new LogModel();
	}

	public function index()	{
		 # jika dibutuhkan data untuk konten    
		$data_content = [
			'mod' => 'change-password',
        ];  
		$data = [
			'title' => 'Ubah Password',
			'content' => view('App\Modules\Auth\ChangePassword\Views\change_password', $data_content),
			'content_script' => view('App\Modules\Auth\ChangePassword\Views\change_password_script'),
		];
		return view('templates/layout_login', $data);
	}
	
	public function setPassword() {
		# rc = result code
		# rd = result description
		# jika pakai AJAK POST sertakan token csrf baru dalam respon,
		# agar tidak error saat submit kembali

		# jika tidak ajax maka ditolak
		if (!$this->request->isAJAX()) return "Invalid.";

		# agar cepat, pakai metode foreach.
        $post = [];
		foreach($_POST as $k => $v) $post[$k] = $this->request->getPost($k);
		
		# mendefiniasikan validation $change_password 
		if (file_exists(APPPATH . 'Modules/Auth/ChangePassword/Configs/Validation.php')) {
			require APPPATH . 'Modules/Auth/ChangePassword/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($change_password) === FALSE) {
			# pesan error validasi disimpan di respon json karena pake ajax
			return $this->setMsg([
				'rc' => '0', 
				'rd' => 'Ubah password gagal.', 
				'errors' => $this->form_validation->getErrors()
			]); 
        } else {
			$user_id = $this->session->get('user_id');
			$data = $this->UserModel->where('id', $user_id)->first();

			if ($data) {
				//echo password_hash("a", PASSWORD_DEFAULT)."\n"; 
				$verify_pass = password_verify($post['password_old'], $data['password']);
				
				if(!$verify_pass) {
					return $this->setMsg([
						'rc' => '0', 
						'rd' => 'Ubah password gagal.', 
						'errors' => ['Password Lama tidak sama.']
					]); 
				} 
			} 
			
			$password_new = $post['password_new'];
			$post['password'] = password_hash($password_new, PASSWORD_DEFAULT);
			# tidak disertakan dalam penyimpanan
			unset($post['csrf_token_name']);
			unset($post['password_old']);
			unset($post['password_new']);
			$res = $this->UserModel->update($user_id, $post);

			if ($res) { #true
				# simpan ke user log
				$this->LogModel->saveLog([
					'reflog_id' => (4), # 4 = Update
					'keterangan' => 'Ubah password.'
				]);
				return $this->setMsg([
					'rc' => '1', 
					'rd' => 'Ubah password berhasil. Silahkan login ulang.', 
					'errors' => []
				]); 
			} else {
				return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Ubah password gagal.', 
					'errors' => ['Password Baru gagal disimpan.']
				]); 
			}
        }
	}
}
