<?php namespace App\Modules\Dashboard\Models;
/**
 * File			: DashboardModel.php
 * Description  : Model untuk halaman Dashboard 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 6 Oct 2022
 * Last Update  : 3 Mei 2023
**/
use CodeIgniter\Model;
use Titasictech\Titasictables;

class DashboardModel extends Model {
    public function getData($par) {
		$level_id = session()->get('level_id');
		$mitra_id = session()->get('mitra_id');
		$area_id = session()->get('area_id');
		$share_service_id = session()->get('share_service_id');
		
        switch ($par['type']) {
            case 'summary':
				$sql = "
						SELECT
							(SELECT COUNT(*) FROM kendaraan WHERE kelompok_id = '1' ) AS kend_rutin,
							(SELECT COUNT(*) FROM kendaraan WHERE kelompok_id = '2' ) AS kend_operasional,
							(SELECT COUNT(*) FROM kendaraan WHERE kelompok_id = '2'  AND id NOT IN (SELECT kendaraan_id FROM peminjaman_operasional)) AS ko_bebas,
							(SELECT COUNT(*) FROM kendaraan WHERE kelompok_id = '2'  AND id IN (SELECT kendaraan_id FROM peminjaman_operasional)) AS peminjaman_op
					   ";

				return $this->db->query($sql)->getRow();				
				break;
        }
    }
}
