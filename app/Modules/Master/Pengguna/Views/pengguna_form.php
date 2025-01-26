<?php 
/**
 * File			: pengguna_form.php
 * Description  : View untuk halaman Master > Pengguna (Input Pengguna)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 26 Mar 2023
 * Last Update  : 26 Mar 2023
**/
# jika menggunakan form_open(), maka csrf token otomatis sudah dibuat.
# esc() berfungsi menjaga serangan xss (cross site scripting)
?>
<?= form_open('master/pengguna/save', ['id' => 'form-pengguna', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">   
   <input type="hidden" id="pengguna-id" name="id" value="<?= esc($data['id'] ?? '') ?>">
   <div class="form-body">
      <div class="row mb-3">
         <label for="nip" class="col-md-3 col-form-label">NIP <sup class="text-danger">*</sup></label>
         <div class="col-md-6">
            <input type="text" id="nip" class="form-control" name="nip" placeholder="" value="<?= esc($data['nip'] ?? '') ?>" required>
         </div>
      </div>
      <div class="row mb-3">
         <label for="nama-lengkap" class="col-md-3 col-form-label">Nama Lengkap <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <input type="text" id="nama-lengkap" class="form-control" name="nama_lengkap" placeholder="" value="<?= esc($data['nama_lengkap'] ?? '') ?>" required>
         </div>
      </div>
      <div class="row mb-3">
         <label for="jabatan" class="col-md-3 col-form-label">Jabatan <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <input type="text" id="jabatan" class="form-control" name="jabatan" placeholder="" value="<?= esc($data['jabatan'] ?? '') ?>" required>
         </div>
      </div>
      <div class="row mb-3">
         <label for="unit-id" class="col-md-3 col-form-label">Unit <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <select id="unit-id" class="form-select form-select js-choices" name="unit_id" required>
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
         <label for="sub-bagian" class="col-md-3 col-form-label">Sub Bagian</label>
         <div class="col-md-9">
            <input type="text" id="sub-bagian" class="form-control" name="sub_bagian" placeholder="" value="<?= esc($data['sub_bagian'] ?? '') ?>" >
         </div>
      </div>
      <div class="row mb-3">
         <label for="no-telp" class="col-md-3 col-form-label">No. Telepon <sup class="text-danger">*</sup></label>
         <div class="col-md-6">
            <input type="text" id="no-telp" class="form-control" name="no_telp" placeholder="" value="<?= esc($data['no_telp'] ?? '') ?>" required>
         </div>
      </div>
      <div class="row mb-2">
         <label for="photo" class="col-md-3 col-form-label">Photo</label>
         <div class="col-md-9">
            <input type="file" id="photo" class="form-control" name="photo" accept="image/png, image/jpeg">
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
   if (_sts == 'view') $(document).find('#form-pengguna :input').not('#btn-close').prop('disabled', true);
</script>

