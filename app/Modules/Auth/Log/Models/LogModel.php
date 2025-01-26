<?php namespace App\Modules\Auth\Log\Models;
/**
 * File			: LogModel.php
 * Description  : Model untuk halaman log user
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 3 Mar 2023
 * Last Update  : 3 Mar 2023
**/
use CodeIgniter\Model;
 
class LogModel extends Model {
	protected $table = 'user_log';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	# bukan hapus data permanen tapi saat call method delete hanya ngisi deleted_at saja
	protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'reflog_id', 'keterangan'];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
	# 2 metode penyimpanan, database dan file
	private $store_in = 'database'; //'file';
	# kode reflog_id
	private $code = [
		1 => 'Login',
		2 => 'Logout',
		3 => 'Insert',
		4 => 'Update',
		5 => 'Delete',
		6 => 'Query / Report'
	];

	public function saveLog($par=[]) {
		$user_id = session()->get('user_id') ?? $par['user_id'];
		
		if ($this->store_in == 'database') { # jika disimpan di database
            $data = [
                'user_id' => $user_id,
                'reflog_id' => $par['reflog_id'],
                'keterangan' =>  $par['keterangan']
			];
			# $returnID = false, agar nilai kembalian bukan user_id tapi result boolean
			return $this->insert($data, false); # (data, returnID)
        } else { # jika disimpan di file 
			//$date = date('Y-m-d');
			//$date_time = date('Y-m-d H:i:s');
			# untuk pengembangan selanjutnya
        }
        
        return false;
	}

	# fungsi untuk cek user log
	public function checkLog($id) {
		return $this->where('user_id', $id)->countAllResults(); 
    }
}
