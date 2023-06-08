<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="z-form" action="<?php admin_action( 'settings/apis' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" role="tablist">
                <li class="pt-2 px-3"><?php echo lang( 'apis_settings' ); ?></li>
                <li class="nav-item">
                  <a class="nav-link active" id="facebook-tab" data-toggle="pill" href="#facebook" role="tab" aria-controls="facebook" aria-selected="true">
                    <?php echo lang( 'facebook' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="google-login-tab" data-toggle="pill" href="#google-login" role="tab" aria-controls="google-login" aria-selected="false">
                    <?php echo lang( 'google_login' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="google-recaptcha-tab" data-toggle="pill" href="#google-recaptcha" role="tab" aria-controls="google-recaptcha" aria-selected="false">
                    <?php echo lang( 'google_recaptcha' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="google-analytics-tab" data-toggle="pill" href="#google-analytics" role="tab" aria-controls="google-analytics" aria-selected="false">
                    <?php echo lang( 'google_analytics' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="twitter-tab" data-toggle="pill" href="#twitter" role="tab" aria-controls="twitter" aria-selected="false">
                    <?php echo lang( 'twitter' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="ipinfo-tab" data-toggle="pill" href="#ipinfo" role="tab" aria-controls="ipinfo" aria-selected="false">
                    <?php echo lang( 'ipinfo' ); ?>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <!-- Facebook: -->
                <div class="tab-pane show active" id="facebook" role="tabpanel" aria-labelledby="facebook-tab">
                  <div class="alert alert-info"><p><?php printf( lang( 'callback_url' ), env_url( 'login/facebook' ) ) ; ?></p></div><!-- /.alert -->
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="fb-app-id"><?php echo lang( 'facebook_app_id' ); ?></label>
                      <input type="text" id="fb-app-id" class="form-control" name="fb_app_id" value="<?php echo html_escape( db_config( 'fb_app_id' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group col-md-6">
                      <label for="fb-app-secret"><?php echo lang( 'facebook_app_secret' ); ?></label>
                      <input type="password" id="fb-app-secret" class="form-control" name="fb_app_secret" value="<?php echo html_escape( db_config( 'fb_app_secret' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.form-row -->
                  <label class="d-block"><?php echo lang( 'enable_facebook_login' ); ?></label>
                  <div class="icheck icheck-primary d-inline-block mr-2">
                    <input type="radio" name="fb_enable_login" id="fb-enable-login-1" value="1" <?php echo check_single( 1, db_config( 'fb_enable_login' ) ); ?>>
                    <label for="fb-enable-login-1"><?php echo lang( 'yes' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                  <div class="icheck icheck-primary d-inline-block">
                    <input type="radio" name="fb_enable_login" id="fb-enable-login-0" value="0" <?php echo check_single( 0, db_config( 'fb_enable_login' ) ); ?>>
                    <label for="fb-enable-login-0"><?php echo lang( 'no' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                </div>
                <!-- /.tab-pane -->
                
                <!-- Google Login: -->
                <div class="tab-pane" id="google-login" role="tabpanel" aria-labelledby="google-login-tab">
                  <div class="alert alert-info"><p><?php printf( lang( 'callback_url' ), env_url( 'login/google' ) ) ; ?></p></div><!-- /.alert -->
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="gl-client-key"><?php echo lang( 'google_app_client_key' ); ?></label>
                      <input type="text" id="gl-client-key" class="form-control" name="gl_client_key" value="<?php echo html_escape( db_config( 'gl_client_key' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group col-md-6">
                      <label for="gl-secret-key"><?php echo lang( 'google_app_secret_key' ); ?></label>
                      <input type="password" id="gl-secret-key" class="form-control" name="gl_secret_key" value="<?php echo html_escape( db_config( 'gl_secret_key' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.form-row -->
                  <label class="d-block"><?php echo lang( 'enable_google_login' ); ?></label>
                  <div class="icheck icheck-primary d-inline-block mr-2">
                    <input type="radio" name="gl_enable" id="gl-enable-1" value="1" <?php echo check_single( 1, db_config( 'gl_enable' ) ); ?>>
                    <label for="gl-enable-1"><?php echo lang( 'yes' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                  <div class="icheck icheck-primary d-inline-block">
                    <input type="radio" name="gl_enable" id="gl-enable-0" value="0" <?php echo check_single( 0, db_config( 'gl_enable' ) ); ?>>
                    <label for="gl-enable-0"><?php echo lang( 'no' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                </div>
                <!-- /.tab-pane -->
                
                <!-- Google reCaptcha: -->
                <div class="tab-pane" id="google-recaptcha" role="tabpanel" aria-labelledby="google-recaptcha-tab">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="gr-public-key"><?php echo lang( 'gr_public_key' ); ?></label>
                      <input type="text" id="gr-public-key" class="form-control" name="gr_public_key" value="<?php echo html_escape( db_config( 'gr_public_key' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group col-md-6">
                      <label for="gr-secret-key"><?php echo lang( 'gr_secret_key' ); ?></label>
                      <input type="password" id="gr-secret-key" class="form-control" name="gr_secret_key" value="<?php echo html_escape( db_config( 'gr_secret_key' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.form-row -->
                  <label class="d-block"><?php echo lang( 'enable_google_recaptcha' ); ?></label>
                  <div class="icheck icheck-primary d-inline-block mr-2">
                    <input type="radio" name="gr_enable" id="gr-enable-1" value="1" <?php echo check_single( 1, db_config( 'gr_enable' ) ); ?>>
                    <label for="gr-enable-1"><?php echo lang( 'yes' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                  <div class="icheck icheck-primary d-inline-block">
                    <input type="radio" name="gr_enable" id="gr-enable-0" value="0" <?php echo check_single( 0, db_config( 'gr_enable' ) ); ?>>
                    <label for="gr-enable-0"><?php echo lang( 'no' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                </div>
                <!-- /.tab-pane -->
                
                <!-- Google Analytics: -->
                <div class="tab-pane" id="google-analytics" role="tabpanel" aria-labelledby="google-analytics-tab">
                  <label for="google-analytics-id"><?php echo lang( 'google_analytics_id' ); ?></label>
                  <input type="text" id="google-analytics-id" class="form-control" name="google_analytics_id" value="<?php echo html_escape( db_config( 'google_analytics_id' ) ); ?>">
                </div>
                <!-- /.tab-pane -->
                
                <!-- Twitter: -->
                <div class="tab-pane" id="twitter" role="tabpanel" aria-labelledby="twitter-tab">
                  <div class="alert alert-info"><p><?php printf( lang( 'callback_url' ), env_url( 'login/twitter' ) ) ; ?></p></div><!-- /.alert -->
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="tw-consumer-key"><?php echo lang( 'tw_consumer_key' ); ?></label>
                      <input type="text" id="tw-consumer-key" class="form-control" name="tw_consumer_key" value="<?php echo html_escape( db_config( 'tw_consumer_key' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group col-md-6">
                      <label for="tw-consumer-secret"><?php echo lang( 'tw_consumer_secret' ); ?></label>
                      <input type="password" id="tw-consumer-secret" class="form-control" name="tw_consumer_secret" value="<?php echo html_escape( db_config( 'tw_consumer_secret' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.form-row -->
                  <label class="d-block"><?php echo lang( 'enable_twitter_login' ); ?></label>
                  <div class="icheck icheck-primary d-inline-block mr-2">
                    <input type="radio" name="tw_enable_login" id="tw-enable-login-1" value="1" <?php echo check_single( 1, db_config( 'tw_enable_login' ) ); ?>>
                    <label for="tw-enable-login-1"><?php echo lang( 'yes' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                  <div class="icheck icheck-primary d-inline-block">
                    <input type="radio" name="tw_enable_login" id="tw-enable-login-0" value="0" <?php echo check_single( 0, db_config( 'tw_enable_login' ) ); ?>>
                    <label for="tw-enable-login-0"><?php echo lang( 'no' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                </div>
                <!-- /.tab-pane -->
                
                <!-- IPinfo: -->
                <div class="tab-pane" id="ipinfo" role="tabpanel" aria-labelledby="ipinfo-tab">
                  <label for="ipinfo-token"><?php echo lang( 'ipinfo_api_token' ); ?></label>
                  <input type="password" id="ipinfo-token" class="form-control" name="ipinfo_token" value="<?php echo html_escape( db_config( 'ipinfo_token' ) ); ?>">
                </div>
                <!-- /.tab-pane -->
                
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right text-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'update' ); ?>
              </button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->