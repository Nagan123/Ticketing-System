<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Assign User ( Chat ) Modal: -->
<div class="modal" id="assign-user-chat">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'support/assign_user/chat' ); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo intval( $chat->id ); ?>">
        <div class="modal-body">
          <div class="response-message"></div>
          <p class="mb-2"><?php echo lang( 'sure_assign_user_chat' ); ?></p>
          <select class="form-control select2 search-disabled" data-placeholder="<?php echo lang( 'select_user' ); ?>" name="user" required>
            <?php if ( $chat->assigned_to == null ) { ?>
              <option></option>
            <?php } ?>
            
            <?php if ( ! empty( $users = get_team_users() ) ) {
              foreach ( $users as $user ) { ?>
              <option value="<?php echo html_escape( $user->id ); ?>" <?php echo select_single( $chat->assigned_to, $user->id ); ?>><?php echo html_escape( $user->first_name . ' ' . $user->last_name ); ?> ( <?php echo html_escape( $user->username ); ?> )</option>
            <?php }
            } ?>
            
            <?php if ( $chat->assigned_to != null ) { ?>
              <option value="0"><?php echo lang( 'unassign' ); ?></option>
            <?php } ?>
          </select>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'no' ); ?>
          </button>
          <button type="submit" class="btn btn-primary text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'yes' ); ?>
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