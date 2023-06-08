<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-align-middle">
  <div class="card z-card-mini-box form-based">
    <div class="card-body shadow-sm p-0">
      <div class="card-padding">
        <form class="z-form" action="<?php echo env_url( 'actions/account/request_password' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <p><?php echo lang( 'forgot_password_tagline' ); ?></p>
          <div class="mb-3">
            <input type="email" class="form-control" name="email_address" placeholder="<?php echo lang( 'email_address' ); ?>" required>
          </div>
          <!-- /.mb-3 -->
          
          <?php if ( is_gr_togo() ) { ?>
            <div class="mb-2 text-center">
              <div class="g-recaptcha d-inline-block" data-sitekey="<?php echo html_escape( db_config( 'gr_public_key' ) ); ?>"></div>
            </div>
            <!-- /.mb-2 -->
          <?php } ?>
          
          <div class="d-grid">
            <button class="btn btn-sub" type="submit"><?php echo lang( 'request_new_pass' ); ?></button>
          </div>
          <!-- /.d-grid -->
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