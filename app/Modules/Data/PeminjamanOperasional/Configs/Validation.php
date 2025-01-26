<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Data > Penggunaan > Peminjaman Operasional
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 11 Apr 2023
 * Last Update  : 11 Apr 2023
**/
$peminjaman_operasional = [
    'kendaraan_id' => [
        'label' => 'Kendaraan',
        'rules' => 'trim|required|max_length[6]|numeric',
        'errors' => [
            'required' => 'Kendaraan harus diisi.',
            'max_length' => 'Kendaraan tidak valid.',
            'numeric' => 'Kendaraan tidak valid.'
        ]
    ],
    'instansi' => [
        'label' => 'Instansi',
        'rules' => 'trim|required|max_length[100]',
        'errors' => [
            'required' => 'Instansi harus diisi.',
            'max_length' => 'Instansi maksimal 100 karakter.'
        ]
    ],
    'penanggung_jawab' => [
        'label' => 'Penanggungjawab',
        'rules' => 'trim|required|max_length[50]',
        'errors' => [
            'required' => 'Penanggungjawab harus diisi.',
            'max_length' => 'Penanggungjawab maksimal 50 karakter.'
        ]
    ],
    'no_telp' => [
        'label' => 'No. Telepon',
        'rules' => 'trim|required|max_length[15]',
        'errors' => [
            'required' => 'No. Telepon harus diisi.',
            'max_length' => 'No. Telepon maksimal 15 karakter.'
        ]
    ],
    'no_disposisi' => [
        'label' => 'No. Disposisi',
        'rules' => 'trim|max_length[50]',
        'errors' => [
            'max_length' => 'No. Disposisi maksimal 50 karakter.'
        ]
    ],
    'tgl_disposisi' => [
        'label' => 'Tgl. Disposisi',
        'rules' => 'trim|max_length[10]',
        'errors' => [
            'max_length' => 'Tgl. Disposisi maksimal 10 karakter.'
        ]
    ],
    'no_permohonan' => [
        'label' => 'No. Permohonan',
        'rules' => 'trim|max_length[50]',
        'errors' => [
            'max_length' => 'No. Permohonan maksimal 50 karakter.'
        ]
    ],
    'tgl_permohonan' => [
        'label' => 'Tgl. Permohonan',
        'rules' => 'trim|max_length[10]',
        'errors' => [
            'max_length' => 'Tgl. Permohonan maksimal 10 karakter.'
        ]
    ],
    'file_disposisi' => [
        'label' => 'File Disposisi',
        'rules' => 'max_size[file_disposisi,2048]|ext_in[file_disposisi,pdf]', # uploaded[file_disposisi] artinya required
        'errors' => [
            'ext_in' => 'File Disposisi. Silahkan gunakan format pdf.',
            'max_size' => 'File Disposisi maksimal 2 MB.'
        ]
    ],
    'file_permohonan' => [
        'label' => 'File Permohonan',
        'rules' => 'max_size[file_permohonan,2048]|ext_in[file_permohonan,pdf]', # uploaded[file_permohonan] artinya required
        'errors' => [
            'ext_in' => 'File Permohonan. Silahkan gunakan format pdf.',
            'max_size' => 'File Permohonan maksimal 2 MB.'
        ]
    ],
    'tgl_mulai' => [
        'label' => 'Tgl. Mulai',
        'rules' => 'trim|required|max_length[10]',
        'errors' => [
            'required' => 'Tgl. Mulai harus diisi.',
            'max_length' => 'Tgl. Mulai maksimal 10 karakter.'
        ]
    ],
    'tgl_selesai' => [
        'label' => 'Tgl. Selesai',
        'rules' => 'trim|required|max_length[10]',
        'errors' => [
            'required' => 'Tgl. Selesai harus diisi.',
            'max_length' => 'Tgl. Selesai maksimal 10 karakter.'
        ]
    ]
];
