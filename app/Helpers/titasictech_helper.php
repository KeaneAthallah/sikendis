<?php
/**
 * File			: titasictech_helper.php
 * Description  : Helper sebagai utility aplikasi
 * Created By	: Hendi (titasictech.com)
 * Created Date : 1 Mar 2023
 * Last Update  : 10 Mar 2023
**/

# fungsi untuk mendapatkan nama bulan Indonesia
if (! function_exists('getMonthID')) {
	function getMonthID(int $m = null): string {
		$month_name = [
			' ', 
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		];
		return $month_name[$m];
	}
}
# fungsi untuk redirect ke halaman alert
if (! function_exists('toPageAlert')) {
	function toPageAlert($data = []) {
		return view('templates/layout_alert', $data);
	}
}
# fungsi untuk menghilangkan special character
if (! function_exists('getSlug')) {
	function getSlug($string) { 
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
}
# fungsi untuk mendapatkan segment url
if (! function_exists('getSegment')) {
	function getSegment() { 
		/**
		 * --------------------------------------------------------------------------
		 * Active Menu
		 * --------------------------------------------------------------------------
		 * kelemahan memakai getSegment, jika sudah di hosting harus disesuaikan segmentnya.
		 * $url = new \CodeIgniter\HTTP\URI(current_url());
		 * $segment = $url->getSegment(1);
		 * Agar segment otomatis walaupun base_url() berubah, maka memakai script berikut:
		 */
		$base_url = base_url(); # http://localhost/path/folder/project
		//$site_url = site_url(); # http://localhost/path/folder/project/
		$current_url = current_url(); # http://localhost/path/folder/project/dashboard
		$segment = explode('/', str_replace($base_url, '', $current_url));
		return $segment;
	}
}
# fungsi mendapatkan id yang diencode di URL
if (! function_exists('getD64URL')) {
	function getD64URL($b64enc='') { 
		return base64_decode(urldecode($b64enc));
	}
}
# fungsi left di php ga ada
if (! function_exists('left')) {
	function left($str, $length) {
		return substr($str, 0, $length);
	}
}
# fungsi right di php ga ada
if (! function_exists('right')) {
	function right($str, $length) {
		return substr($str, -$length);
	}
}
