<?php 
/**
 * File			: kendaraan_form.php
 * Description  : View untuk halaman Master > Kendaraan > Kendaraan [Rutin/Operasional] (Input Kendaraan)
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 21 Mar 2023
 * Last Update  : 24 Mar 2023
**/
# jika menggunakan form_open(), maka csrf token otomatis sudah dibuat.
# esc() berfungsi menjaga serangan xss (cross site scripting)
   $segment = getSegment();
?>
<?= form_open('master/kendaraan/'.$segment[2].'/save', ['id' => 'form-kendaraan', 'method' => 'post']) ?>
   <input type="hidden" id="sts" name="sts" value="<?= esc($sts) ?>">
   <input type="hidden" id="kendaraan-id" name="id" value="<?= esc($data['id'] ?? '') ?>">
   <div class="form-body">
      <div class="row mb-2">
         <label for="roda-id" class="col-md-3 col-form-label">Tipe Roda <sup class="text-danger">*</sup></label>
         <div class="col-md-3">
            <select id="roda-id" class="form-select form-select js-choices" name="roda_id" required>
               <option value="">-- Pilih --</option>
               <?php foreach ($roda as $r) { ?>
               <option value="<?= $r['id'] ?>" <?= ($r['id'] == ($data['roda_id'] ?? '') ? 'selected' : '') ?>><?= $r['keterangan'] ?></option>
               <?php } ?>
            </select>
         </div>
      </div>
      <div class="row mb-2">
         <label for="kd-aset" class="col-md-3 col-form-label">Kode Barang <sup class="text-danger">*</sup></label>
         <div class="col-md-4">
            <input type="text" id="kd-aset" class="form-control" name="kd_aset" placeholder="" value="<?= esc($data['kd_aset'] ?? '') ?>" required />
         </div>
      </div>
      <div class="row mb-2">
         <label for="nama-aset" class="col-md-3 col-form-label">Nama Barang <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <input type="text" id="nama-aset" class="form-control" name="nama_aset" placeholder="" value="<?= esc($data['nama_aset'] ?? '') ?>" required />
         </div>
      </div>
      <div class="row mb-2">
         <label for="noreg" class="col-md-3 col-form-label">No. Register</label>
         <div class="col-md-2">
            <input type="text" id="noreg" class="form-control" name="noreg" placeholder="" value="<?= esc($data['noreg'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="merk" class="col-md-3 col-form-label">Merek Kendaraan <sup class="text-danger">*</sup></label>
         <div class="col-md-9">
            <input type="text" id="merk" class="form-control" name="merk" placeholder="" value="<?= esc($data['merk'] ?? '') ?>" required />
         </div>
      </div>
      <div class="row mb-2">
         <label for="ukuran-cc" class="col-md-3 col-form-label">Ukuran CC</label>
         <div class="col-md-3">
            <input type="text" id="ukuran-cc" class="form-control" name="ukuran_cc" placeholder="" value="<?= esc($data['ukuran_cc'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="bahan" class="col-md-3 col-form-label">Bahan</label>
         <div class="col-md-3">
            <input type="text" id="bahan" class="form-control" name="bahan" placeholder="" value="<?= esc($data['bahan'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="th-beli" class="col-md-3 col-form-label">Tahun Pembelian <sup class="text-danger">*</sup></label>
         <div class="col-md-2">
            <input type="text" id="th-beli" class="form-control" name="th_beli" placeholder="" value="<?= esc($data['th_beli'] ?? '') ?>" required />
         </div>
      </div>
      <div class="row mb-2">
         <label for="no-rangka" class="col-md-3 col-form-label">No. Rangka <sup class="text-danger">*</sup></label>
         <div class="col-md-6">
            <input type="text" id="no-rangka" class="form-control" name="no_rangka" placeholder="" value="<?= esc($data['no_rangka'] ?? '') ?>" required />
         </div>
      </div>
      <div class="row mb-2">
         <label for="no-mesin" class="col-md-3 col-form-label">No. Mesin <sup class="text-danger">*</sup></label>
         <div class="col-md-6">
            <input type="text" id="no-mesin" class="form-control" name="no_mesin" placeholder="" value="<?= esc($data['no_mesin'] ?? '') ?>" required />
         </div>
      </div>
      <div class="row mb-2">
         <label for="no-polisi" class="col-md-3 col-form-label">No. Polisi</label>
         <div class="col-md-6">
            <input type="text" id="no-polisi" class="form-control" name="no_polisi" placeholder="" value="<?= esc($data['no_polisi'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="no-bpkb" class="col-md-3 col-form-label">No. BPKB</label>
         <div class="col-md-6">
            <input type="text" id="no-bpkb" class="form-control" name="no_bpkb" placeholder="" value="<?= esc($data['no_bpkb'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="asal-usul-id" class="col-md-3 col-form-label">Asal Usul</label>
         <div class="col-md-3">
            <select id="asal-usul-id" class="form-select form-select js-choices" name="asal_usul_id">
               <option value="">-- Pilih --</option>
               <?php foreach ($asal_usul as $au) { ?>
               <option value="<?= $au['id'] ?>" <?= ($au['id'] == ($data['asal_usul_id'] ?? '') ? 'selected' : '') ?>><?= $au['keterangan'] ?></option>
               <?php } ?>
            </select>
         </div>
      </div>
      <div class="row mb-2">
         <label for="warna" class="col-md-3 col-form-label">Warna Kendaraan</label>
         <div class="col-md-4">
            <input type="text" id="warna" class="form-control" name="warna" placeholder="" value="<?= esc($data['warna'] ?? '') ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="asal-usul-id" class="col-md-3 col-form-label">Bahan Bakar</label>
         <div class="col-md-3">
            <select id="bahan-bakar-id" class="form-select form-select js-choices" name="bahan_bakar_id">
               <option value="">-- Pilih --</option>
               <?php foreach ($bahan_bakar as $bb) { ?>
               <option value="<?= $bb['id'] ?>" <?= ($bb['id'] == ($data['bahan_bakar_id'] ?? '') ? 'selected' : '') ?>><?= $bb['keterangan'] ?></option>
               <?php } ?>
            </select>
         </div>
      </div>
      <div class="row mb-2">
         <label for="harga" class="col-md-3 col-form-label">Harga</label>
         <div class="col-md-4">
            <input type="text" id="harga" class="form-control text-end" name="harga" placeholder="0" value="<?= esc(number_format(($data['harga'] ?? '0'), 0, ',', '.')) ?>" />
         </div>
      </div>
      <div class="row mb-2">
         <label for="keterangan" class="col-md-3 col-form-label">Keterangan</label>
         <div class="col-md-9">
            <textarea id="keterangan" class="form-control" name="keterangan" placeholder=""><?= esc($data['keterangan'] ?? '') ?></textarea>
         </div>
      </div>
      <div class="row mb-2">
         <label for="photo" class="col-md-3 col-form-label">Photo Kendaraan</label>
         <div class="col-md-9">
            <input type="file" id="photo" class="form-control" name="photo">
         </div>
      </div>
      <div class="row mb-2">
         <label for="photo-stnk" class="col-md-3 col-form-label">Photo STNK</label>
         <div class="col-md-9">
            <input type="file" id="photo-stnk" class="form-control" name="photo_stnk">
         </div>
      </div>
      <div class="row mb-2">
         <label for="photo-bpkb" class="col-md-3 col-form-label">Photo BPKB</label>
         <div class="col-md-9">
            <input type="file" id="photo-bpkb" class="form-control" name="photo_bpkb">
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
   if (_sts == 'view') $(document).find('#form-kendaraan :input').not('#btn-close').prop('disabled', true);
</script>

