<?php 
/**
 * File			: opd_form.php
 * Description  : View untuk halaman Master > OPD > OPD (Input OPD)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 14 Mar 2023
 * Last Update  : 14 Mar 2023
**/
# jika menggunakan form_open(), maka csrf token otomatis sudah dibuat.
# esc() berfungsi menjaga serangan xss (cross site scripting)
?>
<?= form_open('master/opd/opd/save', ['id' => 'form-opd', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">
   <input type="hidden" id="opd-id" name="id" value="<?= esc($data['id'] ?? '') ?>">
   <div class="form-body">
      <div class="mb-3 row">
         <label for="kd-opd" class="col-md-2 col-form-label">Kode OPD</label>
         <div class="col-md-10">
            <input type="text" id="kd-opd" class="form-control" name="kd_opd" placeholder="" value="<?= esc($data['kd_opd'] ?? '') ?>" required />
         </div>
      </div>
      <div class="mb-3 row">
         <label for="nm-opd" class="col-md-2 col-form-label">Nama OPD</label>
         <div class="col-md-10">
            <input type="text" id="nm-opd" class="form-control" name="nm_opd" placeholder="" value="<?= esc($data['nm_opd'] ?? '') ?>" required />
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
   // jika status view, disable semua inputan
   if (_sts == 'view') $(document).find('#form-opd :input').not('#btn-close').prop('disabled', true);
</script>

