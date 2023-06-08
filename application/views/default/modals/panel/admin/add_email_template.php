<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Add Email Template Modal: -->
<div class="modal close-after" id="add-email-template">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'tools/add_email_template' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'add_email_template' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title-add"><?php echo lang( 'title' ); ?> <span class="required">*</span></label>
              <input type="text" class="form-control" id="title-add" name="title" required>
            </div>
            <!-- /.form-group -->
            <div class="form-group col-md-6">
              <label for="subject-add"><?php echo lang( 'subject' ); ?> <span class="required">*</span></label>
              <input type="text" class="form-control" id="subject-add" name="subject" required>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.form-row -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="hook-add">
                <?php echo lang( 'hook' ); ?>
                <i class="fas fa-info-circle text-sm" data-toggle="tooltip" title="<?php echo lang( 'et_hook_tip' ); ?>"></i>
                <span class="required">*</span>
              </label>
              <input type="text" class="form-control" id="hook-add" name="hook" required>
            </div>
            <!-- /.form-group -->
            <div class="form-group col-md-6">
              <label for="language-add"><?php echo lang( 'language' ); ?></label>
              <select class="form-control select2 search-disabled" id="language-add" name="language">
                <?php foreach ( AVAILABLE_LANGUAGES as $key => $value ) { ?>
                  <option value="<?php echo html_escape( $key ); ?>"><?php echo html_escape( $value['display_label'] ); ?></option>
                <?php } ?>
              </select>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.form-row -->
          <div class="form-row">
            <div class="col-md-6">
              <label for="textarea"><?php echo lang( 'template' ); ?> <span class="required">*</span></label>
              <textarea class="form-control textarea" id="textarea" name="template"></textarea>
            </div>
            <!-- /.col -->
            <div class="col-md-6 cpt-1">
              <table class="table table-bordered text-nowrap text-sm table-sm">
                <tbody>
                  <tr>
                    <td>
                      <?php echo lang( 'users_name' ); ?>
                      <span class="float-right text-primary">{USER_NAME}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'the_base_url' ); ?>
                      <span class="float-right text-primary">{SITE_URL}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'website_name' ); ?>
                      <span class="float-right text-primary">{SITE_NAME}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'email_link' ); ?>
                      <span class="float-right text-primary">{EMAIL_LINK}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'username' ); ?>
                      <span class="float-right text-primary">{LOGIN_USERNAME}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'department_name' ); ?>
                      <span class="float-right text-primary">{DEPARTMENT_NAME}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'ticket_id' ); ?>
                      <span class="float-right text-primary">{TICKET_ID}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'ticket_url' ); ?>
                      <span class="float-right text-primary">{TICKET_URL}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo lang( 'chat_url' ); ?>
                      <span class="float-right text-primary">{CHAT_URL}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.form-row -->
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