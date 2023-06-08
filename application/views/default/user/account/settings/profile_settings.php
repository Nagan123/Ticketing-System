<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="response-message no-radius"><?php echo alert_message(); ?></div>

<div class="z-settings z-page-form my-5 extra-height-1"> 
  <div class="container">
    <div class="row">
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="shadow-sm wrapper user-view text-center">
          <div class="position-relative d-inline-block">
            <img src="<?php echo user_picture( html_esc_url( $user->picture ) ); ?>" alt="User Image">
            
            <?php if ( $user->picture !== DEFAULT_USER_IMG ) { ?>
              <div class="text-center">
                <button type="button" class="btn btn-danger delete-picture" data-bs-toggle="modal" data-bs-target="#delete-pp"><i class="fas fa-trash"></i></button>
              </div>
            <?php } ?>
            
          </div>
          <!-- /.position-relative -->
          <p class="mt-1 mb-0 fw-bold text-center"><?php echo html_escape( $user->first_name . ' ' . $user->last_name ); ?></p>
          <p class="text-muted text-center small mb-0"><?php printf( lang( 'joined' ), get_date_time_by_timezone( html_escape( $this->zuser->get( 'registered_at' ) ) ) ); ?></p>
          
          <?php if ( db_config( 'u_can_remove_them' ) == 1 && $this->zuser->get( 'id' ) != 1 ) { ?>
            <div class="d-grid">
              <button type="button" class="btn btn-outline-danger mt-3" data-bs-toggle="modal" data-bs-target="#delete-account"><?php echo lang( 'delete_account' ); ?></button>
            </div>
          <?php } ?>
        </div>
        <!-- /.user-view -->
      </div>
      <div class="col-lg-9">
      
        <?php if ( ! empty( $this->zuser->get( 'pending_email_address' ) ) ) { ?>
          <div class="no-radius">
            <div class="alert alert-info">
              <p><?php printf( lang( 'pending_email_msg' ), html_escape( $this->zuser->get( 'pending_email_address' ) ) ); ?></p>
            </div>
            <!-- /.alert -->
          </div>
          <!-- /.no-radius -->
        <?php } ?>
        
        <div class="shadow-sm wrapper">
          <form class="z-form" action="<?php user_action( 'account/update_profile_settings' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="area" value="user">
            <h3 class="h4 mb-4 fw-bold border-bottom pb-2"><?php echo lang( 'general_settings' ); ?></h3>
            <div class="row g-3 mb-3">
              <div class="col">
                <label for="first-name" class="form-label"><?php echo lang( 'first_name' ); ?> <span class="text-danger">*</span></label>
                <input type="text" id="first-name" class="form-control" name="first_name" value="<?php echo html_escape( $user->first_name ); ?>" required>
              </div>
              <!-- /.col -->
              <div class="col">
                <label for="last-name" class="form-label"><?php echo lang( 'last_name' ); ?> <span class="text-danger">*</span></label>
                <input type="text" id="last-name" class="form-control" name="last_name" value="<?php echo html_escape( $user->last_name ); ?>" required>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="email-address" class="form-label"><?php echo lang( 'email_address' ); ?> <span class="text-danger">*</span></label>
                <input type="email" id="email-address" class="form-control" name="email_address" value="<?php echo html_escape( $user->email_address ); ?>" required>
              </div>
              <!-- /col -->
              <div class="col-md-6">
                <label for="username" class="form-label"><?php echo lang( 'username' ); ?> <span class="text-danger">*</span></label>
                <input type="text" id="username" class="form-control" name="username" value="<?php echo html_escape( $user->username ); ?>" required <?php echo ( db_config( 'u_allow_username_change' ) == 0 ) ? 'readonly' : ''; ?>>
              </div>
              <!-- /col -->
            </div>
            <!-- /.row -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="email-notifications" class="form-label"><?php echo lang( 'email_notifications' ); ?></label>
                <select id="email-notifications" class="form-control select2 search-disabled" name="email_notifications">
                  <option value="1" <?php echo select_single( 1, $user->send_email_notifications ); ?>><?php echo lang( 'enable' ); ?></option>
                  <option value="0" <?php echo select_single( 0, $user->send_email_notifications ); ?>><?php echo lang( 'disable' ); ?></option>
                </select>
              </div>
              <!-- /col -->
              <div class="col-md-6">
                <label for="time-format" class="form-label"><?php echo lang( 'time_format' ); ?></label>
                <select id="time-format" class="form-control select2 search-disabled" name="time_format">
                  <option value="H:i:s" <?php echo select_single( 'H:i:s', $user->time_format ); ?>><?php echo lang( 'hours_24' ); ?></option>
                  <option value="h:i:s A" <?php echo select_single( 'h:i:s A', $user->time_format ); ?>><?php echo lang( 'hours_12' ); ?></option>
                </select>
              </div>
              <!-- /col -->
            </div>
            <!-- /.row -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="date-format" class="form-label"><?php echo lang( 'date_format' ); ?></label>
                <select id="date-format" class="form-control select2 search-disabled" name="date_format">
                  <option value="Y-m-d" <?php echo select_single( 'Y-m-d', $user->date_format ); ?>><?php echo lang( 'date_format_1' ); ?></option>
                  <option value="Y/m/d" <?php echo select_single( 'Y/m/d', $user->date_format ); ?>><?php echo lang( 'date_format_2' ); ?></option>
                  <option value="m-d-Y" <?php echo select_single( 'm-d-Y', $user->date_format ); ?>><?php echo lang( 'date_format_3' ); ?></option>
                  <option value="m/d/Y" <?php echo select_single( 'm/d/Y', $user->date_format ); ?>><?php echo lang( 'date_format_4' ); ?></option>
                  <option value="d-m-Y" <?php echo select_single( 'd-m-Y', $user->date_format ); ?>><?php echo lang( 'date_format_5' ); ?></option>
                  <option value="d/m/Y" <?php echo select_single( 'd/m/Y', $user->date_format ); ?>><?php echo lang( 'date_format_6' ); ?></option>
                </select>
              </div>
              <!-- /col -->
              <div class="col-md-6">
                <label for="timezone" class="form-label"><?php echo lang( 'timezone' ); ?></label>
                <select id="timezone" class="form-control select2" data-placeholder="<?php echo lang( 'select_timezone' ); ?>" name="timezone">
                  <option></option>
                  <?php foreach ( DateTimeZone::listIdentifiers( DateTimeZone::ALL ) as $timezone ) { ?>
                    <option value="<?php echo html_escape( $timezone ); ?>" <?php echo select_single( $timezone, $user->timezone ); ?>><?php echo html_escape( $timezone ); ?></option>
                  <?php } ?>
                </select>
              </div>
              <!-- /col -->
            </div>
            <!-- /.row -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="language" class="form-label"><?php echo lang( 'language' ); ?></label>
                <select class="form-control select2 search-disabled" id="language" name="language" data-placeholder="<?php echo lang( 'select_language' ); ?>">
                  <option></option>
                  <?php foreach ( AVAILABLE_LANGUAGES as $key => $value ) { ?>
                    <option value="<?php echo html_escape( $key ); ?>" <?php echo select_single( $key, $user->language ); ?>><?php echo html_escape( $value['display_label'] ); ?></option>
                  <?php } ?>
                </select>
              </div>
              <!-- /col -->
            </div>
            <!-- /.row -->
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <div>
                  <label for="picture" class="form-label"><?php echo lang( 'picture' ); ?></label>
                  <i class="fas fa-info-circle" data-bs-toggle="tooltip" title="<?php echo avator_tip(); ?>"></i>
                </div>
                <input type="file" id="picture" name="picture" accept="<?php echo ALLOWED_IMG_EXT_HTML; ?>">
              </div>
              <!-- /col -->
            </div>
            <!-- /.row -->
            <div class="response-message"></div>
            <div class="border-top pt-3 clearfix">
              <button class="btn btn-sub btn-wide float-end" type="submit"><?php echo lang( 'update' ); ?></button>
            </div>
          </form>
        </div>
        <!-- /.wrapper -->
        <div class="shadow-sm wrapper mt-4">
          <form class="z-form" action="<?php user_action( 'account/change_password' ); ?>" method="post" data-csrf="manual">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="area" value="user">
            <h3 class="h4 mb-4 fw-bold border-bottom pb-2"><?php echo lang( 'change_password' ); ?></h3>
            
            <?php if ( ! empty( $this->zuser->get( 'password' ) ) ) { ?>
              <div class="mb-3">
                <label for="current-password" class="form-label"><?php echo lang( 'current_password' ); ?> <span class="text-danger">*</span></label>
                <input type="password" id="current-password" class="form-control" name="current_password" required>
              </div>
            <?php } ?>
            
            <div class="mb-3">
              <label for="password" class="form-label"><?php echo lang( 'password' ); ?> <span class="text-danger">*</span></label>
              <input type="password" id="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
              <label for="retype-password" class="form-label"><?php echo lang( 'retype_password' ); ?> <span class="text-danger">*</span></label>
              <input type="password" id="retype-password" class="form-control" name="retype_password" required>
            </div>
            <div class="response-message"></div>
            <div class="border-top pt-3 clearfix">
              <button class="btn btn-sub btn-wide float-end" type="submit"><?php echo lang( 'update' ); ?></button>
            </div>
          </form>
        </div>
        <!-- /.wrapper -->
      </div>
      <!-- /col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</div>
<!-- /.z-settings -->

<?php load_modals( ['user/delete_profile_picture', 'user/delete_account'] ); ?>