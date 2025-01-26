<?php
/**
 * File			: menu.php
 * Description  : view untuk menu/sidebar
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 2 Mar 2023
 * Last Update  : 15 May 2023
**/
$segment = getSegment();
?>
<ul class="menu-inner py-1">
    <li class="menu-item <?= ((isset($segment[0]) && $segment[0] == '') || (isset($segment[0]) && $segment[0] == 'dashboard') ? 'active' : '') ?>">
        <a href="<?= site_url('dashboard') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
    <?php if (in_array(session()->get('level_id'), [0, 2])) { # 0 = admin, 2 = operator ?>
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text text-primary fw-bold">Master</span>
    </li>
     <?php if (session()->get('level_id') == 0) { # admin ?>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'kendaraan' ? 'active open' : '') ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-car text-primary"></i>
            <div data-i18n="Kendaraan">Kendaraan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item <?= (isset($segment[2]) && $segment[2] == 'kendaraan-rutin' ? 'active' : '') ?>">
                <a href="<?= site_url('master/kendaraan/kendaraan-rutin') ?>" class="menu-link">
                    <div data-i18n="Kendaraan Rutin">Kendaraan Rutin</div>
                </a>
            </li>
            <li class="menu-item  <?= (isset($segment[2]) && $segment[2] == 'kendaraan-operasional' ? 'active' : '') ?>">
                <a href="<?= site_url('master/kendaraan/kendaraan-operasional') ?>" class="menu-link">
                <div data-i18n="Kendaraan Operasional" data-bs-toggle="tooltip" data-bs-original-title="Kendaraan Operasional">Kendaraan Operasional</div>
                </a>
            </li>
        </ul>
    </li>
    <?php } ?>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'pengguna' ? 'active' : '') ?>">
        <a href="<?= site_url('master/pengguna') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group text-primary"></i>
            <div data-i18n="Pengguna">Pengguna</div>
        </a>
    </li>
    <?php if (session()->get('level_id') == 0) { # admin ?>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'opd' ? 'active open' : '') ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-home text-primary"></i>
            <div data-i18n="OPD">OPD</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item <?= (isset($segment[2]) && $segment[2] == 'opd' ? 'active' : '') ?>">
                <a href="<?= site_url('master/opd/opd') ?>" class="menu-link">
                    <div data-i18n="OPD">OPD</div>
                </a>
            </li>
            <li class="menu-item <?= (isset($segment[2]) && $segment[2] == 'unit' ? 'active' : '') ?>">
                <a href="<?= site_url('master/opd/unit') ?>" class="menu-link">
                <div data-i18n="Unit">Unit</div>
                </a>
            </li>
        </ul>
    </li>
    <?php } ?>
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text text-primary fw-bold">Data</span>
    </li>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'opd' ? 'active open' : '') ?>">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-user-pin text-primary"></i>
            <div data-i18n="Penggunaan">Penggunaan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item <?= (isset($segment[2]) && $segment[2] == 'pengguna-rutin' ? 'active' : '') ?>">
                <a href="<?= site_url('data/penggunaan/pengguna-rutin') ?>" class="menu-link">
                    <div data-i18n="Pengguna Rutin">Pengguna Rutin</div>
                </a>
            </li>
            <li class="menu-item <?= (isset($segment[2]) && $segment[2] == 'peminjaman-operasional' ? 'active' : '') ?>">
                <a href="<?= site_url('data/penggunaan/peminjaman-operasional') ?>" class="menu-link">
                    <div data-i18n="Peminjaman Operasional" data-bs-toggle="tooltip" data-bs-original-title="Peminjaman Operasional">Peminjaman Operasional</div>
                </a>
            </li>
        </ul>
    </li>
    <?php } ?>
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text text-primary fw-bold">Monitoring</span>
    </li>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'monitoring-kendaraan-rutin' ? 'active open' : '') ?>">
        <a href="<?= site_url('monitoring/monitoring-kendaraan-rutin') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-desktop text-primary"></i>
            <div data-i18n="Kendaraan Rutin">Kendaraan Rutin</div>
        </a>
    </li>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'monitoring-kendaraan-operasional' ? 'active open' : '') ?>">
        <a href="<?= site_url('monitoring/monitoring-kendaraan-operasional') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-desktop text-danger"></i>
            <div data-i18n="Kendaraan Operasional">Kendaraan Operasional</div>
        </a>
    </li>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'display' ? 'active open' : '') ?>">
        <a href="<?= site_url('monitoring/display') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-desktop text-secondary"></i>
            <div data-i18n="Display">Display</div>
        </a>
    </li>
    <?php if (in_array(session()->get('level_id'), [0])) { # 0 = admin ?>
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text text-primary fw-bold">Integrasi</span>
    </li>
    <li class="menu-item">
        <a href="#" class="menu-link">
            <i class="menu-icon tf-icons bx bx-network-chart text-primary"></i>
            <div data-i18n="User">Pajak Kendaraan</div>
        </a>
    </li>
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text text-primary fw-bold">Auth</span>
    </li>
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'user' ? 'active' : '') ?>">
        <a href="<?= site_url('auth/user') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user text-primary"></i>
            <div data-i18n="User">User</div>
        </a>
    </li>
    <?php } ?>
    <!--
    <li class="menu-item <?= (isset($segment[1]) && $segment[1] == 'change-password' ? 'active' : '') ?>">
        <a href="<?= site_url('auth/change-password') ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-key text-primary"></i>
            <div data-i18n="Ubah Password">Ubah Password</div>
        </a>
    </li>
    -->
</ul>
