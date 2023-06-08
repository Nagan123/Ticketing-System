<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<form class="z-form" action="<?php admin_action( 'support/update_ticket_reply' ); ?>" method="post" enctype="multipart/form-data">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_reply' ); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- /.modal-header -->
  <div class="modal-body">
    <div class="response-message"></div>
    <div class="form-group">
      <label for="message"><?php echo lang( 'message' ); ?> <span class="required">*</span></label>
      <textarea class="form-control" id="message" name="message" rows="6" required><?php echo html_escape( $message ); ?></textarea>
    </div>
    <!-- /.form-group -->
    <label for="attachment">
      <?php
      if ( ! empty( $attachment ) )
      {
          echo lang( 'change_attached_file' );
      }
      else
      {
          echo lang( 'attach_file_opt' );
      }
      ?>
    </label>
    <input type="file" class="d-block" id="attachment" name="attachment" accept="<?php echo ALLOWED_ATTACHMENTS_EXT_HTML; ?>">
    <small class="form-text text-muted"><?php echo lang( 'attach_file_tip' ); ?></small>
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