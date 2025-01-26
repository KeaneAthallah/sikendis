<?php 
/**
 * File			: unit_form.php
 * Description  : View untuk halaman Master > OPD > Unit (Input Unit)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 15 Mar 2023
 * Last Update  : 15 Mar 2023
**/
# jika menggunakan form_open(), maka csrf token otomatis sudah dibuat.
# esc() berfungsi menjaga serangan xss (cross site scripting)
?>
<?= form_open('master/opd/unit/save', ['id' => 'form-unit', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">
   <input type="hidden" id="unit-id" name="id" value="<?= esc($data['id'] ?? '') ?>">
   <div class="form-body">
      <div class="mb-3 row">
         <label for="kd-unit" class="col-md-2 col-form-label">Kode Unit</label>
         <div class="col-md-10">
            <input type="text" id="kd-unit" class="form-control" name="kd_unit" placeholder="" value="<?= esc($data['kd_unit'] ?? '') ?>" required />
         </div>
      </div>
      <div class="mb-3 row">
         <label for="nm-unit" class="col-md-2 col-form-label">Nama Unit</label>
         <div class="col-md-10">
            <input type="text" id="nm-unit" class="form-control" name="nm_unit" placeholder="" value="<?= esc($data['nm_unit'] ?? '') ?>" required />
         </div>
      </div>
      <div class="mb-3 row">
         <label for="kd-opd" class="col-md-2 col-form-label">OPD</label>
         <div class="col-md-10">
            <select id="opd-id" class="form-select form-select js-choices" name="opd_id" required>
               <option value="">-- Pilih --</option>
               <?php foreach ($opd as $v) { ?>
               <option value="<?= $v['id'] ?>" <?= ($v['id'] == ($data['opd_id'] ?? '') ? 'selected' : '') ?>><?= $v['kd_opd'].' - '.$v['nm_opd'] ?></option>
               <?php } ?>
            </select>
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
   if (_sts == 'view') $(document).find('#form-unit :input').not('#btn-close').prop('disabled', true);
</script>

