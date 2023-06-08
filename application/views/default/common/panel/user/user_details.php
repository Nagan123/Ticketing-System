<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title"><?php echo lang( 'user_details' ); ?></h3>
    
    <?php if ( $this->uri->segment( 1 ) === 'admin' && $this->uri->segment( 3 ) === 'edit_user' ) { ?>
      <div class="card-tools text-sm ml-auto">
        <button class="btn btn-sm btn-primary" data-toggle="dropdown">
          <span class="fas fa-ellipsis-v"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <?php if ( $this->zuser->has_permission( 'all_tickets' ) ) { ?>
            <a class="dropdown-item" href="<?php echo env_url( 'admin/users/tickets/' . html_escape( $user->username ) ); ?>">
              <i class="fas fa-headset dropdown-menu-icon"></i> <?php echo lang( 'tickets' ); ?>
            </a>
          <?php } ?>
          
          <?php if ( $this->zuser->has_permission( 'all_chats' ) ) { ?>
            <a class="dropdown-item" href="<?php echo env_url( 'admin/users/chats/' . html_escape( $user->username ) ); ?>">
              <i class="fas fa-comments dropdown-menu-icon"></i> <?php echo lang( 'chats' ); ?>
            </a>
          <?php } ?>
          
          <a class="dropdown-item" href="<?php echo env_url( 'admin/users/sent_emails/' . html_escape( $user->username ) ); ?>">
            <i class="fas fa-share dropdown-menu-icon"></i> <?php echo lang( 'sent_emails' ); ?>
          </a>
          <a class="dropdown-item" href="<?php echo env_url( 'admin/users/sessions/' . html_escape( $user->username ) ); ?>">
            <i class="fab fa-firefox-browser dropdown-menu-icon"></i> <?php echo lang( 'sessions' ); ?>
          </a>
        </div>
        <!-- /.dropdown-menu -->
      </div>
      <!-- /.card-tools -->
    <?php } ?>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="first-name"><?php echo lang( 'first_name' ); ?> <span class="required">*</span></label>
        <input type="text" id="first-name" class="form-control" name="first_name" value="<?php echo html_escape( $user->first_name ); ?>" required>
      </div>
      <!-- /.form-group -->
      <div class="form-group col-md-6">
        <label for="last-name"><?php echo lang( 'last_name' ); ?> <span class="required">*</span></label>
        <input type="text" id="last-name" class="form-control" name="last_name" value="<?php echo html_escape( $user->last_name ); ?>" required>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.form-row -->
    <div class="form-row">
      <div class="form-group col-xl-6">
        <label for="email-address">
          <?php echo lang( 'email_address' ); ?> <span class="required">*</span>
        </label>
        <input type="text" id="email-address" class="form-control" name="email_address" value="<?php echo html_escape( $user->email_address ); ?>" required>
      </div>
      <!-- /.form-group -->
      <div class="form-group col-xl-6">
        <label for="username"><?php echo lang( 'username' ); ?> <span class="required">*</span></label>
        <input type="text" id="username" class="form-control" name="username" value="<?php echo html_escape( $user->username ); ?>" required <?php echo ( db_config( 'u_allow_username_change' ) == 0 ) ? 'readonly' : ''; ?>>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.form-row -->
    <div class="form-group">
      <label for="language"><?php echo lang( 'language' ); ?></label>
      <select class="form-control select2 search-disabled" id="language" name="language" data-placeholder="<?php echo lang( 'select_language' ); ?>">
        <option></option>
        <?php foreach ( AVAILABLE_LANGUAGES as $key => $value ) { ?>
          <option value="<?php echo html_escape( $key ); ?>" <?php echo select_single( $key, $user->language ); ?>><?php echo html_escape( $value['display_label'] ); ?></option>
        <?php } ?>
      </select>
    </div>
    <!-- /.form-group -->
    <div class="form-group">
      <label for="time-format"><?php echo lang( 'time_format' ); ?></label>
      <select id="time-format" class="form-control select2 search-disabled" name="time_format">
        <option value="H:i:s" <?php echo select_single( 'H:i:s', $user->time_format ); ?>><?php echo lang( 'hours_24' ); ?></option>
        <option value="h:i:s A" <?php echo select_single( 'h:i:s A', $user->time_format ); ?>><?php echo lang( 'hours_12' ); ?></option>
      </select>
    </div>
    <!-- /.form-group -->
    <div class="form-group">
      <label for="date_format"><?php echo lang( 'date_format' ); ?></label>
      <select id="date_format" class="form-control select2 search-disabled" name="date_format">
        <option value="Y-m-d" <?php echo select_single( 'Y-m-d', $user->date_format ); ?>><?php echo lang( 'date_format_1' ); ?></option>
        <option value="Y/m/d" <?php echo select_single( 'Y/m/d', $user->date_format ); ?>><?php echo lang( 'date_format_2' ); ?></option>
        <option value="m-d-Y" <?php echo select_single( 'm-d-Y', $user->date_format ); ?>><?php echo lang( 'date_format_3' ); ?></option>
        <option value="m/d/Y" <?php echo select_single( 'm/d/Y', $user->date_format ); ?>><?php echo lang( 'date_format_4' ); ?></option>
        <option value="d-m-Y" <?php echo select_single( 'd-m-Y', $user->date_format ); ?>><?php echo lang( 'date_format_5' ); ?></option>
        <option value="d/m/Y" <?php echo select_single( 'd/m/Y', $user->date_format ); ?>><?php echo lang( 'date_format_6' ); ?></option>
      </select>
    </div>
    <!-- /.form-group -->
    <label for="timezone"><?php echo lang( 'timezone' ); ?></label>
    <select id="timezone" class="form-control select2" data-placeholder="<?php echo lang( 'select_timezone' ); ?>" name="timezone">
      <option></option>
      
      <?php foreach ( DateTimeZone::listIdentifiers( DateTimeZone::ALL ) as $timezone ) { ?>
        <option value="<?php echo html_escape( $timezone ); ?>" <?php echo select_single( $timezone, $user->timezone ); ?>><?php echo html_escape( $timezone ); ?></option>
      <?php } ?>
    </select>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

