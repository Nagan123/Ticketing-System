<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<html lang="<?php echo lang( 'lang_iso_code' ); ?>">

<head>

<!-- Meta: -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="<?php echo html_escape( db_config( 'site_description' ) ); ?>">
<meta name="keywords" content="<?php echo html_escape( db_config( 'site_keywords' ) ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo html_escape( manage_title( lang( 'under_maintenance' ) ) ); ?></title>

<!-- Favicon: -->
<link rel="icon" href="<?php echo general_uploads( html_escape( db_config( 'site_favicon' ) ) ); ?>">

<!-- Google Fonts: -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">

<!-- Pace: -->
<link rel="stylesheet" href="<?php assets_path( 'vendor/pace/pace.css' ); ?>">

<!-- Bootstrap CSS: -->
<link rel="stylesheet" href="<?php assets_path( 'vendor/bootstrap/css/bootstrap.min.css' ); ?>">

<!-- Stylesheets: -->
<link rel="stylesheet" href="<?php assets_path( 'css/public/style.css?v=' . v_combine() ); ?>">
<link rel="stylesheet" href="<?php assets_path( 'css/public/color_' . html_escape( db_config( 'site_color' ) ) . '.css?v=' . v_combine() ); ?>">
  
</head>

<body>

<!-- Navbar: -->
<nav class="navbar navbar-expand-lg navbar-light navbar-z brand-logo shadow fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo base_url(); ?>">
      <?php if ( ! empty( db_config( 'site_logo' ) ) ) { ?>
        <img class="logo" src="<?php echo general_uploads( html_escape( db_config( 'site_logo' ) ) ); ?>" alt="<?php echo html_escape( db_config( 'site_name' ) ); ?>">
      <?php } else { ?>
        <h3 class="p-0 mb-0"><?php echo html_escape( db_config( 'site_name' ) ); ?></h3>
      <?php } ?>
    </a>
    
    <?php if ( $this->zuser->is_logged_in ) { ?>
      <div class="ms-auto">
        <a class="btn btn-z btn-wide" href="<?php echo env_url( 'logout' ); ?>"><?php echo lang( 'logout' ); ?></a>
      </div>
    <?php } ?>
    
  </div>
  <!-- /.container-fluid -->
</nav>

<div class="z-align-middle">
  <div class="card z-card-mini-box text-center">
    <img class="mb-4" src="<?php illustration_by_color( 'maintenance' ); ?>" alt="">
    <h4 class="fw-bold text-sub"><?php echo lang( 'under_maintenance' ); ?></h4>
    <p class="mb-0"><?php echo html_escape( db_config( 'mm_message' ) ); ?></p>
  </div>
  <!-- /.card -->
</div>
<!-- /.z-align-middle -->

<!-- Pace: -->
<script src="<?php assets_path( 'vendor/pace/pace.js' ); ?>"></script>

<!-- jQuery Cookie: -->
<script src="<?php assets_path( 'vendor/jquery-cookie/jquery.cookie.js' ); ?>"></script>

<!-- Bootstrap JS: -->
<script src="<?php assets_path( 'vendor/bootstrap/js/bootstrap.bundle.min.js' ); ?>"></script>

<!-- Custom Scripts: -->
<script src="<?php assets_path( 'js/functions.js?v=' . v_combine() ); ?>"></script>
<script src="<?php assets_path( 'js/script.js?v=' . v_combine() ); ?>"></script>

</body>

</html>