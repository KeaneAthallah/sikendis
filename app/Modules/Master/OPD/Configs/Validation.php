<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Master > OPD > OPD
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 14 Mar 2023
 * Last Update  : 15 Mar 2023
**/
$opd = [
    'kd_opd' => [
        'label' => 'Kode OPD',
        'rules' => 'trim|required|max_length[11]|is_unique[opd.kd_opd, id, {id}]',
        'errors' => [
            'required' => 'Kode OPD harus diisi.',
            'max_length' => 'Kode OPD maksimal 11 karakter.',
            'is_unique' => 'Kode OPD tersebut sudah digunakan.'
        ]
    ],
    'nm_opd' => [
        'label' => 'Nama OPD',
        'rules' => 'trim|required|max_length[100]|is_unique[opd.nm_opd, id, {id}]',
        'errors' => [
            'required' => 'Nama OPD harus diisi.',
            'max_length' => 'Nama OPD maksimal 100 karakter.',
            'is_unique' => 'Nama OPD tersebut sudah digunakan.'
        ]
    ]
];
