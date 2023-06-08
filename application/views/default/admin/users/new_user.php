<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <form class="z-form" action="<?php admin_action( 'users/new_user' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <div class="row">
        <div class="col">
          <div class="response-message"><?php echo alert_message(); ?></div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-9">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'general_info' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="first-name"><?php echo lang( 'first_name' ); ?> <span class="required">*</span></label>
                  <input type="text" id="first-name" class="form-control" name="first_name" required>
                </div>
                <!-- /.form-group -->
                <div class="form-group col-md-6">
                  <label for="last-name"><?php echo lang( 'last_name' ); ?> <span class="required">*</span></label>
                  <input type="text" id="last-name" class="form-control" name="last_name" required>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.form-row -->
              <div class="form-group">
                <label for="email-address"><?php echo lang( 'email_address' ); ?> <span class="required">*</span></label>
                <input type="email" id="email-address" class="form-control" name="email_address" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="send-password"><?php echo lang( 'send_password' ); ?></label>
                <select id="send-password" class="form-control select2 search-disabled" name="send_password">
                  <option value="0"><?php echo lang( 'no' ); ?></option>
                  <option value="1"><?php echo lang( 'yes' ); ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="password"><?php echo lang( 'password' ); ?> <span class="required">*</span></label>
                <input type="password" id="password" class="form-control" name="password" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="retype-password"><?php echo lang( 'retype_password' ); ?> <span class="required">*</span></label>
                <input type="password" id="retype-password" class="form-control" name="retype_password" required>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="role"><?php echo lang( 'role' ); ?> <span class="required">*</span></label>
                <select id="role" class="form-control select2 search-disabled" data-placeholder="<?php echo lang( 'choose_role' ); ?>" name="role" required>
                  <option></option>
                  <?php if ( ! empty( $roles ) ) {
                    foreach ( $roles as $role ) { ?>
                    <option value="<?php echo html_escape( $role->id ); ?>"><?php echo html_escape( $role->name ); ?></option>
                  <?php }
                  } ?>
                </select>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right text-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'submit' ); ?>
              </button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'profile_picture' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="image-preview">
                <label for="image-upload" id="image-label"><?php echo lang( 'choose_file' ); ?></label>
                <input type="file" name="picture" id="image-upload" accept="<?php echo ALLOWED_IMG_EXT_HTML; ?>">
              </div>
              <!-- /#image-preview -->
              <hr>
              <small class="form-text text-muted"><?php echo avator_tip(); ?></small>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </form>
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->