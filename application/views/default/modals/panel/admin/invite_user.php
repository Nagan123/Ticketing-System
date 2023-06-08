<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Invite User Modal: -->
<div class="modal close-after" id="invite-user">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'users/invite_user' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'invite_user' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="form-group">
            <label for="email-address-add"><?php echo lang( 'email_address' ); ?> <span class="required">*</span></label>
            <input type="email" class="form-control" id="email-address-add" name="email_address" required>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label for="expires-in-add"><?php echo lang( 'expires_in_hrs' ); ?> <span class="required">*</span></label>
            <input type="text" class="form-control" id="expires-in-add" name="expires_in" value="24" required>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label for="et-language"><?php echo lang( 'email_template' ); ?></label>
            <select class="form-control select2 search-disabled" id="et-language" name="et_language">
              <?php foreach ( AVAILABLE_LANGUAGES as $key => $value ) { ?>
                <option value="<?php echo html_escape( $key ); ?>"><?php echo html_escape( $value['display_label'] ); ?></option>
              <?php } ?>
            </select>
          </div>
          <!-- /.form-group -->
          <label class="d-block">
            <?php echo lang( 'bypass_registration' ); ?>
            <i class="fas fa-info-circle text-sm" data-toggle="tooltip" title="<?php echo lang( 'bypass_reg_tip' ); ?>"></i>
          </label>
          <div class="icheck icheck-primary d-inline-block mr-2">
            <input type="radio" name="bypass_registration" id="bypass-registration-add-1" value="1" checked="checked">
            <label for="bypass-registration-add-1"><?php echo lang( 'yes' ); ?></label>
          </div>
          <!-- /.icheck -->
          <div class="icheck icheck-primary d-inline-block">
            <input type="radio" name="bypass_registration" id="bypass-registration-add-0" value="0">
            <label for="bypass-registration-add-0"><?php echo lang( 'no' ); ?></label>
          </div>
          <!-- /.icheck -->
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