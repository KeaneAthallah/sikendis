<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Data > Penggunaan > Pengguna Rutin
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 2 Apr 2023
 * Last Update  : 2 Apr 2023
**/
$pengguna_rutin = [
    'no_bap' => [
        'label' => 'No. BAP',
        'rules' => 'trim|required|max_length[50]|is_unique[pengguna_rutin.no_bap, id, {id}]',
        'errors' => [
            'required' => 'No. BAP harus diisi.',
            'max_length' => 'No. BAP maksimal 50 karakter.',
            'is_unique' => 'No. BAP tersebut sudah digunakan.'
        ]
    ],
    'tgl_bap' => [
        'label' => 'Tgl. BAP',
        'rules' => 'trim|required|max_length[10]',
        'errors' => [
            'required' => 'Tgl. BAP harus diisi.',
            'max_length' => 'Tgl. BAP maksimal 10 karakter.'
        ]
    ],
    'kendaraan_id' => [
        'label' => 'Kendaraan',
        'rules' => 'trim|required|max_length[6]|numeric',
        'errors' => [
            'required' => 'Kendaraan harus diisi.',
            'max_length' => 'Kendaraan tidak valid.',
            'numeric' => 'Kendaraan tidak valid.'
        ]
    ],
    'pengguna_id' => [
        'label' => 'Pengguna',
        'rules' => 'trim|required|max_length[6]|numeric',
        'errors' => [
            'required' => 'Pengguna harus diisi.',
            'max_length' => 'Pengguna tidak valid.',
            'numeric' => 'Pengguna tidak valid.'
        ]
    ],
    'file_bap' => [
        'label' => 'File BAP',
        'rules' => 'max_size[file_bap,2048]|uploaded[file_bap]|ext_in[file_bap,pdf]', # uploaded[file_bap] artinya required
        'errors' => [
            'ext_in' => 'File invalid. Silahkan gunakan format pdf.',
            'uploaded' => 'File BAP harus diisi.',
            'max_size' => 'File BAP maksimal 2 MB.'
        ]
    ]
];
