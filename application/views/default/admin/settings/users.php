<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="z-form" action="<?php admin_action( 'settings/users' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" role="tablist">
                <li class="pt-2 px-3"><?php echo lang( 'users_settings' ); ?></li>
                <li class="nav-item">
                  <a class="nav-link active" id="login-tab" data-toggle="pill" href="#login" role="tab" aria-controls="login" aria-selected="true">
                    <?php echo lang( 'login' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="register-tab" data-toggle="pill" href="#register" role="tab" aria-controls="register" aria-selected="false">
                    <?php echo lang( 'register' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="throttling-tab" data-toggle="pill" href="#throttling" role="tab" aria-controls="throttling" aria-selected="false">
                    <?php echo lang( 'throttling' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="miscellaneous-tab" data-toggle="pill" href="#miscellaneous" role="tab" aria-controls="miscellaneous" aria-selected="false">
                    <?php echo lang( 'miscellaneous' ); ?>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                
                <!-- Login: -->
                <div class="tab-pane show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                  <label for="users-can-reset-password"><?php echo lang( 'users_can_rp' ); ?></label>
                  <select id="users-can-reset-password" class="form-control select2 search-disabled" name="u_reset_password">
                    <option value="1" <?php echo select_single( 1, db_config( 'u_reset_password' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                    <option value="0" <?php echo select_single( 0, db_config( 'u_reset_password' ) ); ?>><?php echo lang( 'no' ); ?></option>
                  </select>
                </div>
                <!-- /.tab-pane -->
                
                <!-- Register: -->
                <div class="tab-pane" id="register" role="tabpanel" aria-labelledby="register-tab">
                  <label for="enable-registration"><?php echo lang( 'enable_registeration' ); ?></label>
                  <select id="enable-registration" class="form-control select2 search-disabled" name="u_enable_registration">
                    <option value="1" <?php echo select_single( 1, db_config( 'u_enable_registration' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                    <option value="0" <?php echo select_single( 0, db_config( 'u_enable_registration' ) ); ?>><?php echo lang( 'no' ); ?></option>
                  </select>
                </div>
                <!-- /.tab-pane -->
                
                <!-- Throttling: -->
                <div class="tab-pane" id="throttling" role="tabpanel" aria-labelledby="throttling-tab">
                  <div class="form-group">
                    <label for="temp-lockout"><?php echo lang( 'temp_lockout' ); ?></label>
                    <select id="temp-lockout" class="form-control select2 search-disabled" name="u_temporary_lockout">
                      <option value="strict" <?php echo select_single( 'strict', db_config( 'u_temporary_lockout' ) ); ?>><?php echo lang( 'strict_lock' ); ?></option>
                      <option value="medium" <?php echo select_single( 'medium', db_config( 'u_temporary_lockout' ) ); ?>><?php echo lang( 'medium_lock' ); ?></option>
                      <option value="normal" <?php echo select_single( 'normal', db_config( 'u_temporary_lockout' ) ); ?>><?php echo lang( 'normal_lock' ); ?></option>
                      <option value="off" <?php echo select_single( 'off', db_config( 'u_temporary_lockout' ) ); ?>><?php echo lang( 'off' ); ?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <label for="lockout-unlock-time"><?php echo lang( 'lockout_unlock_time' ); ?></label>
                  <select id="lockout-unlock-time" class="form-control select2 search-disabled" name="u_lockout_unlock_time">
                    <option value="1" <?php echo select_single( 1, db_config( 'u_lockout_unlock_time' ) ); ?>><?php echo lang( 'after_15_minutes' ); ?></option>
                    <option value="2" <?php echo select_single( 2, db_config( 'u_lockout_unlock_time' ) ); ?>><?php echo lang( 'after_30_minutes' ); ?></option>
                    <option value="3" <?php echo select_single( 3, db_config( 'u_lockout_unlock_time' ) ); ?>><?php echo lang( 'after_60_minutes' ); ?></option>
                    <option value="4" <?php echo select_single( 4, db_config( 'u_lockout_unlock_time' ) ); ?>><?php echo lang( 'after_24_hours' ); ?></option>
                  </select>
                </div>
                <!-- /.tab-pane -->
                
                <!-- Miscellaneous: -->
                <div class="tab-pane" id="miscellaneous" role="tabpanel" aria-labelledby="miscellaneous-tab">
                  <div class="form-group">
                    <label for="password-requirement"><?php echo lang( 'password_requirement' ); ?></label>
                    <select id="password-requirement" class="form-control select2 search-disabled" name="u_password_requirement">
                      <option value="strong" <?php echo select_single( 'strong', db_config( 'u_password_requirement' ) ); ?>><?php echo lang( 'strong_password' ); ?></option>
                      <option value="medium" <?php echo select_single( 'medium', db_config( 'u_password_requirement' ) ); ?>><?php echo lang( 'medium_password' ); ?></option>
                      <option value="normal" <?php echo select_single( 'normal', db_config( 'u_password_requirement' ) ); ?>><?php echo lang( 'normal_password' ); ?></option>
                      <option value="low" <?php echo select_single( 'low', db_config( 'u_password_requirement' ) ); ?>><?php echo lang( 'low_password' ); ?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="notify-pass-changed"><?php echo lang( 'notify_pass_changed' ); ?></label>
                    <select id="notify-pass-changed" class="form-control select2 search-disabled" name="u_notify_pass_changed">
                      <option value="1" <?php echo select_single( 1, db_config( 'u_notify_pass_changed' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                      <option value="0" <?php echo select_single( 0, db_config( 'u_notify_pass_changed' ) ); ?>><?php echo lang( 'no' ); ?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="max-avator-size"><?php echo lang( 'max_avatar_size' ); ?></label>
                    <input type="text" id="max-avator-size" class="form-control" name="u_max_avator_size" value="<?php echo html_escape( db_config( 'u_max_avator_size' ) ); ?>">
                    <small class="form-text text-muted"><?php echo lang( 'avatar_dim_tip' ); ?></small>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="req-e-changed-ver"><?php echo lang( 'req_e_changed_ver' ); ?></label>
                    <select id="req-e-changed-ver" class="form-control select2 search-disabled" name="u_req_ev_onchange">
                      <option value="1" <?php echo select_single( 1, db_config( 'u_req_ev_onchange' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                      <option value="0" <?php echo select_single( 0, db_config( 'u_req_ev_onchange' ) ); ?>><?php echo lang( 'no' ); ?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="users-can-remove-them"><?php echo lang( 'users_can_remove_them' ); ?></label>
                    <select id="users-can-remove-them" class="form-control select2 search-disabled" name="u_can_remove_them">
                      <option value="1" <?php echo select_single( 1, db_config( 'u_can_remove_them' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                      <option value="0" <?php echo select_single( 0, db_config( 'u_can_remove_them' ) ); ?>><?php echo lang( 'no' ); ?></option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <label for="allow-username-change"><?php echo lang( 'allow_uname_change' ); ?></label>
                  <select id="allow-username-change" class="form-control select2 search-disabled" name="u_allow_username_change">
                    <option value="1" <?php echo select_single( 1, db_config( 'u_allow_username_change' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                    <option value="0" <?php echo select_single( 0, db_config( 'u_allow_username_change' ) ); ?>><?php echo lang( 'no' ); ?></option>
                  </select>
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