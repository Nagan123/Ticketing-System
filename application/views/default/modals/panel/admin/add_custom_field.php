<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Add Custom Field Modal: -->
<div class="modal close-after" id="add-custom-field">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'custom_fields/add_custom_field' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'add_custom_field' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name-add"><?php echo lang( 'name' ); ?> <span class="required">*</span></label>
              <input type="text" class="form-control" id="name-add" name="name" required>
            </div>
            <!-- /.form-group -->
            <div class="form-group col-md-6">
              <label for="field-type-add"><?php echo lang( 'field_type' ); ?></label>
              <select class="form-control select2 search-disabled" id="field-type-add" name="type">
                <option value="text"><?php echo lang( 'text' ); ?></option>
                <option value="email"><?php echo lang( 'email' ); ?></option>
                <option value="textarea"><?php echo lang( 'textarea' ); ?></option>
                <option value="checkbox"><?php echo lang( 'checkbox' ); ?></option>
                <option value="select"><?php echo lang( 'select' ); ?></option>
                <option value="radio"><?php echo lang( 'radio' ); ?></option>
              </select>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.form-row -->
          <div class="form-group">
            <label for="guide-text-add"><?php echo lang( 'guide_text' ); ?></label>
            <input type="text" class="form-control" id="guide-text-add" name="guide_text">
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label for="options-add"><?php echo lang( 'options' ); ?></label>
            <textarea class="form-control" id="options-add" name="options" rows="3"></textarea>
            <small class="form-text text-muted"><?php echo lang( 'cf_options_tip' ); ?></small>
          </div>
          <!-- /.form-group -->
          <label for="required-add"><?php echo lang( 'required' ); ?></label>
          <select class="form-control select2 search-disabled" id="required-add" name="is_required">
            <option value="0"><?php echo lang( 'no' ); ?></option>
            <option value="1"><?php echo lang( 'yes' ); ?></option>
          </select>
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