<?php namespace App\Modules\Master\Kendaraan\Models;
/**
 * File			: KendaraanModel.php
 * Description  : Model untuk halaman Master > Kendaraan > Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 20 Mar 2023
 * Last Update  : 12 Apr 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class KendaraanModel extends Model {
    protected $table = 'kendaraan';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	# soft delete artinya bukan hapus data permanen, tapi saat call method delete() hanya ngisi deleted_at saja
	protected $useSoftDeletes = false;
    protected $allowedFields = ['kd_aset', 'nama_aset', 'noreg', 'merk', 'ukuran_cc', 'bahan', 'th_beli', 'no_rangka', 'no_mesin', 'no_polisi', 'no_bpkb', 'roda_id', 'asal_usul_id', 'bahan_bakar_id', 'warna', 'harga', 'photo', 'photo_stnk', 'photo_bpkb', 'keterangan', 'kelompok_id'];
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
		$datatables->select("a.id, a.no_polisi, a.th_beli, a.no_rangka, a.merk, a.photo, a.photo_stnk, a.photo_bpkb", FALSE)
					->from('kendaraan a')
					->where('kelompok_id', $par['kelompok_id'])
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
												<a href="../../$5" class="dropdown-item" target="_blank">Photo Kendaraan</a>
												<a href="../../$6" class="dropdown-item" target="_blank">Photo STNK</a>
												<a href="../../$7" class="dropdown-item" target="_blank">Photo BPKB</a>
											</div>
										</div>
									</div>
								</td>',
								'kendaraan, id, merk, no_polisi, photo, photo_stnk, photo_bpkb'); # ../../ itu pengganti site_url() karena ga bisa ditambahkan di situ
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
			->join('pengguna_rutin pr', 'kendaraan.id = pr.kendaraan_id', 'inner')
			->where('pr.kendaraan_id', $id)
			->countAllResults(); 
		
		if ($jml > 0) return true;

		$jml2 = $this->builder()->selectCount('id')
			->join('peminjaman_operasional po', 'kendaraan.id = po.kendaraan_id', 'inner')
			->where('po.kendaraan_id', $id)
			->countAllResults();

		if ($jml2 > 0) return true;

		return false;
    }
}
