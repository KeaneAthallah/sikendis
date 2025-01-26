<?php 
/**
 * File			 : level_form.php
 * Description  : View untuk halaman Auth > Level (Input Level)
 * Created By	 : Ruhaendi (titasictech.com)
 * Created Date : 26 Nov 2022
 * Last Update  : 26 Nov 2022
**/
# jika menggunakan form_open(), maka csrf token otomatis sudah dibuat.
# esc() berfungsi menjaga serangan xss (cross site scripting)
?>
<?= form_open('auth/level/save', ['id' => 'level-form', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">   
   <div class="form-body">
      <div class="row">
         <div class="col-md-4">
            <label class="col-form-label col-form-label-sm">ID</label>
         </div>
         <div class="col-md-8 form-group">
            <input type="text" id="level-id" name="id" class="form-control form-control-sm" placeholder="" value="<?= esc($data['id'] ?? '') ?>" <?= ($sts == 'edit' ? 'readonly' : 'required') ?>>
         </div>
      </div>
      <div class="row">
         <div class="col-md-4">
            <label class="col-form-label col-form-label-sm">Level</label>
         </div>
         <div class="col-md-8 form-group">
            <input type="text" id="level" name="description" class="form-control form-control-sm" placeholder="" value="<?= esc($data['description'] ?? '') ?>" required>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-12 d-flex justify-content-end mt-4">
            <?php if ($sts != 'view') { ?>
            <button id="btn-save" type="submit" class="btn btn-sm btn-danger btn-icon me-1 mb-1 px-3">
                <span class="btn-inner--icon"><i class="fa fa-save"></i></span>
                <span class="btn-inner--text">Simpan</span>
            </button>
            <?php } ?>
            <button id="btn-close" type="button" class="btn btn-sm btn-light-secondary btn-icon me-1 mb-1 px-3" onclick="javascript: $('.modal button.btn-close').trigger('click');">
                <span class="btn-inner--icon"><i class="fa fa-undo"></i></span>
                <span class="btn-inner--text">Tutup</span>
            </button>
         </div>
      </div>
   </div>   
<?= form_close() ?>
<script> 
   _sts = '<?= $sts ?>'; 
   // jika status view, disable semua inputan
   if (_sts == 'view') $(document).find('#level-form :input').not('#btn-close').prop('disabled', true);
</script>

