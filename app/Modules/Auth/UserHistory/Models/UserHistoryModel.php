<?php namespace App\Modules\Auth\UserHistory\Models;
/**
 * File			: UserHistoryModel.php
 * Description  : Model untuk halaman User History
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Dec 2022
 * Last Update  : 7 Jan 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class UserHistoryModel extends Model {
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
		# karena jika tidak dimasukkan, akan error saat klik order, search, dll pada jquery datatables --, ' [Tahap 1]'
		$datatables->setCSRF(true);
		$datatables->select("v1h.created_at AS date_time, CONCAT(s.description, ' ', TRIM(IFNULL(v1d.description, 'Submit'))) AS activity, 
							v1.no_sp, m.description as mitra_desc, a.description as area_desc, v1.jobdesc, IF(v1h.is_revision = 'T', v1h.note, '') as revisi,
							v1h.user_id, 'v1' AS `type`, '' AS actions", FALSE) 
					->from('verification1_history v1h')
					->join('verification1_detail v1d', 'v1h.verification1_id = v1d.verification1_id AND v1h.program_document_id = v1d.program_document_id', 'left')
					->join('verification1 v1', 'v1h.verification1_id = v1.id', 'inner')
					->join('status s', 'LEFT(v1h.status_id, 1) = s.id', 'inner')
					->join('mitra m', 'v1.mitra_id = m.id', 'inner')
					->join('area a', 'v1.area_id = a.id', 'inner')
					->where('v1h.user_id', $par['user_id'])
					->where("TRIM(v1h.description) NOT LIKE 'Include%'");
	
		# union all tidak didukung library
		$result = $datatables->generate();
		$array = json_decode($result);
		$data = $array->data;
		
		if (count($data) > 0) { //, ' [Tahap 2]'
			$sql = "
					SELECT v2h.created_at AS date_time, CONCAT(s.description, ' ', TRIM(IFNULL(v2d.description, 'Submit'))) AS activity, 
					v1.no_sp, m.description as mitra_desc, a.description as area_desc, v1.jobdesc, IF(v2h.is_revision = 'T', v2h.note, '') as revisi,
					v2h.user_id, 'v2' AS `type`, '' AS actions
					FROM verification2_history v2h
					LEFT JOIN verification2_detail v2d ON v2h.verification2_id = v2d.verification2_id AND v2h.program_document_id = v2d.program_document_id
					INNER JOIN verification2 v2 ON v2h.verification2_id = v2.id
					INNER JOIN verification1 v1 ON v2.verification1_id = v1.id
					INNER JOIN status s ON LEFT(v2h.status_id, 1) = s.id
					INNER JOIN mitra m ON v1.mitra_id = m.id
					INNER JOIN area a ON v1.area_id = a.id
					WHERE v2h.user_id = '".$par['user_id']."'
					AND TRIM(v2h.description) NOT LIKE 'Include%'
			       ";
			$res = $this->db->query($sql)->getResultArray();
			# menggabungkan array	
			if (count($res) > 0) {
				foreach ($res as $v) {
					$array->data[] = $v;
				}
				# untuk order karena datatable campur array
				# baru bisa kolom tanggal, menyusul lainnya jika diminta saja
				$columns = array_column($array->data, 'date_time');
				array_multisort($columns, SORT_DESC, $array->data);
			}
			
			$array->recordsTotal = count($array->data);
			$array->recordsFiltered = count($array->data);
			echo json_encode($array);
		} else {
			echo $result;
		}
	}
}