<?php 
/**
 * File			: display_list.php
 * Description  : View untuk halaman Monitoring > Display
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 4 Mei 2023
 * Last Update  : 5 Mei 2023
**/
?>
<style>
   .display {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1090;
      width: 100%;
      height: 100%;
      overflow-x: hidden;
      overflow-y: auto;
      outline: 0;
      min-height: 100%;
      --bs-gutter-x: 0;
      --bs-gutter-y: 0;
      margin-top: 0;
      margin-right: 0;
      margin-left: 0;
   }
   div.dataTables_wrapper {
      min-height: 85vh;
   }
</style>
<div id="list-display" class="row display">
   <div class="col-md-12">
      <div class="card mb-4">
         <div class="card-header">
            <h5 class="mb-0 text-primary">Kendaraan Operasional</h5>
         </div>
         <div class="card-body table-responsive">
            <table id="dt-<?= $mod ?>" class="table table-flush nowrap" style="width:100%">
               <thead class="thead-light">
                  <tr>
                     <th>No. Polisi</th>
                     <th>Status</th>
                     <th>Instansi</th>
                     <th>Kontak</th>
                     <th>Tgl. Mulai</th>
                     <th>Tgl. Selesai</th>
                  </tr>
               </thead>
               <tbody></tbody>
               <tfoot></tfoot>
            </table>
         </div>
      </div>
   </div>
</div>
