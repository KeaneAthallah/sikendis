<?php namespace App\Modules\Monitoring\Display\Models;
/**
 * File			: DisplayModel.php
 * Description  : Model untuk halaman Monitoring > Display
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Mei 2023
 * Last Update  : 4 Mei 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class DisplayModel extends Model {
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
		$datatables->select("k.id, k.no_polisi, k.th_beli, k.no_rangka, k.merk, k.photo, k.photo_stnk, k.photo_bpkb,
							IF(pk.tgl_mulai IS NULL, 'BEBAS', 'DIPAKAI') AS status, UPPER(IFNULL(pk.instansi, '-')) AS instansi, DATE_FORMAT(pk.tgl_mulai, '%d-%m-%Y') AS tgl_mulai,
							DATE_FORMAT(pk.tgl_selesai, '%d-%m-%Y') AS tgl_selesai, IFNULL(pk.no_telp, '-') AS no_telp", FALSE)
					->from('kendaraan k')
					->join('(
								SELECT po.id, po.kendaraan_id, po.instansi, po.no_disposisi, po.tgl_disposisi, po.file_disposisi, po.tgl_mulai, po.tgl_selesai, po.no_telp
								FROM peminjaman_operasional po
								WHERE po.tgl_mulai IN (
									SELECT MAX(po2.tgl_mulai) FROM peminjaman_operasional po2 WHERE po2.kendaraan_id = po.kendaraan_id
								)
							) pk', 'pk.kendaraan_id = k.id', 'left')
					->where('k.kelompok_id', '2');

		echo $datatables->generate();			
	}
}
