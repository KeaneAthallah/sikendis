<?php
/**
 * File			: layout_login.php
 * Description  : Template login
 * Created By	: Ruhaendi (titasictech.com)
 * Created Date : 3 Mar 2023
 * Last Update  : 5 Mar 2023
**/

# agar jika ada perubahan css/js tidak perlu lg diclear data browser
# karena browser sudah dipaksa ambil css/js yang baru
# jika sudah production harap rand() diganti manual v9.9.0 (sesuai update)
# agar bisa disimpan di cache
$rand = rand();

/**
<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
-->
**/
?>
<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="SIKENDIS, Sistem Informasi Kendaraan Dinas, Provinsi Sulawesi Tengah">
    <meta name="author" content="titasictech.com">
    <?php
      # untuk generate meta csrf token
      # PHP_EOL sama dengan enter / ln
      echo csrf_meta().PHP_EOL;
    ?>
    <title><?= $title ?> | SIKENDIS</title>
    <link rel="icon" type="image/x-icon" href="<?= site_url('public/assets/img/favicon/favicon.ico') ?>" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= site_url('public/assets/vendor/fonts/boxicons.css') ?>" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= site_url('public/assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= site_url('public/assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= site_url('public/assets/css/demo.css') ?>" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= site_url('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
    <!-- Page -->
    <link rel="stylesheet" href="<?= site_url('public/assets/vendor/css/pages/page-auth.css') ?>" />
    <!-- My Style -->
    <link rel="stylesheet" href="<?= site_url('public/assets/plugins/sweetalert2/sweetalert2.min.css') ?>" />
    <link rel="stylesheet" href="<?= site_url('public/assets/css/mystyle.css?v='.$rand) ?>">
    <!-- Helpers -->
    <script src="<?= site_url('public/assets/vendor/js/helpers.js') ?>"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= site_url('public/assets/js/config.js') ?>"></script>
    <!-- Global variable -->
    <script> var _HOST = '<?= site_url() ?>'; </script>
  </head>
  <body>
    <!-- Content -->
    <?= $content ?>
    <!-- Toast -->
    <?= view('contents/toast') ?>
    <!-- Core JS -->
    <script src="<?= site_url('public/assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= site_url('public/assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= site_url('public/assets/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= site_url('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= site_url('public/assets/vendor/js/menu.js') ?>"></script>
    <!-- Main JS -->
    <script src="<?= site_url('public/assets/js/main.js') ?>"></script>
    <!-- My Script -->
    <script src="<?= site_url('public/assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= site_url('public/assets/js/myscript.js?v='.$rand) ?>"></script>
    <?php
      # untuk script page content
      if (isset($content_script)) echo $content_script;
    ?>
  </body>
</html>
