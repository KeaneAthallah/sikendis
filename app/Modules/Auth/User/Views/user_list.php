<?php 
/**
 * File			: user_list.php
 * Description  : View untuk halaman Auth > User (List User)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 18 Mar 2023
 * Last Update  : 18 Mar 2023
**/
?>
<div id="list-user" class="row">
   <div class="col-md-12">
      <div class="card mb-4">
         <div class="card-header">
            <h5 class="mb-0 text-primary">User</h5>
            <p class="text-sm mb-3">Daftar Pengguna Aplikasi</p>
            <a id="btn-add" href="javascript:;" class="btn btn-sm btn-primary px-3 mb-0">
               <span class="btn-inner--icon"><i class="bx bx-plus"></i></span>
               <span class="btn-inner--text">Input Baru</span>
            </a>
         </div>
         <div class="card-body table-responsive">
            <table id="dt-<?= $mod ?>" class="table table-flush nowrap" style="width:100%">
               <thead class="thead-light">
                  <tr>
                    <th>User Name</th>
                    <th>Nama Lengkap</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Sedang Login?</th>
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
