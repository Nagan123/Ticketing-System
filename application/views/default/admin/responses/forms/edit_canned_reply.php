<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<form class="z-form" action="<?php admin_action( 'support/update_canned_reply' ); ?>" method="post">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_canned_reply' ); ?></h5>
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
    <label for="message-edit"><?php echo lang( 'message' ); ?> <span class="required">*</span></label>
    <textarea class="form-control" id="message-edit" name="message" rows="5" required><?php echo html_escape( $message ); ?></textarea>
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
      <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'update' ); ?>
    </button>
  </div>
  <!-- /.modal-footer -->
  
  <input type="hidden" name="id" value="<?php echo html_escape( $id ); ?>">
</form>