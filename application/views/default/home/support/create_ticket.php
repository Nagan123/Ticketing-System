<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-page-form my-5 create-ticket extra-height-1">
  <form class="z-form" action="<?php user_action( 'support/create_ticket' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          
          <?php if ( db_config( 'create_ticket_page_message' ) && db_config( 'show_tp_message' ) == 1 ) { ?>
            <div class="alert bg-sub text-center text-white"><?php echo html_escape( db_config( 'create_ticket_page_message' ) ); ?></div>
          <?php } ?>
          
          <div class="shadow-sm wrapper">
            <h3 class="h5 mb-4 fw-bold border-bottom pb-2"><?php echo lang( 'create_ticket' ); ?></h3>
            <div class="row g-3 mb-3">
              <div class="col">
                <label for="subject" class="form-label"><?php echo lang( 'subject' ); ?> <span class="text-danger">*</span></label>
                <input type="text" id="subject" class="form-control" name="subject" required>
              </div>
              <!-- /.col -->
              <div class="col">
                <label for="priority" class="form-label"><?php echo lang( 'priority' ); ?> <span class="text-danger">*</span></label>
                <select id="priority" class="form-control select2 search-disabled" name="priority" data-placeholder="<?php echo lang( 'choose_priority' ); ?>" required>
                  <option></option>
                  <option value="low"><?php echo lang( 'low' ); ?></option>
                  <option value="medium"><?php echo lang( 'medium' ); ?></option>
                  <option value="high"><?php echo lang( 'high' ); ?></option>
                </select>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="mb-3">
              <label for="department" class="form-label"><?php echo lang( 'department' ); ?> <span class="text-danger">*</span></label>
              <select id="department" class="form-control select2 search-disabled" name="department" data-placeholder="<?php echo lang( 'select_department' ); ?>" required>
                <option></option>
                <?php if ( ! empty( $departments ) ) {
                  foreach ( $departments as $department ) { ?>
                  <option value="<?php echo html_escape( $department->id ); ?>"><?php echo html_escape( $department->name ); ?></option>
                <?php }
                } ?>
              </select>
            </div>
            <!-- /.mb-3 -->
            <div class="mb-3">
              <label for="message" class="form-label"><?php echo lang( 'message' ); ?> <span class="text-danger">*</span></label>
              <textarea id="message" class="form-control" name="message" rows="8" required></textarea>
            </div>
            <!-- /.mb-3 -->
            
            <?php load_view( 'common/custom_fields' ); ?>
            
            <div class="mb-3">
              <label for="email-address" class="form-label"><?php echo lang( 'email_address' ); ?> <span class="text-danger">*</span></label>
              <input type="email" id="email-address" class="form-control" name="email_address" required>
              <p class="p-2 bg-light border border-top-0 shadow-sm rounded text-center small"><?php echo lang( 'guest_email_guide' ); ?></p>
            </div>
            <!-- /.mb-3 -->
            <div class="mb-3">
              <label for="retype-email-address" class="form-label"><?php echo lang( 'retype_email_address' ); ?> <span class="text-danger">*</span></label>
              <input type="email" id="retype-email-address" class="form-control" name="retype_email_address" required>
            </div>
            <!-- /.mb-3 -->
            <div class="mb-3">
              <label for="attachment" class="form-label"><?php echo lang( 'attach_file_opt' ); ?></label>
              <input type="file" class="d-block" id="attachment" name="attachment" accept="<?php echo ALLOWED_ATTACHMENTS_EXT_HTML; ?>">
              <small id="attachment-guide" class="form-text"><?php echo lang( 'attach_file_tip' ); ?></small>
            </div>
            <!-- /.mb-3 -->
            <?php if ( is_gr_togo() ) { ?>
              <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="<?php echo html_escape( db_config( 'gr_public_key' ) ); ?>"></div>
              </div>
              <!-- /.mb-3 -->
            <?php } ?>
            <div class="response-message"></div>
            <div class="border-top pt-3 clearfix">
              <button class="btn btn-sub btn-wide float-end" type="submit"><?php echo lang( 'submit' ); ?></button>
            </div>
          </div>
          <!-- /.wrapper -->
        </div>
        <!-- /col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
    <input type="hidden" name="from_guest" value="1">
  </form>
</div>
<!-- /.z-page-form -->