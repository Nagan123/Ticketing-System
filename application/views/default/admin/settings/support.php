<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="z-form" action="<?php admin_action( 'settings/support' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'support_settings' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-group">
                <label for="allow-ticket-repoen"><?php echo lang( 'allow_ticket_reopen' ); ?></label>
                <select id="allow-ticket-repoen" class="form-control select2 search-disabled" name="sp_allow_ticket_reopen">
                  <option value="0" <?php echo select_single( 0, db_config( 'sp_allow_ticket_reopen' ) ); ?>><?php echo lang( 'no' ); ?></option>
                  <option value="1" <?php echo select_single( 1, db_config( 'sp_allow_ticket_reopen' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="ticket-close-after"><?php echo lang( 'auto_close_tickets' ); ?></label>
                <select id="ticket-close-after" class="form-control select2 search-disabled" name="auto_close_tickets">
                  <option value="1" <?php echo select_single( 1, db_config( 'auto_close_tickets' ) ); ?>><?php echo lang( 'close_older_3' ); ?></option>
                  <option value="2" <?php echo select_single( 2, db_config( 'auto_close_tickets' ) ); ?>><?php echo lang( 'close_older_7' ); ?></option>
                  <option value="3" <?php echo select_single( 3, db_config( 'auto_close_tickets' ) ); ?>><?php echo lang( 'close_older_14' ); ?></option>
                  <option value="4" <?php echo select_single( 4, db_config( 'auto_close_tickets' ) ); ?>><?php echo lang( 'dont_auto_close' ); ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="verification-before-submit">
                  <?php echo lang( 'ver_before_submit' ); ?>
                  <i class="fas fa-info-circle text-sm" data-toggle="tooltip" title="<?php echo lang( 'ver_before_submit_tip' ); ?>"></i>
                </label>
                <select id="verification-before-submit" class="form-control select2 search-disabled" name="sp_verification_before_submit">
                  <option value="0" <?php echo select_single( 0, db_config( 'sp_verification_before_submit' ) ); ?>><?php echo lang( 'no' ); ?></option>
                  <option value="1" <?php echo select_single( 1, db_config( 'sp_verification_before_submit' ) ); ?>><?php echo lang( 'yes' ); ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="create-ticket-page-message"><?php echo lang( 'create_ticket_page_msg' ); ?></label>
                <textarea id="create-ticket-page-message" class="form-control" name="create_ticket_page_message" rows="4"><?php echo html_escape( db_config( 'create_ticket_page_message' ) ); ?></textarea>
                <div class="mt-1">
                  <label class="d-block text-sm"><?php echo lang( 'show_this_message' ); ?></label>
                  <div class="icheck icheck-primary">
                    <input type="radio" name="show_tp_message" id="show-tp-message-1" value="1" <?php echo check_single( 1, db_config( 'show_tp_message' ) ); ?>>
                    <label for="show-tp-message-1" class="text-sm"><?php echo lang( 'yes' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                  <div class="icheck icheck-primary">
                    <input type="radio" name="show_tp_message" id="show-tp-message-0" value="0" <?php echo check_single( 0, db_config( 'show_tp_message' ) ); ?>>
                    <label for="show-tp-message-0" class="text-sm"><?php echo lang( 'no' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                </div>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="email-notifications"><?php echo lang( 'email_notifications' ); ?></label>
                <select id="email-notifications" class="form-control select2 search-disabled" name="sp_email_notifications">
                  <option value="0" <?php echo select_single( 0, db_config( 'sp_email_notifications' ) ); ?>><?php echo lang( 'disable' ); ?></option>
                  <option value="1" <?php echo select_single( 1, db_config( 'sp_email_notifications' ) ); ?>><?php echo lang( 'enable' ); ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="live-chatting"><?php echo lang( 'live_chatting' ); ?></label>
                <select id="live-chatting" class="form-control select2 search-disabled" name="sp_live_chatting">
                  <option value="0" <?php echo select_single( 0, db_config( 'sp_live_chatting' ) ); ?>><?php echo lang( 'disable' ); ?></option>
                  <option value="1" <?php echo select_single( 1, db_config( 'sp_live_chatting' ) ); ?>><?php echo lang( 'enable' ); ?></option>
                </select>
              </div>
              <!-- /.form-group -->
              <label for="guest-ticketing"><?php echo lang( 'guest_ticketing' ); ?></label>
              
              <?php if ( ! is_email_settings_filled() ) { ?>
                <div id="guest-ticketing-alert" class="alert alert-danger mb-2 <?php echo ( db_config( 'sp_guest_ticketing' ) == 0 ) ? 'd-none' : ''; ?>">
                  <?php echo lang( 'mailing_config_missing' ); ?>
                </div>
              <?php } ?>
              
              <select id="guest-ticketing" class="form-control select2 search-disabled" name="sp_guest_ticketing">
                <option value="0" <?php echo select_single( 0, db_config( 'sp_guest_ticketing' ) ); ?>><?php echo lang( 'disable' ); ?></option>
                <option value="1" <?php echo select_single( 1, db_config( 'sp_guest_ticketing' ) ); ?>><?php echo lang( 'enable' ); ?></option>
              </select>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right text-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'update' ); ?>
              </button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->