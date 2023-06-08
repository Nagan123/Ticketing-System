<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-align-middle">
  <div class="card z-card-mini-box form-based">
    <div class="card-body shadow-sm p-0">
      <div class="card-padding">
        <form class="z-form" action="<?php echo env_url( 'actions/account/register' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="row g-3 mb-3">
            <div class="col">
              <input type="text" class="form-control" name="first_name" placeholder="<?php echo lang( 'first_name' ); ?>" required>
            </div>
            <!-- /.col -->
            <div class="col">
              <input type="text" class="form-control" name="last_name" placeholder="<?php echo lang( 'last_name' ); ?>" required>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="mb-3">
            <?php if ( ! empty( $email_address ) ) { ?>
              <input type="email" class="form-control" name="email_address" placeholder="<?php echo lang( 'email_address' ); ?>" value="<?php echo html_escape( $email_address ); ?>" readonly>
            <?php } else { ?>
              <input type="email" class="form-control" name="email_address" placeholder="<?php echo lang( 'email_address' ); ?>" required>
            <?php } ?>
          </div>
          <!-- /.mb-3 -->
          <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="<?php echo lang( 'password' ); ?>" required>
          </div>
          <!-- /.mb-3 -->
          <div class="mb-3">
            <input type="password" class="form-control" name="retype_password" placeholder="<?php echo lang( 'retype_password' ); ?>" required>
          </div>
          <!-- /.mb-3 -->
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="agree" name="terms" required>
            <label class="form-check-label" for="agree"><?php printf( lang( 'agree_terms' ), env_url( 'terms' ) ); ?></label>
          </div>
          <!-- /.mb-3 -->
          <?php if ( is_gr_togo() ) { ?>
            <div class="mb-2 text-center">
              <div class="g-recaptcha d-inline-block" data-sitekey="<?php echo html_escape( db_config( 'gr_public_key' ) ); ?>"></div>
            </div>
            <!-- /.mb-2 -->
          <?php } ?>
          <div class="d-grid">
            <button class="btn btn-sub" type="submit"><?php echo lang( 'register' ); ?></button>
          </div>
          <!-- /.d-grid -->
          
          <?php load_view( 'user/account/social_auth_links' ); ?>
          
          <?php if ( ! empty( $code ) ) { ?>
            <input type="hidden" name="invitation_code" value="<?php echo html_escape( $code ); ?>">
          <?php } ?>
        </form>
      </div>
      <!-- /.card-padding -->
    </div>
    <!-- /.card-body -->
    <p class="mt-3 text-center"><?php printf( lang( 'already_have_account' ), env_url( 'login' ) ); ?></p>
  </div>
  <!-- /.card -->
</div>
<!-- /.z-align-middle -->