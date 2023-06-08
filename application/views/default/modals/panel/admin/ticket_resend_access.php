<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Ticket Resend Access Modal: -->
<div class="modal close-after" id="resend-access">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'support/ticket_resend_access' ); ?>" method="post">
        <div class="modal-body">
          <div class="response-message"></div>
          <p><?php echo lang( 'resend_access_modal' ); ?></p>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'no' ); ?>
          </button>
          <button type="submit" class="btn btn-primary text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'yes' ); ?>
          </button>
          
          <input type="hidden" name="id" value="<?php echo html_escape( $ticket->id ); ?>">
        </div>
        <!-- /.modal-footer -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->