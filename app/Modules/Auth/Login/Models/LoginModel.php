<?php namespace App\Modules\Auth\Login\Models;
/**
 * File			: LoginModel.php
 * Description  : Model untuk halaman login
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 5 Mar 2023
 * Last Update  : 5 Mar 2023
**/
use CodeIgniter\Model;
 
class LoginModel extends Model {
    # fungsi untuk login
    # nanti dilengkapi querynya setelah otorisasi dibuat
    # getFirstRow('array') result array, getFirstRow() result object
    public function doLogin($par) {
        $builder = $this->builder('user a');
        $builder->select("a.id as user_id, a.user_name, a.password, a.nama_lengkap, a.level_id, b.keterangan AS level_ket,
                          a.unit_id, c.nm_unit, a.is_active, a.is_login", false)
                ->join('user_level b', 'a.level_id = b.id', 'inner')
                ->join('unit c', 'a.unit_id = c.id', 'left');

        switch (key($par)) {
            case 'user_name': # login by username
                $builder->where('a.user_name', $par['user_name']);
                break;
        }
        
        return $builder->get()->getFirstRow('array');
    }
}
