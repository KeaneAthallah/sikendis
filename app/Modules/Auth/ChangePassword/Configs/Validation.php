<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman ubah password
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 7 Mar 2023
 * Last Update  : 7 Mar 2023
**/
$change_password = [
    'password_old' => [
        'label' => 'Password Lama',
        'rules' => 'trim|required',
        'errors' => [
            'required' => 'Password Lama harus diisi.',
        ]
    ],
    'password_new' => [
        'label' => 'Password Baru', 
        'rules' => 'trim|required|min_length[8]',
        'errors' => [
            'required' => 'Password Baru harus diisi.',
            'min_length' => 'Password Baru minimal 8 karakter.'
        ]
    ],  
];
