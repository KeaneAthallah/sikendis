<?php 
/**
 * File			: dashboard.php
 * Description  : View untuk halaman utama
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 2 Mar 2023
 * Last Update  : 15 May 2023
**/
?>
<div class="row">
    <div class="col-md-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat datang <strong><?= session()->get('nama_lengkap') ?></strong>...</h5>
                        <p class="mb-4">
                            <?= (session()->get('level_id') == 2 ? session()->get('nm_unit') : '') ?>
                        </p>
                        <!--<a href="javascript:;" class="btn btn-sm btn-outline-primary">Mulai</a>-->
                    </div>
                </div>
                <!--
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img
                        src="<?= site_url('public/assets/img/illustrations/man-with-laptop-light.png') ?>"
                        height="140"
                        alt="View Badge User"
                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                        data-app-light-img="illustrations/man-with-laptop-light.png"
                        />
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
</div>
<?php if (session()->get('level_id') != 2) { # selain operator ?>
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class="dsb-icon bx bx-car text-info me-0 w-100 h-100 d-flex justify-content-center align-items-center bg-label-primary"></i>
                    </div>
                    <div class="dropdown">
                        <button
                        class="btn p-0"
                        type="button"
                        id="cardOpt3"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <!--
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                        -->
                    </div>
                </div>
                <span class="mb-1">Kendaraan Rutin</span>
                <h3 class="card-title mb-1"><?= $summary->kend_rutin ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class="dsb-icon bx bx-car text-danger me-0 w-100 h-100 d-flex justify-content-center align-items-center bg-label-danger"></i>
                    </div>
                    <div class="dropdown">
                        <button
                        class="btn p-0"
                        type="button"
                        id="cardOpt6"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <!--
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                        -->
                    </div>
                </div>
                <span class="mb-1">Kendaran Operasional</span>
                <h3 class="card-title mb-1"><?= $summary->kend_operasional ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class="dsb-icon bx bx-car text-success me-0 w-100 h-100 d-flex justify-content-center align-items-center bg-label-success"></i>
                    </div>
                    <div class="dropdown">
                        <button
                        class="btn p-0"
                        type="button"
                        id="cardOpt4"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <!--
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                        -->
                    </div>
                </div>
                <span class="mb-1">Kend. Operasional Bebas</span>
                <h3 class="card-title mb-1"><?= $summary->ko_bebas ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class="dsb-icon bx bx-car text-warning me-0 w-100 h-100 d-flex justify-content-center align-items-center bg-label-warning"></i>
                    </div>
                    <div class="dropdown">
                        <button
                        class="btn p-0"
                        type="button"
                        id="cardOpt1"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        >
                        <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <!--
                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                        -->
                    </div>
                </div>
                <span class="mb-1">Peminjaman Kendaraan</span>
                <h3 class="card-title mb-1"><?= $summary->peminjaman_op ?></h3>
            </div>
        </div>
    </div>
</div>
<?php } ?>
