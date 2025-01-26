<?php namespace App\Modules\Master\Unit\Models;
/**
 * File			: UnitModel.php
 * Description  : Model untuk halaman Master > OPD > Unit
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Mar 2023
 * Last Update  : 15 Mar 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class UnitModel extends Model {
    protected $table = 'unit';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	# soft delete artinya bukan hapus data permanen, tapi saat call method delete() hanya ngisi deleted_at saja
	protected $useSoftDeletes = false;
    protected $allowedFields = ['kd_unit', 'nm_unit', 'opd_id'];
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
		$datatables->select("a.id, a.kd_unit, a.nm_unit, a.opd_id, b.nm_opd", FALSE)
					->from('unit a')
					->join('opd b', 'a.opd_id = b.id', 'inner')
					->addColumn('actions', 
								'<td>
									<button type="button" id="btn-view" class="btn btn-sm btn-light-secondary mb-0 py-1 px-2" data-mod="$1" data-id="$2" data-desc="$3">
										<span class="btn-inner--icon"><i class="bx bx-show"></i></span>
										<span class="btn-inner--text">View</span>
									</button>
									<button type="button" id="btn-edit" class="btn btn-sm btn-light-secondary mb-0 py-1 px-2" data-mod="$1" data-id="$2" data-desc="$3">
										<span class="btn-inner--icon"><i class="bx bx-edit"></i></span>
										<span class="btn-inner--text">Edit</span>
									</button>
									<button type="button" id="btn-delete" class="btn btn-sm btn-icon btn-danger mb-0 py-1 px-2" data-mod="$1" data-id="$2" data-desc="$3" title="Hapus">
										<span class="btn-inner--icon"><i class="bx bx-trash"></i></span>
									</button>
								</td>',
								'unit, id, nm_unit');
		echo $datatables->generate();			
	}

	public function getDetail($id) {
		return $this->where('id', $id)->first();
	}
	
	# fungsi sebagai pengganti is_unique di validation
	# soalnya id bukan int auto increment
	public function isExist($key, $val) {
		$jml = $this->builder()->selectCount($key)
			->where($key, $val)
			->countAllResults(); 
		return ($jml > 0 ? true : false);
	}

	# fungsi untuk cek apakah sudah dipakai di tabel lain
	public function isUsed($id) {
		$jml = $this->builder()->selectCount('id')
			->join('user u', 'unit.id = u.unit_id', 'inner')
			->where('u.unit_id', $id)
			->countAllResults(); 
		
		return ($jml > 0 ? true : false);
    }
}
