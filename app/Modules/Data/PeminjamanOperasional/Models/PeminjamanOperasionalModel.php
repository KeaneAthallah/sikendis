<?php namespace App\Modules\Data\PeminjamanOperasional\Models;
/**
 * File			: PeminjamanOperasionalModel.php
 * Description  : Model untuk halaman Data > Penggunaan > Peminjaman Operasional
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 6 Apr 2023
 * Last Update  : 11 Apr 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class PeminjamanOperasionalModel extends Model {
    protected $table = 'peminjaman_operasional';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	# soft delete artinya bukan hapus data permanen, tapi saat call method delete() hanya ngisi deleted_at saja
	protected $useSoftDeletes = false;
    protected $allowedFields = ['kendaraan_id', 'instansi', 'penanggung_jawab', 'no_telp', 'no_disposisi', 'tgl_disposisi', 'file_disposisi', 'no_permohonan', 'tgl_permohonan', 'file_permohonan', 'tgl_mulai', 'tgl_selesai'];
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
		$datatables->select("a.id, b.no_polisi, a.instansi, a.no_disposisi, a.file_disposisi, a.file_permohonan", FALSE)
					->from('peminjaman_operasional a')
					->join('kendaraan b', 'a.kendaraan_id = b.id', 'inner')
					->addColumn('actions',
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
										<button type="button" id="btn-delete" class="btn btn-sm btn-icon btn-danger mb-0 py-1 px-2" data-mod="$1" data-id="$2" data-desc="$3 No. Polisi $4" title="Hapus">
											<span class="btn-inner--icon"><i class="bx bx-trash"></i></span>
										</button>
										<div class="dropdown">
											<a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></a>
											<div class="dropdown-menu dropdown-menu-end" style="">
												<a href="../../$5" class="dropdown-item" target="_blank">Lihat File Disposisi</a>
												<a href="../../$6" class="dropdown-item" target="_blank">Lihat File Permohonan</a>
											</div>
										</div>
									</div>
								</td>',
								'peminjaman_operasional, id, instansi, no_polisi, file_disposisi, file_permohonan'); # ../../ itu pengganti site_url() karena ga bisa ditambahkan di situ
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
		# disesuaikan nanti
		/*$jml = $this->builder()->selectCount('id')
			->join('penggunaan_rutin pr', 'kendaraan.id = pr.kendaraan_id', 'inner')
			->where('pr.kendaraan_id', $id)
			->countAllResults(); 
		*/
		return false; //($jml > 0 ? true : false);
    }
}
