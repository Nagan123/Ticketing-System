<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<form class="z-form" action="<?php admin_action( 'tools/update_announcement' ); ?>" method="post">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_announcement' ); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- /.modal-header -->
  <div class="modal-body">
    <div class="response-message"></div>
    <div class="form-group">
      <label for="subject-edit"><?php echo lang( 'subject' ); ?> <span class="required">*</span></label>
      <input type="text" class="form-control" id="subject-edit" name="subject" value="<?php echo html_escape( $subject ); ?>" required>
    </div>
    <!-- /.form-group -->
    <label for="announcement-edit"><?php echo lang( 'announcement' ); ?> <span class="required">*</span></label>
    <textarea class="form-control" id="announcement-edit" name="announcement" rows="5" required><?php echo html_escape( $announcement ); ?></textarea>
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