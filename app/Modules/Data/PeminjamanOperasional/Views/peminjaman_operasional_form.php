<?php 
/**
 * File			: peminjaman_operasional_form.php
 * Description  : View untuk halaman Data > Penggunaan > Peminjaman Operasional (Input Peminjaman Operasional)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 6 Mar 2023
 * Last Update  : 11 Apr 2023
**/
?>
<?= form_open('data/penggunaan/peminjaman-operasional/save', ['id' => 'form-peminjaman-operasional', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">
   <input type="hidden" id="peminjaman-operasional-id" name="id" value="<?= esc($data['id'] ?? '') ?>">
   <div class="form-body">
      <div class="row mb-2">
         <label for="kendaraan-id" class="col-md-3 col-form-label">Kendaraan <sup class="text-danger">*</sup></label>
         <div class="col-md-6">
            <select id="kendaraan-id" class="modal-choices form-select form-select" name="kendaraan_id">
               <option value="">-- Pilih --</option>
               <?php foreach ($kendaraan as $k) { ?>
               <option value="<?= $k['id'] ?>" <?= ($k['id'] == ($data['kendaraan_id'] ?? '') ? 'selected' : '') ?>><?= $k['no_polisi'] ?></option>
               <?php } ?>
            </select>
         </div>
      </div>
      <div class="row mb-2">
         <label for="instansi" class="col-md-3 col-form-label">Instansi <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <input type="text" id="instansi" class="form-control" name="instansi" placeholder="" value="<?= esc($data['instansi'] ?? '') ?>" required/>
         </div>
      </div>
      <div class="row mb-2">
         <label for="penanggung-jawab" class="col-md-3 col-form-label">Penanggungjawab <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <input type="text" id="penanggung-jawab" class="form-control" name="penanggung_jawab" placeholder="" value="<?= esc($data['penanggung_jawab'] ?? '') ?>" required/>
         </div>
      </div>
      <div class="row mb-2">
         <label for="no-telp" class="col-md-3 col-form-label">No. Telepon <sup class="text-danger">*</sup></label>
         <div class="col-md-6">
            <input type="text" id="no-telp" class="form-control" name="no_telp" placeholder="" value="<?= esc($data['no_telp'] ?? '') ?>" required/>
         </div>
      </div>
      <div class="row mb-2">
         <label for="no-disposisi" class="col-md-3 col-form-label">No. Disposisi</label>
         <div class="col-md-6">
            <input type="text" id="no-disposisi" class="form-control" name="no_disposisi" placeholder="" value="<?= esc($data['no_disposisi'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="tgl-disposisi" class="col-md-3 col-form-label">Tgl. Disposisi</label>
         <div class="col-md-4 date-selector">
            <input type="date" id="tgl-disposisi" class="form-control" name="tgl_disposisi" placeholder="" value="<?= esc($data['tgl_disposisi'] ?? '') ?>" onkeydown="return false" />
            <span class="datepicker-label" style="pointer-events: none; top: 10px !important;"></span>
         </div>
      </div>
      <div class="row mb-2">
         <label for="no-permohonan" class="col-md-3 col-form-label">No. Permohonan</label>
         <div class="col-md-6">
            <input type="text" id="no-permohonan" class="form-control" name="no_permohonan" placeholder="" value="<?= esc($data['no_permohonan'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="tgl-permohonan" class="col-md-3 col-form-label">Tgl. Permohonan</label>
         <div class="col-md-4 date-selector">
            <input type="date" id="tgl-permohonan" class="form-control" name="tgl_permohonan" placeholder="" value="<?= esc($data['tgl_permohonan'] ?? '') ?>" onkeydown="return false" />
            <span class="datepicker-label" style="pointer-events: none; top: 10px !important;"></span>
         </div>
      </div>
      <div class="row mb-2">
         <label for="file-disposisi" class="col-md-3 col-form-label">File Disposisi</label>
         <div class="col-md-9">
            <input type="file" id="file-disposisi" class="form-control" name="file_disposisi" accept=".pdf">
         </div>
      </div>
      <div class="row mb-2">
         <label for="file-permohonan" class="col-md-3 col-form-label">File Permohonan</label>
         <div class="col-md-9">
            <input type="file" id="file-permohonan" class="form-control" name="file_permohonan" accept=".pdf">
         </div>
      </div>
      <div class="row mb-2">
         <label for="tgl-mulai" class="col-md-3 col-form-label">Tgl. Mulai <sup class="text-danger">*</sup></label>
         <div class="col-md-3 date-selector">
            <input type="date" id="tgl-mulai" class="form-control" name="tgl_mulai" placeholder="" value="<?= esc($data['tgl_mulai'] ?? '') ?>" onkeydown="return false" required />
            <span class="datepicker-label" style="pointer-events: none; top: 10px !important;"></span>
         </div>
         <label for="tgl-selesai" class="col-md-2 col-form-label">Tgl. Selesai <sup class="text-danger">*</sup></label>
         <div class="col-md-3 date-selector">
            <input type="date" id="tgl-selesai" class="form-control" name="tgl_selesai" placeholder="" value="<?= esc($data['tgl_selesai'] ?? '') ?>" onkeydown="return false" required />
            <span class="datepicker-label" style="pointer-events: none; top: 10px !important;"></span>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-12 d-flex justify-content-end mt-4">
            <?php if ($sts != 'view') { ?>
            <button id="btn-save" type="submit" class="btn btn-primary me-1 mb-1 px-3 d-flex align-items-center">
               <span class="tf-icons bx bx-save me-1"></span> Simpan
            </button>
            <?php } ?>
            <button id="btn-close" type="button" class="btn btn-light-secondary me-1 mb-1 px-3 d-flex align-items-center" onclick="javascript: $('.modal button.btn-close').trigger('click');">
               <span class="tf-icons bx bx-undo me-1"></span> Tutup
            </button>
         </div>
      </div>
   </div>
<?= form_close() ?>
<script> 
   _sts = '<?= $sts ?>'; 
   // untuk modal, class modal-choices
   // dan scriptnya langsung disimpan di modal
   // karena ga jalan jika disimpan di myscript
   if (typeof initModalChoices === 'undefined') {
      let modalChoices = document.querySelectorAll('.modal-choices');
      let initModalChoices;
      for(let i = 0; i < modalChoices.length; i++) {
         if (modalChoices[i].classList.contains("multiple-remove")) {
            initModalChoices = new Choices(modalChoices[i],
            {
                  delimiter: ',',
                  editItems: true,
                  maxItemCount: -1,
                  removeItemButton: true,
            });
         } else {
            initModalChoices = new Choices(modalChoices[i]);
         }
      }
   }
   // jika status view, disable semua inputan
   if (_sts == 'view') $(document).find('#form-peminjaman-operasional :input').not('#btn-close').prop('disabled', true);
   // harus di modal
   $(function() {
      displayDateFormat($('#form-peminjaman-operasional #tgl-disposisi'), '#form-peminjaman-operasional .datepicker-label', $('#form-peminjaman-operasional #tgl-disposisi').val());
      displayDateFormat($('#form-peminjaman-operasional #tgl-permohonan'), '#form-peminjaman-operasional .datepicker-label', $('#form-peminjaman-operasional #tgl-permohonan').val());
      displayDateFormat($('#form-peminjaman-operasional #tgl-mulai'), '#form-peminjaman-operasional .datepicker-label', $('#form-peminjaman-operasional #tgl-mulai').val());
      displayDateFormat($('#form-peminjaman-operasional #tgl-selesai'), '#form-peminjaman-operasional .datepicker-label', $('#form-peminjaman-operasional #tgl-selesai').val());
      //$('#form-peminjaman-operasional #tgl-disposisi').trigger('change');
      $('#form-peminjaman-operasional #tgl-disposisi, #form-peminjaman-operasional #tgl-permohonan, #form-peminjaman-operasional #tgl-mulai, #form-peminjaman-operasional #tgl-selesai').on('change', function(e) {
         // untuk format input date dd-mm-yyyy
         displayDateFormat($(this), '#form-peminjaman-operasional .datepicker-label', $(this).val());
      });

   });
</script>

