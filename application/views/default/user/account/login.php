<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-align-middle">
  <div class="card z-card-mini-box form-based">
    <div class="card-body shadow-sm p-0">
      <div class="card-padding">
        <form class="z-form" action="<?php echo env_url( 'actions/account/login' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="mb-3">
            <input type="text" class="form-control" name="username" placeholder="<?php echo lang( 'username_email_address' ); ?>" required>
          </div>
          <!-- /.mb-3 -->
          <div class="mb-2">
            <input type="password" class="form-control" name="password" placeholder="<?php echo lang( 'password' ); ?>" required>
          </div>
          <!-- /.mb-2 -->
          <div class="mb-3 form-check">
            <div class="float-sm-start">
              <input type="checkbox" class="form-check-input" id="remember-me" name="remember_me">
              <label class="form-check-label small" for="remember-me"><?php echo lang( 'remember_me' ); ?></label>
            </div>
            <div class="float-sm-end">
              <a class="small" href="<?php echo env_url( 'forgot_password' ); ?>"><?php echo lang( 'forgot_password_ques' ); ?></a>
            </div>
          </div>
          <!-- /.mb-3 -->
          <?php if ( is_gr_togo() ) { ?>
            <div class="mb-2 text-center">
              <div class="g-recaptcha d-inline-block" data-sitekey="<?php echo html_escape( db_config( 'gr_public_key' ) ); ?>"></div>
            </div>
            <!-- /.mb-2 -->
          <?php } ?>
          <div class="d-grid">
            <button class="btn btn-sub" type="submit"><?php echo lang( 'login' ); ?></button>
          </div>
          <!-- /.d-grid -->
          
          <?php load_view( 'user/account/social_auth_links' ); ?>
          
        </form>
      </div>
      <!-- /.card-padding -->
    </div>
    <!-- /.card-body -->
    
    <?php if ( db_config( 'u_enable_registration' ) ) { ?>
      <p class="mt-3 text-center"><?php printf( lang( 'dont_have_account' ), env_url( 'register' ) ); ?></p>
    <?php } ?>
    
  </div>
  <!-- /.card -->
</div>
<!-- /.z-align-middle -->