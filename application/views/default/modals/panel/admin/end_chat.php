<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- End Chat Modal: -->
<div class="modal" id="end-chat">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'support/end_chat' ); ?>" method="post">
        <div class="modal-body">
          <div class="response-message"></div>
          <p><?php echo lang( 'sure_end_chat' ); ?></p>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'no' ); ?>
          </button>
          <button type="submit" class="btn btn-danger text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'yes' ); ?>
          </button>
          <input type="hidden" name="id" value="<?php echo html_escape( $chat->id ); ?>">
        </div>
        <!-- /.modal-footer -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->