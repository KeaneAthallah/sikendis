<?php namespace App\Filters;
/**
 * File			: AuthFilter.php
 * Description  : Filter Authentication untuk mengecek apakah user sudah login.
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 1 Mar 2023
 * Last Update  : 13 Mar 2023
 */
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        # comment/uncomment untuk menonaktifkan filter
    	if (!session()->get('is_loggedin')) {
	        return redirect()->to(site_url('auth/login'))->with('error', "Invalid Credential");
	    }
	    # filter otorisasi dengan syarat bukan ajax
	    $level_id = session()->get('level_id');
	    $allowed = [];
        $msg = [];
	    $url = current_url();

        switch ($level_id) {
            case 0: # admin
                $allowed = [
                    base_url(),
                    site_url('dashboard'),
                    site_url('auth/do-logout'),
                    site_url('auth/change-password'),
                    site_url('auth/user'),
                    site_url('master/opd/opd'),
                    site_url('master/opd/unit'),
                    site_url('master/kendaraan/kendaraan-rutin'),
                    site_url('master/kendaraan/kendaraan-operasional'),
                    site_url('master/pengguna'),
                    site_url('data/penggunaan/pengguna-rutin'),
                    site_url('data/penggunaan/peminjaman-operasional'),
                ];
                break;
            case 1: # pejabat
                $allowed = [
                    base_url(),
                    site_url('dashboard'),
                    site_url('auth/do-logout'),
                    site_url('auth/change-password'),
                    site_url('master/kendaraan/kendaraan-rutin'),
                    site_url('master/kendaraan/kendaraan-operasional'),
                    site_url('master/pengguna'),
                    site_url('data/penggunaan/pengguna-rutin'),
                    site_url('data/penggunaan/peminjaman-operasional'),
                ];
                break;
            case 2: # operator
                $allowed = [
                    base_url(),
                    site_url('dashboard'),
                    site_url('auth/do-logout'),
                    site_url('auth/change-password'),
                    site_url('master/kendaraan/kendaraan-rutin'),
                    site_url('master/kendaraan/kendaraan-operasional'),
                    site_url('master/pengguna'),
                    site_url('data/penggunaan/pengguna-rutin'),
                    site_url('data/penggunaan/peminjaman-operasional'),
                ];
                break;
        }

        if (!in_array($url, $allowed) && !$request->isAJAX()) {
			//return redirect()->to(site_url('misc/access-denied'))->with('error', "Invalid Credential");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do something here
    }
}
