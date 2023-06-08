<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Add Tickets Department Modal: -->
<div class="modal close-after" id="add-tickets-department">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'support/add_department' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'add_department' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="form-group">
            <label for="department-add"><?php echo lang( 'department' ); ?> <span class="required">*</span></label>
            <input type="text" class="form-control" id="department-add" name="department" required>
          </div>
          <!-- /.form-group -->
          <div class="form-row">
            <div class="col-md-6">
              <label for="visibility-add"><?php echo lang( 'visibility' ); ?></label>
              <select class="form-control select2 search-disabled" id="visibility-add" name="visibility">
                <option value="1"><?php echo lang( 'public' ); ?></option>
                <option value="0"><?php echo lang( 'hidden' ); ?></option>
              </select>
            </div>
            <!-- /.col -->
            <div class="col-md-6 mt-3 mt-md-0">
              <label for="users-add">
                <?php echo lang( 'users' ); ?>
                <i class="fas fa-info-circle text-sm" data-toggle="tooltip" data-placement="top" title="<?php echo lang( 'support_agents_tip' ); ?>"></i>
              </label>
              <select class="form-control select2 search-disabled d-users-selection" id="users-add" name="users">
                <option value="1"><?php echo lang( 'selected_users' ); ?></option>
                <option value="2"><?php echo lang( 'support_agents' ); ?></option>
              </select>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.form-row -->
          <div class="mt-3 select-users-wrapper">
            <label class="mb-0"><?php echo lang( 'select_users' ); ?> <span class="required">*</span></label>
            
            <?php if ( ! empty( $users = get_team_users() ) ) {
              foreach ( $users as $user ) { ?>
              <div class="icheck icheck-primary users-checkboxes">
                <input type="checkbox" name="team[]" id="add-user-<?php echo html_escape( $user->id ); ?>" value="<?php echo html_escape( $user->id ); ?>">
                <label for="add-user-<?php echo html_escape( $user->id ); ?>" class="d-block">
                  <span class="d-block text">
                    <?php echo html_escape( $user->first_name . ' ' . $user->last_name ); ?>
                    <span class="text-sm text-muted d-block email-address"><?php echo html_escape( $user->email_address ); ?></span>
                  </span>
                  <img class="img-circle profile-pic profile-pic-sm elevation-1" src="<?php echo user_picture( html_esc_url( $user->picture ) ); ?>" alt="<?php echo html_escape( $user->username ); ?>">
                </label>
              </div>
              <!-- /.icheck -->
            <?php }
            } ?>
          </div>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'close' ); ?>
          </button>
          <button type="submit" class="btn btn-primary text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'submit' ); ?>
          </button>
        </div>
        <!-- /.modal-footer -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->