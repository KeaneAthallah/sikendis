<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Master > Pengguna
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 26 Mar 2023
 * Last Update  : 26 Mar 2023
**/
$pengguna = [
    'nip' => [
        'label' => 'NIP',
        'rules' => 'trim|required|max_length[21]|numeric|is_unique[pengguna.nip, id, {id}]',
        'errors' => [
            'required' => 'NIP harus diisi.',
            'max_length' => 'NIP maksimal 21 karakter.',
			'numeric' => 'NIP harus angka.',
            'is_unique' => 'NIP tersebut sudah digunakan.'
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
    'jabatan' => [
        'label' => 'Jabatan',
        'rules' => 'trim|required|max_length[50]',
        'errors' => [
            'required' => 'Jabatan harus diisi.',
			'max_length' => 'Jabatan maksimal 50 karakter.',
        ]
    ],
    'unit_id' => [
        'label' => 'Unit',
        'rules' => 'trim|required|max_length[5]|numeric',
        'errors' => [
            'required' => 'Unit harus diisi.',
            'numeric' => 'Unit tidak valid.',
            'max_length' => 'Unit tidak valid.'
        ]
    ],
    'no_telp' => [
        'label' => 'No. Telp',
        'rules' => 'trim|required|max_length[15]|numeric',
        'errors' => [
            'required' => 'No. Telp harus diisi.',
            'max_length' => 'No. Telp maksimal 15 karakter.',
            'numeric' => 'No. Telp tidak valid.'
        ]
    ]
];
