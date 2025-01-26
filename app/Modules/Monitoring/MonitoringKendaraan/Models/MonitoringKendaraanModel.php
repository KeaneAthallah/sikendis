<?php namespace App\Modules\Monitoring\MonitoringKendaraan\Models;
/**
 * File			: MonitoringKendaraanModel.php
 * Description  : Model untuk halaman Monitoring > Monitoring Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Apr 2023
 * Last Update  : 17 May 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class MonitoringKendaraanModel extends Model {
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

		if ($par['kelompok_id'] == 1) {
			$datatables->select("k.id, k.no_polisi, k.th_beli, k.no_rangka, k.merk, k.photo, k.photo_stnk, k.photo_bpkb,
								IF(pk.tgl_bap IS NULL, 'BEBAS', CONCAT('DIPAKAI [', UPPER(pk.nama_lengkap), ']')) AS status", FALSE)
					   ->from('kendaraan k')
					   ->join('(
									SELECT pr.id, pr.kendaraan_id, pr.pengguna_id, pr.no_bap, pr.tgl_bap, pr.file_bap, p.nama_lengkap
									FROM pengguna_rutin pr
									INNER JOIN pengguna p ON pr.pengguna_id = p.id
									WHERE pr.tgl_bap IN (
										SELECT MAX(pr2.tgl_bap) FROM pengguna_rutin pr2 WHERE pr2.kendaraan_id = pr.kendaraan_id
									)
							   ) pk', 'pk.kendaraan_id = k.id', 'left');
		} elseif ($par['kelompok_id'] == 2) {
			$datatables->select("k.id, k.no_polisi, k.th_beli, k.no_rangka, k.merk, k.photo, k.photo_stnk, k.photo_bpkb,
								IF(pk.tgl_mulai IS NULL, 'BEBAS', CONCAT('DIPAKAI [', UPPER(pk.instansi), ', ', DATE_FORMAT(pk.tgl_mulai, '%d-%m-%Y'), ' sd. ', DATE_FORMAT(pk.tgl_selesai, '%d-%m-%Y'), ']')) AS status", FALSE)
					   ->from('kendaraan k')
					   ->join('(
									SELECT po.id, po.kendaraan_id, po.instansi, po.no_disposisi, po.tgl_disposisi, po.file_disposisi, po.tgl_mulai, po.tgl_selesai
									FROM peminjaman_operasional po
									WHERE po.tgl_mulai IN (
										SELECT MAX(po2.tgl_mulai) FROM peminjaman_operasional po2 WHERE po2.kendaraan_id = po.kendaraan_id
									)
							   ) pk', 'pk.kendaraan_id = k.id', 'left');
		}

		$datatables->where('k.kelompok_id', $par['kelompok_id']);

		echo $datatables->generate();			
	}
}
