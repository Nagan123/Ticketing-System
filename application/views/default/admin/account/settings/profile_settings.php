<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <form class="z-form" action="<?php user_action( 'account/update_profile_settings' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="area" value="admin">
      <div class="row">
        <div class="col">
          <div class="response-message"><?php echo alert_message(); ?></div>
          
          <?php if ( ! empty( $this->zuser->get( 'pending_email_address' ) ) ) { ?>
            <div class="alert alert-info">
              <p><?php printf( lang( 'pending_email_msg' ), html_escape( $this->zuser->get( 'pending_email_address' ) ) ); ?></p>
            </div>
          <?php } ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xl-9">
          <?php load_view( 'common/panel/user/user_details' ); ?>
        </div>
        <!-- /.col -->
        <div class="col-xl-3">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'action' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="submit" class="btn btn-primary btn-block text-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'update' ); ?>
              </button>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php load_view( 'common/panel/user/right_of_profile_settings' ); ?>
          
          <?php if ( db_config( 'u_can_remove_them' ) == 1 && $this->zuser->get( 'id' ) != 1 ) { ?>
            <div class="card">
              <div class="card-body">
                <button type="button" class="btn btn-danger btn-block text-sm" data-toggle="modal" data-target="#delete-account">
                  <i class="fas fa-trash mr-2"></i> <?php echo lang( 'delete_account' ); ?>
                </button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          <?php } ?>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </form>
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php load_modals( ['admin/view_profile_picture', 'admin/delete_my_profile_picture', 'admin/delete_account'] ); ?>