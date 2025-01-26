<?php 
/**
 * File			: pengguna_rutin_form.php
 * Description  : View untuk halaman Data > Penggunaan > Pengguna Rutin (Input Pengguna Rutin)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 30 Mar 2023
 * Last Update  : 2 Apr 2023
**/
?>
<?= form_open('data/penggunaan/pengguna-rutin/save', ['id' => 'form-pengguna-rutin', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">
   <input type="hidden" id="pengguna-rutin-id" name="id" value="<?= esc($data['id'] ?? '') ?>">
   <div class="form-body">
      <div class="row mb-2">
         <label for="no-bap" class="col-md-3 col-form-label">No. BAP <sup class="text-danger">*</sup></label>
         <div class="col-md-6">
            <input type="text" id="no-bap" class="form-control" name="no_bap" placeholder="" value="<?= esc($data['no_bap'] ?? '') ?>" required />
         </div>
      </div>
      <div class="row mb-2">
         <label for="tgl-bap" class="col-md-3 col-form-label">Tgl. BAP <sup class="text-danger">*</sup></label>
         <div class="col-md-4 date-selector">
            <input type="date" id="tgl-bap" class="form-control" name="tgl_bap" placeholder="" value="<?= esc($data['tgl_bap'] ?? '') ?>" onkeydown="return false" required />
            <span class="datepicker-label" style="pointer-events: none; top: 10px !important;"></span>
         </div>
      </div>
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
         <label for="pengguna-id" class="col-md-3 col-form-label">Pengguna <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <select id="pengguna-id" class="modal-choices form-select form-select" name="pengguna_id">
               <option value="">-- Pilih --</option>
               <?php foreach ($pengguna as $p) { ?>
               <option value="<?= $p['id'] ?>" <?= ($p['id'] == ($data['pengguna_id'] ?? '') ? 'selected' : '') ?>><?= $p['nama_lengkap'].' ('.$p['nip'].')' ?></option>
               <?php } ?>
            </select>
         </div>
      </div>
      <div class="row mb-2">
         <label for="file-bap" class="col-md-3 col-form-label">File BAP <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <input type="file" id="file-bap" class="form-control" name="file_bap" accept=".pdf">
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
   if (_sts == 'view') $(document).find('#form-pengguna-rutin :input').not('#btn-close').prop('disabled', true);
   // harus di modal
   $(function() {
      displayDateFormat($('#form-pengguna-rutin #tgl-bap'), '#form-pengguna-rutin .datepicker-label', $('#form-pengguna-rutin #tgl-bap').val());
      //$('#form-pengguna-rutin #tgl-bap').trigger('change');
      $('#form-pengguna-rutin #tgl-bap').on('change', function(e) {
         // untuk format input date dd-mm-yyyy
         displayDateFormat($(this), '#form-pengguna-rutin .datepicker-label', $(this).val());
      });
   });
</script>

