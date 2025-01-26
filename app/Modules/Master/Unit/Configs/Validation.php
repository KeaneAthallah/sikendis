<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Master > OPD > Unit
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Mar 2023
 * Last Update  : 15 Mar 2023
**/
$unit = [
    'kd_unit' => [
        'label' => 'Kode Unit',
        'rules' => 'trim|required|max_length[15]|is_unique[unit.kd_unit, id, {id}]',
        'errors' => [
            'required' => 'Kode Unit harus diisi.',
            'max_length' => 'Kode Unit maksimal 15 karakter.',
            'is_unique' => 'Kode Unit tersebut sudah digunakan.'
        ]
    ],
    'nm_unit' => [
        'label' => 'Nama Unit',
        'rules' => 'trim|required|max_length[100]|is_unique[unit.nm_unit, id, {id}]',
        'errors' => [
            'required' => 'Nama Unit harus diisi.',
            'max_length' => 'Nama Unit maksimal 100 karakter.',
            'is_unique' => 'Nama Unit tersebut sudah digunakan.'
        ]
    ],
    'opd_id' => [
        'label' => 'OPD',
        'rules' => 'trim|required|max_length[2]|numeric',
        'errors' => [
            'required' => 'OPD harus diisi.',
            'max_length' => 'OPD tidak valid.',
            'numeric' => 'OPD tidak valid.'
        ]
    ]
];
