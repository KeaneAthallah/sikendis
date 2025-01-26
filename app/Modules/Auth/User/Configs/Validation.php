<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Auth > User
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 19 Mar 2023
 * Last Update  : 19 Mar 2023
**/
$user = [
    'user_name' => [
        'label' => 'User Name',
        'rules' => 'trim|required|max_length[20]|alpha_numeric|is_unique[user.user_name, id, {id}]',
        'errors' => [
            'required' => 'User Name harus diisi.',
            'max_length' => 'User Name maksimal 20 karakter.',
			'alpha_numeric' => 'User Name tidak valid.',
            'is_unique' => 'User Name tersebut sudah digunakan.'
        ]
    ],
    'nama_lengkap' => [
        'label' => 'Nama Lengkap', 
        'rules' => 'trim|required|max_length[50]',
        'errors' => [
            'required' => 'Nama Lengkap harus diisi.',
			'max_length' => 'Nama Lengkap maksimal 50 karakter.',
        ]
    ],
    'level_id' => [
        'label' => 'Level', 
        'rules' => 'trim|required',
        'errors' => [
            'required' => 'Level harus diisi.'
        ]
    ],
    'description' => [
        'label' => 'Keterangan', 
        'rules' => 'trim|max_length[50]',
        'errors' => [
            'max_length' => 'Keterangan maksimal 50 karakter.'
        ]
    ]
];
