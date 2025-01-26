<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Auth > Level
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 26 Nov 2022
 * Last Update  : 26 Nov 2022
**/
$level = [
    'id' => [
        'label' => 'ID', 
        'rules' => 'trim|required|max_length[2]|numeric',
        'errors' => [
            'required' => 'ID harus diisi.',
            'max_length' => 'ID maksimal 2 karakter.',
            'numeric' => 'ID harus angka.'
        ]
    ],
    'description' => [
        'label' => 'Level',
        'rules' => 'trim|required|max_length[50]|is_unique[user_level.description, id, {id}]',
        'errors' => [
            'required' => 'Level harus diisi.',
            'max_length' => 'Level maksimal 50 karakter.',
            'is_unique' => 'Level tersebut sudah digunakan.'
        ]
    ]
];