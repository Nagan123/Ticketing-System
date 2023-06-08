<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Add Canned Reply Modal: -->
<div class="modal close-after" id="add-canned-reply">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'support/add_canned_reply' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'add_canned_reply' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="form-group">
            <label for="subject-add"><?php echo lang( 'subject' ); ?> <span class="required">*</span></label>
            <input type="text" class="form-control" id="subject-add" name="subject" required>
          </div>
          <!-- /.form-group -->
          <label for="message-add"><?php echo lang( 'message' ); ?> <span class="required">*</span></label>
          <textarea class="form-control" id="message-add" name="message" rows="5" required></textarea>
          <table class="table table-bordered text-nowrap text-sm table-sm mt-2 mb-0">
            <tbody>
              <tr>
                <td>
                  <?php echo lang( 'requester_name' ); ?>
                  <span class="float-right text-primary">{REQUESTER_NAME}</span>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo lang( 'logged_in_agent' ); ?>
                  <span class="float-right text-primary">{AGENT_NAME}</span>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo lang( 'ticket_chat_subject' ); ?>
                  <span class="float-right text-primary">{SUBJECT}</span>
                </td>
              </tr>
              <tr>
                <td>
                  <?php echo lang( 'website_name' ); ?>
                  <span class="float-right text-primary">{SITE_NAME}</span>
                </td>
              </tr>
            </tbody>
          </table>
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