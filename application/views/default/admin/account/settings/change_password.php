<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="z-form" action="<?php admin_action( 'account/change_password' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <input type="hidden" name="area" value="admin">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'change_password' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              
              <?php if ( ! empty( $this->zuser->get( 'password' ) ) ) { ?>
                <div class="form-group">
                  <label for="current-password"><?php echo lang( 'current_password' ); ?> <span class="required">*</span></label>
                  <input type="password" id="current-password" class="form-control" name="current_password" required>
                </div>
                <!-- /.form-group -->
              <?php } ?>
              
              <div class="form-group">
                <label for="password"><?php echo lang( 'password' ); ?> <span class="required">*</span></label>
                <input type="password" id="password" class="form-control" name="password" required>
              </div>
              <!-- /.form-group -->
              <label for="retype-password"><?php echo lang( 'retype_password' ); ?> <span class="required">*</span></label>
              <input type="password" id="retype-password" class="form-control" name="retype_password" required>
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