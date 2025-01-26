<?php namespace App\Modules\Master\Pengguna\Models;
/**
 * File			: PenggunaModel.php
 * Description  : Model untuk halaman Master > Pengguna
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Mar 2023
 * Last Update  : 11 May 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class PenggunaModel extends Model {
	protected $table = 'pengguna';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	# soft delete artinya bukan hapus data permanen, tapi saat call method delete() hanya ngisi deleted_at saja
	protected $useSoftDeletes = false;
    protected $allowedFields = ['nip', 'nama_lengkap', 'jabatan', 'unit_id', 'sub_bagian', 'no_telp', 'alamat', 'photo'];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
	
    public function getDatatable($par=null) {
		$datatables = new Titasictables();
		# respon jika belum login
		if (!session()->get('is_loggedin')) {
			$output = array(
				'draw' => 0,
				'recordsTotal' => 0,
				'recordsFiltered' => 0,
				'data' => [],
				'csrf_name' => 'X-CSRF-TOKEN', 
				'csrf_content' => $datatables->security->getCSRFHash()
			);
			return json_encode($output);
		}
		# jika csrf diaktifkan di Config/Filters.php maka set true
		# jika tidak diaktifkan maka set false
		# fungsinya memasukan csrf token ke response json
		# karena jika tidak dimasukkan, akan error saat klik order, search, dll pada jquery datatables 
		$datatables->setCSRF(true);
		$datatables->select("a.id, a.nip, a.nama_lengkap, a.unit_id, b.nm_unit, a.photo", FALSE)
					->from('pengguna a')
					->join('unit b', 'a.unit_id = b.id', 'inner');

		if (session()->get('level_id') == 2) # operator
			$datatables->where('a.unit_id', session()->get('unit_id'));

		$datatables->addColumn('actions',
								'<td>
									<div class="d-flex align-items-center">
										<button type="button" id="btn-view" class="btn btn-sm btn-light-secondary mb-0 py-1 px-2" data-mod="$1" data-id="$2" data-desc="$3">
											<span class="btn-inner--icon"><i class="bx bx-show"></i></span>
											<span class="btn-inner--text">View</span>
										</button>
										<button type="button" id="btn-edit" class="btn btn-sm btn-light-secondary mb-0 py-1 px-2" data-mod="$1" data-id="$2" data-desc="$3">
											<span class="btn-inner--icon"><i class="bx bx-edit"></i></span>
											<span class="btn-inner--text">Edit</span>
										</button>
										<button type="button" id="btn-delete" class="btn btn-sm btn-danger mb-0 py-1 px-2" data-mod="$1" data-id="$2" data-desc="$3 - $4" title="Hapus">
											<span class="btn-inner--icon"><i class="bx bx-trash"></i></span>
										</button>
										<div class="dropdown">
											<a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></a>
											<div class="dropdown-menu dropdown-menu-end" style="">
												<a href="javascript:;" id="btn-reset" class="dropdown-item" data-mod="$1" data-id="$2" data-desc="$3">Reset Password</a>
											</div>
										</div>
									</div>
								</td>',
								'pengguna, id, nip, nama_lengkap');
		echo $datatables->generate();			
	}

	public function getDetail($id) {
		return $this->where('id', $id)->first();
	}

	# fungsi untuk cek apakah sudah dipakai di tabel lain
	public function isUsed($id) {
		$jml = $this->builder()->selectCount('id')
			->join('penggunaan_rutin pr', 'pengguna.id = pr.pengguna_id', 'inner')
			->where('pr.pengguna_id', $id)
			->countAllResults();

		return ($jml > 0 ? true : false);
    }
}
