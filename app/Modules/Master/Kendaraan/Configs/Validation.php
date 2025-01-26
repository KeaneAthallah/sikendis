<?php 
/**
 * File			: Validation.php
 * Description  : Validation untuk halaman Master > Kendaraan > Kendaraan [Rutin/Operasional]
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 23 Mar 2023
 * Last Update  : 23 Mar 2023
**/
$kendaraan = [
    'roda_id' => [
        'label' => 'Tipe Roda',
        'rules' => 'trim|required|max_length[2]|numeric',
        'errors' => [
            'required' => 'Tipe Roda harus diisi.',
            'max_length' => 'Tipe Roda tidak valid.',
            'numeric' => 'Tipe Roda tidak valid.'
        ]
    ],
    'kd_aset' => [
        'label' => 'Kode Barang',
        'rules' => 'trim|required|max_length[30]',
        'errors' => [
            'required' => 'Kode Barang harus diisi.',
            'max_length' => 'Kode Barang maksimal 30 karakter.'
        ]
    ],
    'nama_aset' => [
        'label' => 'Nama Barang',
        'rules' => 'trim|required|max_length[100]',
        'errors' => [
            'required' => 'Nama Barang harus diisi.',
            'max_length' => 'Nama Barang maksimal 100 karakter.'
        ]
    ],
    'noreg' => [
        'label' => 'No. Register',
        'rules' => 'trim|max_length[4]|numeric',
        'errors' => [
            'max_length' => 'No. Register maksimal 4 karakter.',
            'numeric' => 'No. Register harus angka.'
        ]
    ],
    'merk' => [
        'label' => 'Merek',
        'rules' => 'trim|required|max_length[50]',
        'errors' => [
            'required' => 'Merek harus diisi.',
            'max_length' => 'Merek maksimal 50 karakter.'
        ]
    ],
    'ukuran_cc' => [
        'label' => 'Ukuran CC',
        'rules' => 'trim|max_length[6]|numeric',
        'errors' => [
            'max_length' => 'Ukuran CC maksimal 6 karakter.',
            'numeric' => 'Ukuran CC harus angka.'
        ]
    ],
    'bahan' => [
        'label' => 'Bahan',
        'rules' => 'trim|max_length[30]',
        'errors' => [
            'max_length' => 'Bahan maksimal 30 karakter.'
        ]
    ],
    'th_beli' => [
        'label' => 'Tahun Pembelian',
        'rules' => 'trim|required|max_length[4]|numeric',
        'errors' => [
            'required' => 'Tahun Pembelian harus diisi.',
            'max_length' => 'Tahun Pembelian maksimal 4 karakter.',
            'numeric' => 'Tahun Pembelian harus angka.'
        ]
    ],
    'no_rangka' => [
        'label' => 'No. Rangka',
        'rules' => 'trim|required|max_length[30]|is_unique[kendaraan.no_rangka, id, {id}]',
        'errors' => [
            'required' => 'No. Rangka harus diisi.',
            'max_length' => 'No. Rangka maksimal 30 karakter.',
            'is_unique' => 'No. Rangka tersebut sudah digunakan.'
        ]
    ],
    'no_mesin' => [
        'label' => 'No. Mesin',
        'rules' => 'trim|required|max_length[30]|is_unique[kendaraan.no_mesin, id, {id}]',
        'errors' => [
            'required' => 'No. Mesin harus diisi.',
            'max_length' => 'No. Mesin maksimal 30 karakter.',
            'is_unique' => 'No. Mesin tersebut sudah digunakan.'
        ]
    ],
    'no_polisi' => [
        'label' => 'No. Polisi',
        'rules' => 'trim|max_length[30]|is_unique[kendaraan.no_polisi, id, {id}]',
        'errors' => [
            'max_length' => 'No. Polisi maksimal 30 karakter.',
            'is_unique' => 'No. Polisi tersebut sudah digunakan.'
        ]
    ],
    'no_bpkb' => [
        'label' => 'No. BPKB',
        'rules' => 'trim|max_length[30]|is_unique[kendaraan.no_bpkb, id, {id}]',
        'errors' => [
            'max_length' => 'No. BPKB maksimal 30 karakter.',
            'is_unique' => 'No. BPKB tersebut sudah digunakan.'
        ]
    ],
    'asal_usul_id' => [
        'label' => 'Asal Usul',
        'rules' => 'trim|max_length[2]|numeric',
        'errors' => [
            'max_length' => 'Asal Usul tidak valid.',
            'numeric' => 'Asal Usul tidak valid.'
        ]
    ],
    'warna' => [
        'label' => 'Warna',
        'rules' => 'trim|max_length[20]',
        'errors' => [
            'max_length' => 'Warna maksimal 20 karakter.'
        ]
    ],
    'bahan_bakar_id' => [
        'label' => 'Bahan Bakar',
        'rules' => 'trim|max_length[2]|numeric',
        'errors' => [
            'max_length' => 'Bahan Bakar tidak valid.',
            'numeric' => 'Bahan Bakar tidak valid.'
        ]
    ],
    'keterangan' => [
        'label' => 'Keterangan',
        'rules' => 'trim|max_length[255]',
        'errors' => [
            'max_length' => 'Keterangan maksimal 255 karakter.'
        ]
    ],
    'harga' => [
        'label' => 'Harga',
        'rules' => 'trim|max_length[15]|numeric',
        'errors' => [
            'max_length' => 'Harga maksimal 15 karakter.',
            'numeric' => 'Harga harus angka.'
        ]
    ],
];
