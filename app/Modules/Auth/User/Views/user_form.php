<?php 
/**
 * File			: user_form.php
 * Description  : View untuk halaman Auth > User (Input User)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 18 Mar 2023
 * Last Update  : 18 Mar 2023
**/
# jika menggunakan form_open(), maka csrf token otomatis sudah dibuat.
# esc() berfungsi menjaga serangan xss (cross site scripting)
?>
<?= form_open('auth/user/save', ['id' => 'form-user', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">   
   <input type="hidden" id="user-id" name="id" value="<?= esc($data['id'] ?? '') ?>">  
   <div class="form-body">
      <div class="row mb-3">
         <label for="user-name" class="col-md-3 col-form-label">User Name</label>
         <div class="col-md-9">
            <input type="text" id="user-name" class="form-control" name="user_name" placeholder="" value="<?= esc($data['user_name'] ?? '') ?>" required>
         </div>
      </div>
      <div class="row mb-3">
         <label for="nama-lengkap" class="col-md-3 col-form-label">Nama Lengkap</label>
         <div class="col-md-9">
            <input type="text" id="nama-lengkap" class="form-control" name="nama_lengkap" placeholder="" value="<?= esc($data['nama_lengkap'] ?? '') ?>" required>
         </div>
      </div>
      <div class="row mb-3">
         <label for="level-id" class="col-md-3 col-form-label">Level</label>
         <div class="col-md-9">
            <select id="level-id" class="form-select form-select js-choices" name="level_id" required>
               <option value="">-- Pilih --</option>
               <?php
                  foreach ($level as $lv)	{
                     echo '<option value="'.$lv['id'].'"'.($sts != 'add' && $lv['id'] == $data['level_id'] ? ' selected' : '').'>'.$lv['keterangan'].'</option>';
                  }
					?>
            </select>
         </div>
      </div>
      <div class="row mb-3">
         <label for="unit-id" class="col-md-3 col-form-label">Unit</label>
         <div class="col-md-9">
            <select id="unit-id" class="form-select form-select js-choices <?= ($sts != 'add' && $data['level_id'] == '0' ? 'no-click' : '') ?>" name="unit_id" required>
               <option value="">-- Pilih --</option>
               <?php
                  foreach ($unit as $u)	{
                     echo '<option value="'.$u['id'].'"'.($sts != 'add' && $u['id'] == $data['unit_id'] ? ' selected' : '').'>'.$u['nm_unit'].'</option>';
                  }
					?>
            </select>
         </div>
      </div>
      <div class="row mb-3">
         <label for="keterangan" class="col-md-3 col-form-label">Keterangan</label>
         <div class="col-md-9">
            <input type="text" id="keterangan" class="form-control" name="keterangan" placeholder="Boleh dikosongkan" value="<?= esc($data['keterangan'] ?? '') ?>">
         </div>
      </div>
      <div class="row mb-3">
         <label for="chk-status" class="col-md-3 col-form-label">Status</label>
         <div class="col-md-9">
            <div class="form-check form-switch d-flex align-items-center">
               <input type="checkbox" id="chk-status" class="form-check-input" name="is_active" value="T" <?= ($sts != 'add' && $data['is_active'] == 'T' ? 'checked' : '') ?>>
               <label class="form-check-label mb-0" for="chk-status"><?= ($sts != 'add' && $data['is_active'] == 'T' ? 'Aktif' : 'Tidak Aktif') ?></label>
            </div>
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
   if (_sts == 'view') $(document).find('#form-user :input').not('#btn-close').prop('disabled', true);
</script>

