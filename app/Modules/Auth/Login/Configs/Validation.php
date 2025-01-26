<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman login
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 3 Mar 2023
 * Last Update  : 3 Mar 2023
**/
$login = [
    'user_name' => [
        'label' => 'Username',
        'rules' => 'trim|required',
        'errors' => [
            'required' => 'Username harus diisi.',
        ]
    ],
    'password' => [
        'label' => 'Password', 
        'rules' => 'trim|required', //|min_length[6]
        'errors' => [
            'required' => 'Password harus diisi.',
            //'min_length' => 'Password minimal 6 karakter.'
        ]
    ]
];
