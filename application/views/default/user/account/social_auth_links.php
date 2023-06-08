<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<?php if ( is_fb_togo() || is_tw_togo() || is_gl_togo() ) { ?>
  <div class="row align-items-center mt-4 mb-4">
    <div class="col pe-0"><hr></div>
    <div class="col-auto">
      <p class="mb-0"><strong><?php echo lang( 'OR' ); ?></strong></p> 
    </div>
    <!-- /.col-auto -->
    <div class="col ps-0"><hr></div>
  </div>
  <!-- /.row -->
  <div class="d-grid gap-2">
  
    <?php if ( is_fb_togo() ) { ?>
      <a href="<?php echo env_url( 'login/facebook' ); ?>" class="btn btn-social btn-facebook">
        <i class="fab fa-facebook"></i> <?php echo lang( 'continue_with_fb' ); ?>
      </a>
    <?php } ?>
    
    <?php if ( is_gl_togo() ) { ?>
      <a href="<?php echo env_url( 'login/google' ); ?>" class="btn btn-social btn-google">
        <i class="fab fa-google-plus"></i> <?php echo lang( 'continue_with_google' ); ?>
      </a>
    <?php } ?>
    
    <?php if ( is_tw_togo() ) { ?>
      <a href="<?php echo env_url( 'login/twitter' ); ?>" class="btn btn-social btn-twitter">
        <i class="fab fa-twitter"></i> <?php echo lang( 'continue_with_twitter' ); ?>
      </a>
    <?php } ?>
  </div>
  <!-- /.d-grid -->
<?php } ?>