<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="response-message"><?php echo alert_message(); ?></div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-sm-12">
        <form class="z-form" action="<?php admin_action( 'support/create_ticket' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
          <div class="response-message"></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'create_ticket' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="subject"><?php echo lang( 'subject' ); ?> <span class="required">*</span></label>
                  <input type="text" id="subject" class="form-control" name="subject" required>
                </div>
                <!-- /.form-group -->
                <div class="form-group col-md-6">
                  <label for="priority"><?php echo lang( 'priority' ); ?> <span class="required">*</span></label>
                  <select id="priority" data-placeholder="<?php echo lang( 'choose_priority' ); ?>" class="form-control select2 search-disabled" name="priority" required>
                    <option></option>
                    <option value="low"><?php echo lang( 'low' ); ?></option>
                    <option value="medium"><?php echo lang( 'medium' ); ?></option>
                    <option value="high"><?php echo lang( 'high' ); ?></option>
                  </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.form-row -->
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="department"><?php echo lang( 'department' ); ?> <span class="required">*</span></label>
                  <select id="department" data-placeholder="<?php echo lang( 'select_department' ); ?>" class="form-control select2 search-disabled" name="department" required>
                    <option></option>
                    
                    <?php if ( ! empty( $departments ) ) {
                      foreach ( $departments as $department ) { ?>
                      <option value="<?php echo html_escape( $department->id ); ?>"><?php echo html_escape( $department->name ); ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group col-md-6">
                  
                  <?php if ( get( 'type' ) == 'unregistered_users' ) { ?>
                    <label for="email-address">
                      <?php echo lang( 'email_address' ); ?> <span class="required">*</span>
                      <i class="fas fa-info-circle text-sm" data-toggle="tooltip" data-placement="top" title="<?php echo lang( 'customer_email_tip' ); ?>"></i>
                    </label>
                    <input type="email" id="email-address" class="form-control" name="email_address" required>
                  <?php } else { ?>
                    <label for="customer"><?php echo lang( 'customer' ); ?> <span class="required">*</span></label>
                    <select id="customer" data-placeholder="<?php echo lang( 'select_customer' ); ?>" class="form-control select2" name="customer" required>
                      <option></option>
                      
                      <?php if ( ! empty( $customers ) ) {
                        foreach ( $customers as $customer ) { ?>
                        <option value="<?php echo html_escape( $customer->id ); ?>"><?php echo html_escape( $customer->first_name . ' ' . $customer->last_name ); ?> ( <?php echo html_escape( $customer->username ); ?> )</option>
                      <?php }
                      } ?>
                    </select>
                  <?php } ?>
                  
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.form-row -->
              <div class="form-group">
                <label for="message"><?php echo lang( 'message' ); ?> <span class="required">*</span></label>
                <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
              </div>
              <!-- /.form-group -->
              
              <?php load_view( 'common/custom_fields' ); ?>
              
              <label for="attachment"><?php echo lang( 'attach_file_opt' ); ?></label>
              <input type="file" class="d-block" id="attachment" name="attachment" accept="<?php echo ALLOWED_ATTACHMENTS_EXT_HTML; ?>">
              <small id="attachment-guide" class="form-text text-muted"><?php echo lang( 'attach_file_tip' ); ?></small>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right text-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'submit' ); ?>
              </button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
          <input type="hidden" name="type" value="<?php echo html_escape( get( 'type' ) ); ?>">
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->