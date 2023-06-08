<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Resend Ticket Email Modal: -->
<div class="modal" id="resend-ticket-email">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php user_action( 'support/resend_ticket_email' ); ?>" method="post">
        <div class="modal-body">
          <div class="response-message"></div>
          <p class="mb-0"><?php echo lang( 'sure_resend' ); ?></p>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <small><i class="fas fa-times-circle me-2"></i> <?php echo lang( 'no' ); ?></small>
          </button>
          <button type="submit" class="btn btn-primary">
            <small><i class="fas fa-check-circle me-2"></i> <?php echo lang( 'yes' ); ?></small>
          </button>
          <input type="hidden" name="security_key" value="<?php echo html_escape( $this->uri->segment( 3 ) ); ?>">
          <input type="hidden" name="id" value="<?php echo intval( $this->uri->segment( 4 ) ); ?>">
        </div>
        <!-- /.modal-footer -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->