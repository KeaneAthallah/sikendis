<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman User History 
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Dec 2022
 * Last Update  : 25 Dec 2022
**/
# validasi submit create mitra
$user_history = [
    'area_id' => [
        'label' => 'Area', 
        'rules' => 'trim|required|max_length[2]|numeric',
        'errors' => [
            'required' => 'Area harus diisi.',
            'max_length' => 'Area maksimal 2 karakter.',
            'numeric' => 'Area harus angka.'
        ]
    ]
];