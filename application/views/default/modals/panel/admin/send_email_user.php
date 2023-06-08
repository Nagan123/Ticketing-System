<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Send Email to User Modal: -->
<div class="modal close-after" id="send-email-user" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'users/send_email_user' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'send_email' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="callout callout-info">
            <p><?php echo lang( 'u_esend_guide' ); ?></p>
          </div>
          <!-- /.callout -->
          <div class="form-group">
            <label for="seu-email"><?php echo lang( 'email_address' ); ?></label>
            <input type="email" class="form-control" id="seu-email" readonly>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label for="subject"><?php echo lang( 'subject' ); ?> <span class="required">*</span></label>
            <input type="text" id="subject" class="form-control" name="subject" required>
          </div>
          <!-- /.form-group -->
          <label for="textarea"><?php echo lang( 'message' ); ?> <span class="required">*</span></label>
          <textarea class="form-control textarea" id="textarea" rows="6" name="message"></textarea>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'no' ); ?>
          </button>
          <button type="submit" class="btn btn-primary text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'send' ); ?>
          </button>
          <input type="hidden" name="id">
        </div>
        <!-- /.modal-footer -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->