<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
$users = ( $team === 'all_users' ) ? 2 : 1;
$team = ( $team !== 'all_users' ) ? json_decode( $team ) : new stdClass;
?>
<form class="z-form" action="<?php admin_action( 'support/update_department' ); ?>" method="post">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_department' ); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- /.modal-header -->
  <div class="modal-body">
    <div class="response-message"></div>
    <div class="form-group">
      <label for="department-edit"><?php echo lang( 'department' ); ?> <span class="required">*</span></label>
      <input type="text" class="form-control" id="department-edit" name="department" value="<?php echo html_escape( $name ); ?>" required>
    </div>
    <!-- /.form-group -->
    <div class="form-row">
      <div class="col-md-6">
        <label for="visibility-edit"><?php echo lang( 'visibility' ); ?></label>
        <select class="form-control select2 search-disabled" id="visibility-edit" name="visibility">
          <option value="1" <?php echo select_single( 1, $visibility ); ?>><?php echo lang( 'public' ); ?></option>
          <option value="0" <?php echo select_single( 0, $visibility ); ?>><?php echo lang( 'hidden' ); ?></option>
        </select>
      </div>
      <!-- /.col -->
      <div class="col-md-6 mt-3 mt-md-0">
        <label for="users-edit">
          <?php echo lang( 'users' ); ?>
          <i class="fas fa-info-circle text-sm" data-toggle="tooltip" data-placement="top" title="<?php echo lang( 'support_agents_tip' ); ?>"></i>
        </label>
        <select class="form-control select2 search-disabled d-users-selection" id="users-edit" name="users">
          <option value="1" <?php echo select_single( 1, $users ); ?>><?php echo lang( 'selected_users' ); ?></option>
          <option value="2" <?php echo select_single( 2, $users ); ?>><?php echo lang( 'support_agents' ); ?></option>
        </select>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.form-row -->
    <div class="mt-3 select-users-wrapper <?php echo ( $users == 1 ) ? 'd-block-ni' : 'd-none-ni'; ?>">
      <label class="mb-0"><?php echo lang( 'select_users' ); ?> <span class="required">*</span></label>
      <?php if ( ! empty( $users = get_team_users() ) ) {
        foreach ( $users as $user ) { ?>
        <div class="icheck icheck-primary users-checkboxes">
          <input type="checkbox" name="team[]" id="edit-user-<?php echo html_escape( $user->id ); ?>" value="<?php echo html_escape( $user->id ); ?>" <?php echo ( ! empty( $team->users ) ) ? check_single_by_array( $user->id, $team->users ) : ''; ?>>
          <label for="edit-user-<?php echo html_escape( $user->id ); ?>" class="d-block">
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
      <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'update' ); ?>
    </button>
  </div>
  <!-- /.modal-footer -->
  
  <input type="hidden" name="id" value="<?php echo html_escape( $id ); ?>">
</form>