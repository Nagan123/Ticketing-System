<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong><?php printf( lang( 'copyright_main' ), date( 'Y' ) ); ?></strong>
    <?php echo lang( 'rights_reserved' ); ?>
    <div class="float-right d-none d-sm-inline-block">
      <?php printf( lang( 'site_version' ), Z_DESK_VERSION ); ?>
    </div>
  </footer>
</div>
<!-- /.wrapper -->

<?php if ( ! empty( db_config( 'google_analytics_id' ) ) ) { ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo html_escape( db_config( 'google_analytics_id' ) ); ?>"></script>
<?php } ?>

<?php if ( is_gr_togo() && ! empty( $gr_field ) ) { ?>
  <!-- Google recaptcha: -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php } ?>

<!-- Pace: -->
<script src="<?php assets_path( 'vendor/pace/pace.js' ); ?>"></script>

<!-- Overlay Scrollbars: -->
<script src="<?php admin_lte_asset( 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ); ?>"></script>

<!-- jQuery Upload Preview: -->
<script src="<?php assets_path( 'panel/vendor/jquery_upload_preview/js/jquery.uploadPreview.min.js' ); ?>"></script>

<!-- jQuery Cookie: -->
<script src="<?php assets_path( 'vendor/jquery-cookie/jquery.cookie.js' ); ?>"></script>

<!-- Bootstrap 4: -->
<script src="<?php admin_lte_asset( 'plugins/bootstrap/js/bootstrap.bundle.min.js' ); ?>"></script>

<!-- Select 2: -->
<script src="<?php admin_lte_asset( 'plugins/select2/js/select2.full.min.js' ); ?>"></script>

<!-- Summernote: -->
<script src="<?php admin_lte_asset( 'plugins/summernote/summernote-bs4.min.js' ); ?>"></script>

<!-- AdminLTE App: -->
<script src="<?php admin_lte_asset( 'js/adminlte.min.js' ); ?>"></script>

<?php if ( ! empty( $scripts ) )
  load_scripts( $scripts );
?>

<!-- Custom Scripts: -->
<script src="<?php assets_path( 'js/functions.js?v=' . v_combine() ); ?>"></script>
<script src="<?php assets_path( 'panel/js/script.js?v=' . v_combine() ); ?>"></script>
<script src="<?php assets_path( 'js/script.js?v=' . v_combine() ); ?>"></script>

</body>

</html>