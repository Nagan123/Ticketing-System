<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<?php if ( ! is_public_page() ) { ?>
  <footer class="footer-z bg-white pb-3 pb-md-0 shadow">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="border-only-sm-bottom">
            <p class="py-3 mb-0">
              <?php printf( lang( 'copyright_main' ), date( 'Y' ) ); ?>
              <?php echo lang( 'rights_reserved' ); ?>
            </p>
          </div>
          <!-- /.border-only-sm-bottom -->
        </div>
        <!-- /col -->
        <div class="col-md-6">
          <div class="pt-3 menu float-md-end">
            <a href="<?php echo env_url( 'privacy-policy' ); ?>"><?php echo get_page_name( 2 ); ?></a>
            <a href="<?php echo env_url( 'terms' ); ?>"><?php echo get_page_name( 1 ); ?></a>
            <div class="dropdown d-inline ms-3">
              <span id="language-switch" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo get_language_label( get_language() ); ?> <i class="fas fa-angle-down"></i>
              </span>
              <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="language-switch">
                <?php foreach ( AVAILABLE_LANGUAGES as $key => $value ) { ?>
                  <li>   
                    <?php if ( $key !== get_language() ) { ?>
                      <a href="<?php echo env_url(); ?>language/switch/<?php echo html_escape( $key ); ?>" class="dropdown-item small">
                        <?php echo html_escape( $value['display_label'] ); ?>
                      </a>
                    <?php } else { ?>
                      <span class="dropdown-item small">
                        <?php echo html_escape( $value['display_label'] ); ?>
                        
                        <span class="float-end text-sub">
                          <i class="fas fa-check-circle mt-1"></i>
                        </span>
                      </span>
                    <?php } ?>
                  </li> 
                <?php } ?>
              </ul>
            </div>
            <!-- /.dropdown -->
          </div>
          <!-- /.menu -->
        </div>
        <!-- /col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </footer>
  
  <?php load_view( 'common/public/chat_box' ); ?>
  
<?php } ?>

<?php if ( db_config( 'site_show_cookie_popup' ) ) { ?>
  <div class="cookie-popup card border-0 bg-sub shadow-lg">
    <div class="card-body">
      <p><?php echo lang( 'cookie_message' ); ?></p>
      <div class="d-grid">
        <button class="btn btn-light accept-btn text-uppercase accept-btn"><?php echo lang( 'got_it' ); ?></button>
      </div>
      <!-- /.d-grid -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.cookie-popup -->
<?php } ?>

<?php if ( ! empty( db_config( 'google_analytics_id' ) ) ) { ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo html_escape( db_config( 'google_analytics_id' ) ); ?>"></script>
<?php } ?>

<?php if ( is_gr_togo() && ! empty( $gr_field ) ) { ?>
  <!-- Google reCaptcha: -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php } ?>

<?php if ( ! empty( $scripts ) )
  load_scripts( $scripts );
?>

<!-- Pace JS: -->
<script src="<?php assets_path( 'vendor/pace/pace.js' ); ?>"></script>

<!-- jQuery Cookie: -->
<script src="<?php assets_path( 'vendor/jquery-cookie/jquery.cookie.js' ); ?>"></script>

<!-- Bootstrap JS: -->
<script src="<?php assets_path( 'vendor/bootstrap/js/bootstrap.bundle.min.js' ); ?>"></script>

<!-- Select 2: -->
<script src="<?php assets_path( 'vendor/select2/js/select2.full.min.js' ); ?>"></script>

<!-- Custom Scripts: -->
<script src="<?php assets_path( 'js/functions.js?v=' . v_combine() ); ?>"></script>
<script src="<?php assets_path( 'js/script.js?v=' . v_combine() ); ?>"></script>
<script src="<?php assets_path( 'js/script_public.js?v=' . v_combine() ); ?>"></script>

</body>

</html>