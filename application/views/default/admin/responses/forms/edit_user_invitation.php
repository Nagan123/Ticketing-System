<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<form class="z-form" action="<?php admin_action( 'users/update_invitation' ); ?>" method="post">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_user_invite' ); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- /.modal-header -->
  <div class="modal-body">
    <div class="response-message"></div>
    <div class="form-group">
      <label for="email-address-edit"><?php echo lang( 'email_address' ); ?> <span class="required">*</span></label>
      <input type="email" class="form-control" id="email-address-edit" name="email_address" value="<?php echo html_escape( $email_address ); ?>" readonly>
    </div>
    <!-- /.form-group -->
    <div class="form-group">
      <label for="expires-in-edit"><?php echo lang( 'expires_in_hrs' ); ?> <span class="required">*</span></label>
      <input type="text" class="form-control" id="expires-in-edit" name="expires_in" value="<?php echo html_escape( $expires_in ); ?>" required>
    </div>
    <!-- /.form-group -->
    <label class="d-block">
      <?php echo lang( 'bypass_registration' ); ?>
      <i class="fas fa-info-circle text-sm" data-toggle="tooltip" title="<?php echo lang( 'bypass_reg_tip' ); ?>"></i>
    </label>
    <div class="icheck icheck-primary d-inline-block mr-2">
      <input type="radio" name="bypass_registration" id="bypass-registration-edit-1" value="1" <?php echo check_single( 1, $bypass_registration ); ?>>
      <label for="bypass-registration-edit-1"><?php echo lang( 'yes' ); ?></label>
    </div>
    <!-- /.icheck -->
    <div class="icheck icheck-primary d-inline-block">
      <input type="radio" name="bypass_registration" id="bypass-registration-edit-0" value="0" <?php echo check_single( 0, $bypass_registration ); ?>>
      <label for="bypass-registration-edit-0"><?php echo lang( 'no' ); ?></label>
    </div>
    <!-- /.icheck -->
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