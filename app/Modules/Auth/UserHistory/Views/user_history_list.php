<?php 
/**
 * File			: user_history_list.php
 * Description  : View untuk halaman User History
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 25 Dec 2022
 * Last Update  : 6 Jan 2023
**/
?>
<div id="user-history-list" class="row mt-0">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h5 class="mb-0 text-danger">User History</h5>
                <p class="text-sm mb-3">List history aktifitas user .</p>
            </div>
            <div class="card-body table-responsive">
                <?= form_open(current_url(), ['id' => 'filter-form', 'method' => 'get']) ?>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="col-form-label col-form-label-sm font-weight-bold">Level</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <select id="level-id" name="level_id" class="form-control form-select form-select-sm" onchange="$('#user-id').val('');$('#filter-form').submit();">
                                <option value="">-- Pilih --</option>
                                <?php
                                    foreach ($level as $l) {
                                        echo '<option value="'.$l['id'].'"'.(session()->get('level_id') == $l['id'] ? 'selected' : (isset($_GET['level_id']) && $_GET['level_id'] == $l['id'] ? ' selected' : '')).'>'.$l['description'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="col-form-label col-form-label-sm font-weight-bold">User Name</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <select id="user-id" name="user_id" class="form-control form-select form-select-sm" onchange="$('#filter-form').submit();">
                                <option value="">-- Pilih --</option>
                                <?php
                                    foreach ($user as $u) {
                                        echo '<option value="'.$u['id'].'"'.(isset($_GET['user_id']) && $_GET['user_id'] == $u['id'] ? ' selected' : '').'>'.$u['full_name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                <?= form_close() ?>
                <table id="dt-<?= $mod ?>" class="table table-flush" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Aktivitas</th>
                            <th>No. SP</th>
                            <th>Mitra</th>
                            <th>Area</th>
                            <th>Pekerjaan</th>
                            <th>Revisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>  
</div>