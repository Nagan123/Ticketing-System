<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-align-middle">
  <div class="card z-card-mini-box form-based">
    <div class="card-body shadow-sm p-0">
      <div class="card-padding">
        <form class="z-form" action="<?php echo env_url( 'actions/account/change_password' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <p><?php echo lang( 'change_password_tagline' ); ?></p>
          <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="<?php echo lang( 'password' ); ?>" required>
          </div>
          <!-- /.mb-3 -->
          <div class="mb-3">
            <input type="password" class="form-control" name="retype_password" placeholder="<?php echo lang( 'retype_password' ); ?>" required>
          </div>
          <!-- /.mb-3 -->
          
          <?php if ( is_gr_togo() ) { ?>
            <div class="mb-2 text-center">
              <div class="g-recaptcha d-inline-block" data-sitekey="<?php echo html_escape( db_config( 'gr_public_key' ) ); ?>"></div>
            </div>
            <!-- /.mb-2 -->
          <?php } ?>
          
          <div class="d-grid">
            <button class="btn btn-sub" type="submit"><?php echo lang( 'change_password' ); ?></button>
          </div>
          <!-- /.d-grid -->
          <input type="hidden" name="token" value="<?php echo html_escape( $token ); ?>">
        </form>
      </div>
      <!-- /.card-padding -->
    </div>
    <!-- /.card-body -->
    <p class="mt-4 text-center"><?php printf( lang( 'got_your_password' ), env_url( 'login' ) ); ?></p>
  </div>
  <!-- /.card -->
</div>
<!-- /.z-align-middle -->