<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <form class="z-form" action="<?php admin_action( 'users/update_user' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <div class="row">
        <div class="col">
          <div class="response-message"><?php echo alert_message(); ?></div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xl-9">
          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title"><?php echo lang( 'activity' ); ?></h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item">
                  <span>
                    <strong><?php echo lang( 'last_activity' ); ?>:</strong>
                    
                    <?php
                    if ( ! empty( $user->last_activity ) )
                    {
                        echo get_date_time_by_timezone( html_escape( $user->last_activity ) );
                    }
                    else
                    {
                        echo lang( 'n_a' );
                    }
                    ?>
                  </span>
                </li>
                <li class="list-group-item">
                  <span>
                    <strong><?php echo lang( 'last_login' ); ?>:</strong>
                    <?php
                    if ( ! empty( $user->last_login ) )
                    {
                        echo get_date_time_by_timezone( html_escape( $user->last_login ) );
                    }
                    else
                    {
                        echo lang( 'n_a' );
                    }
                    ?>
                  </span>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php load_view( 'common/panel/user/user_details' ); ?>
        </div>
        <!-- /.col -->
        <div class="col-xl-3">
          <?php if ( $user->id == 1 ) { ?>
            <div class="alert alert-info">
              <p><?php echo lang( 'u_change_not_allowed' ); ?></p>
            </div>
            <!-- /.alert -->
          <?php } ?>
          <div class="card">
            <div class="card-header">
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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo lang( 'status' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <select class="form-control select2 search-disabled" name="status">
                <option value="1" <?php echo select_single( 1, $user->status ); ?>><?php echo lang( 'active' ); ?></option>
                <option value="0" <?php echo select_single( 0, $user->status ); ?>><?php echo lang( 'banned' ); ?></option>
              </select>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo lang( 'email_verified' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="icheck icheck-primary d-inline-block mr-2">
                <input type="radio" name="email_verified" id="email-verified-1" value="1" <?php echo check_single( 1, $user->is_verified ); ?>>
                <label for="email-verified-1"><?php echo lang( 'yes' ); ?></label>
              </div>
              <!-- /.icheck -->
              <div class="icheck icheck-primary d-inline-block">
                <input type="radio" name="email_verified" id="email-verified-0" value="0" <?php echo check_single( 0, $user->is_verified ); ?>>
                <label for="email-verified-0"><?php echo lang( 'no' ); ?></label>
              </div>
              <!-- /.icheck -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          
          <?php load_view( 'common/panel/user/right_of_profile_settings' ); ?>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <input type="hidden" name="id" value="<?php echo html_escape( $user->id ); ?>">
    </form>
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php load_modals( ['admin/view_profile_picture', 'admin/delete_profile_picture'] ); ?>