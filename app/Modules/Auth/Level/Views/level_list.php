<?php 
/**
 * File			: level_list.php
 * Description  : View untuk halaman Auth > Level (List Level)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 24 Nov 2022
 * Last Update  : 26 Nov 2022
**/
?>
<div id="level-list" class="row mt-0">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h5 class="mb-0">List Level</h5>
                <p class="text-sm mb-3">List level pengguna aplikasi.</p>
                <a id="btn-add" href="javascript:;" class="btn btn-icon btn-sm btn-danger px-3 mb-0">
                    <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                    <span class="btn-inner--text">Input Baru</span>
                </a>
            </div>
            <div class="card-body table-responsive">
                <table id="dt-<?= $mod ?>" class="table table-flush nowrap" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Level</th>
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