<?php if ( $this->uri->segment( 1 ) === 'admin' && $this->uri->segment( 3 ) === 'edit_user' ) { ?>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?php echo lang( 'role' ); ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <select class="form-control select2 search-disabled" name="role">
        <?php if ( ! empty( $roles ) ) {
          foreach ( $roles as $role ) {
            $id = $role->id; ?>
          <option value="<?php echo html_escape( $id ); ?>" <?php echo select_single( $id, $user->role ); ?>><?php echo html_escape( $role->name ); ?></option>
        <?php }
        } ?>
      </select>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?php echo lang( 'password' ); ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="<?php echo lang( 'password' ); ?>">
      </div>
      <!-- /.form-group -->
      <input type="password" class="form-control" name="retype_password" placeholder="<?php echo lang( 'retype_password' ); ?>">
      <small class="form-text text-muted mt-1"><?php echo lang( 'leave_password_msg' ); ?></small>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
<?php } ?>

<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title"><?php echo lang( 'email_notifications' ); ?></h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="icheck icheck-primary d-inline-block mr-2">
      <input type="radio" name="email_notifications" id="email-notifications-1" value="1" <?php echo check_single( 1, $user->send_email_notifications ); ?>>
      <label for="email-notifications-1"><?php echo lang( 'enable' ); ?></label>
    </div>
    <!-- /.icheck -->
    <div class="icheck icheck-primary d-inline-block">
      <input type="radio" name="email_notifications" id="email-notifications-0" value="0" <?php echo check_single( 0, $user->send_email_notifications ); ?>>
      <label for="email-notifications-0"><?php echo lang( 'disable' ); ?></label>
    </div>
    <!-- /.icheck -->
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->