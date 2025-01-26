<?php namespace App\Modules\Auth\Login\Controllers;
/**
 * File			: Login.php
 * Description  : Controller untuk halaman login 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 3 Mar 2023
 * Last Update  : 5 Mar 2023
**/
use App\Modules\Auth\Login\Models\LoginModel;
use App\Modules\Auth\User\Models\UserModel;
use App\Modules\Auth\Log\Models\LogModel;

class Login extends \App\Controllers\MyBaseController {
	private $LoginModel;
	private $UserModel;
	private $LogModel;

    public function __construct() {
		parent::__construct();
		# Modelnya diload langsung di construct agar create object hanya sekali saja.
		$this->LoginModel = new LoginModel();
		$this->UserModel = new UserModel();
		$this->LogModel = new LogModel();
	}

	public function index()	{
		# jika dibutuhkan data untuk konten
		$data_content = [
			'mod' => 'login',
        ];  
		$data = [
			'title' => 'Login',
			'content' => view('App\Modules\Auth\Login\Views\login', $data_content),
			'content_script' => view('App\Modules\Auth\Login\Views\login_script'),
		];
		return view('templates/layout_login', $data);
	}
	
	public function doLogin() {
		# rc = result code
		# rd = result description
		# jika pakai AJAK POST sertakan token csrf baru dalam respon,
		# agar tidak error saat submit kembali

		# jika tidak ajax maka ditolak
		if (!$this->request->isAJAX()) return "Invalid.";

		# agar cepat, pakai metode foreach.
        $post = [];
		foreach($_POST as $k => $v) $post[$k] = $this->request->getPost($k);
		
		# mendefiniasikan validation $login 
		if (file_exists(APPPATH . 'Modules/Auth/Login/Configs/Validation.php')) {
			require APPPATH . 'Modules/Auth/Login/Configs/Validation.php';
		}

		# form_validation sudah diload di MyBaseController
		if ($this->validate($login) === FALSE) {
			# pesan error validasi disimpan di respon json karena pake ajax
			return $this->setMsg([
				'rc' => '0', 
				'rd' => 'Login gagal.', 
				'errors' => $this->form_validation->getErrors()
			]); 
        } else {
			$data = $this->LoginModel->doLogin(['user_name' => $post['user_name']]);

			if ($data) {
				if ($data['is_active'] == 'F') {
					return $this->setMsg([
						'rc' => '0', 
						'rd' => 'Login gagal.', 
						'errors' => ['Username tersebut sudah tidak aktif.']
					]); 
				}

				# untuk single login,
				# jika ingin mengaktifkan / menonaktifkan fitur single login cukup comment / uncomment saja
				/*if ($data['is_login'] == 'T') {
					return $this->setMsg([
						'rc' => '0', 
						'rd' => 'Login gagal.', 
						'errors' => ['Username tersebut sedang digunakan.']
					]); 
				}*/
				
				$pass = $data['password'];
				//echo password_hash("a", PASSWORD_DEFAULT)."\n"; 
				$verify_pass = password_verify($post['password'], $pass);
				
				if($verify_pass) {
					# update status login untuk single user
					# jika mau dinonaktifkan fitur single login cukup comment saja
					$this->UserModel->setLogin($data['user_id'], 'T');

					$ses_data = [
						'user_id' => $data['user_id'],
						'user_name' => $data['user_name'],
						'nama_lengkap' => $data['nama_lengkap'],
						'is_loggedin' => TRUE,
						'level_id' => $data['level_id'],
                        'level_ket' => $data['level_ket'],
						'unit_id' => $data['unit_id'],
                        'nm_unit' => $data['nm_unit']
					];
					$this->session->set($ses_data);
					# simpan di user log
					$agent = $this->request->getUserAgent();
					$browser = $agent->getBrowser().' '. $agent->getVersion().' ('.$agent->getPlatform().')';
					$this->LogModel->saveLog(['reflog_id' => 1, 'keterangan' => 'Login sebagai '.$this->session->get('user_name').' dengan '.$browser.' IP. '.$this->request->getIPAddress()]);
					return $this->setMsg([
						'rc' => '1', 
						'rd' => 'Login berhasil.', 
						'errors' => []
					]); 
				} else {
					return $this->setMsg([
						'rc' => '0', 
						'rd' => 'Login gagal.', 
						'errors' => ['Password salah.']
					]); 
				}
			} else {
				return $this->setMsg([
					'rc' => '0', 
					'rd' => 'Login gagal.', 
					'errors' => ['Username tersebut tidak ditemukan.']
				]); 
			}
        }
	}
	
	public function doLogout() {
		# update status login untuk single user
		# jika mau dinonaktifkan fitur single login cukup comment saja
		$this->UserModel->setLogin(session()->get('user_id'), 'F');
		# simpan ke user log
		$this->LogModel->saveLog(['reflog_id' => 2, 'keterangan' => 'Logout sebagai '.$this->session->get('user_name')]);
		$this->session->destroy();
		return redirect()->to(base_url('auth/login'));
	}
}
