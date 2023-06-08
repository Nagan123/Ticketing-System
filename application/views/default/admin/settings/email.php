<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="z-form" action="<?php admin_action( 'settings/email' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'email_settings' ); ?></h3>
              
              <div class="card-tools ml-auto">
                <button type="button" class="btn btn-success text-sm" data-toggle="modal" data-target="#test-email-settings">
                  <i class="fas fa-cogs mr-2"></i> <?php echo lang( 'test_settings' ); ?>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="from-address"><?php echo lang( 'from_address' ); ?> <span class="required">*</span></label>
                  <input type="email" id="from-address" class="form-control" name="e_sender" value="<?php echo html_escape( db_config( 'e_sender' ) ); ?>">
                </div>
                <!-- /.form-group -->
                <div class="form-group col-md-6">
                  <label for="from-name"><?php echo lang( 'from_name' ); ?> <span class="required">*</span></label>
                  <input type="text" id="from-name" class="form-control" name="e_sender_name" value="<?php echo html_escape( db_config( 'e_sender_name' ) ); ?>">
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.form-row -->
              <div class="form-row">
                <div class="mb-3 mb-md-0 col-md-6">
                  <label for="protocol"><?php echo lang( 'protocol' ); ?></label>
                  <select id="protocol" class="form-control select2 search-disabled" name="e_protocol">
                    <option value="smtp" <?php echo select_single( 'smtp', db_config( 'e_protocol' ) ); ?>><?php echo lang( 'smtp' ); ?></option>
                    <option value="mail" <?php echo select_single( 'mail', db_config( 'e_protocol' ) ); ?>><?php echo lang( 'mail' ); ?></option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group col-md-6 smtp-field">
                  <label for="host"><?php echo lang( 'host' ); ?> <span class="required">*</span></label>
                  <input type="text" id="host" class="form-control" name="e_host" value="<?php echo html_escape( db_config( 'e_host' ) ); ?>">
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.form-row -->
              <div class="form-row">
                <div class="form-group col-md-6 smtp-field">
                  <label for="username"><?php echo lang( 'username' ); ?> <span class="required">*</span></label>
                  <input type="text" id="username" class="form-control" name="e_username" value="<?php echo html_escape( db_config( 'e_username' ) ); ?>">
                </div>
                <!-- /.form-group -->
                <div class="form-group col-md-6 smtp-field">
                  <label for="password"><?php echo lang( 'password' ); ?> <span class="required">*</span></label>
                  <input type="password" id="password" class="form-control" name="e_password" value="<?php echo html_escape( db_config( 'e_password' ) ); ?>">
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.form-row -->
              <div class="form-row">
                <div class="col-md-6 smtp-field mb-3 mb-md-0">
                  <label for="encryption"><?php echo lang( 'encryption' ); ?></label>
                  <select id="encryption" class="form-control select2 search-disabled" name="e_encryption">
                    <option value=""><?php echo lang( 'none' ); ?></option>
                    <option value="tls" <?php echo select_single( 'tls', db_config( 'e_encryption' ) ); ?>><?php echo lang( 'tls' ); ?></option>
                    <option value="ssl" <?php echo select_single( 'ssl', db_config( 'e_encryption' ) ); ?>><?php echo lang( 'ssl' ); ?></option>
                  </select>
                </div>
                <!-- /.col -->
                <div class="col-md-6 smtp-field">
                  <label for="port"><?php echo lang( 'port' ); ?> <span class="required">*</span></label>
                  <input type="text" id="port" class="form-control" name="e_port" value="<?php echo html_escape( db_config( 'e_port' ) ); ?>">
                </div>
                <!-- /.col -->
              </div>
              <!-- /.form-row -->
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

<?php load_modals( 'admin/test_email_settings' ); ?>