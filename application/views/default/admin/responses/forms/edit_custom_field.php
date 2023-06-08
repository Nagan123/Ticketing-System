<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<form class="z-form" action="<?php admin_action( 'custom_fields/update_custom_field' ); ?>" method="post">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_custom_field' ); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- /.modal-header -->
  <div class="modal-body">
    <div class="response-message"></div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="name-edit"><?php echo lang( 'name' ); ?> <span class="required">*</span></label>
        <input type="text" class="form-control" id="name-edit" name="name" value="<?php echo html_escape( $name ); ?>" required>
      </div>
      <!-- /.form-group -->
      <div class="form-group col-md-6">
        <label for="field-type-edit"><?php echo lang( 'field_type' ); ?></label>
        <select class="form-control select2 search-disabled" id="field-type-edit" name="type">
          <option value="text" <?php echo select_single( 'text', $type ); ?>><?php echo lang( 'text' ); ?></option>
          <option value="email" <?php echo select_single( 'email', $type ); ?>><?php echo lang( 'email' ); ?></option>
          <option value="textarea" <?php echo select_single( 'textarea', $type ); ?>><?php echo lang( 'textarea' ); ?></option>
          <option value="checkbox" <?php echo select_single( 'checkbox', $type ); ?>><?php echo lang( 'checkbox' ); ?></option>
          <option value="select" <?php echo select_single( 'select', $type ); ?>><?php echo lang( 'select' ); ?></option>
          <option value="radio" <?php echo select_single( 'radio', $type ); ?>><?php echo lang( 'radio' ); ?></option>
        </select>
      </div>
      <!-- /.form-group -->
    </div>
    <!-- /.form-row -->
    <div class="form-group">
      <label for="guide-text-edit"><?php echo lang( 'guide_text' ); ?></label>
      <input type="text" class="form-control" id="guide-text-edit" name="guide_text" value="<?php echo html_escape( $guide_text ); ?>">
    </div>
    <!-- /.form-group -->
    <div class="form-group">
      <label for="options-edit"><?php echo lang( 'options' ); ?></label>
      <textarea class="form-control" id="options-edit" name="options" rows="3"><?php echo html_escape( $options ); ?></textarea>
      <small class="form-text text-muted"><?php echo lang( 'cf_options_tip' ); ?></small>
    </div>
    <!-- /.form-group -->
    <label for="required-edit"><?php echo lang( 'required' ); ?></label>
    <select class="form-control select2 search-disabled" id="required-edit" name="is_required">
      <option value="1" <?php echo select_single( 1, $is_required ); ?>><?php echo lang( 'yes' ); ?></option>
      <option value="0" <?php echo select_single( 0, $is_required ); ?>><?php echo lang( 'no' ); ?></option>
    </select>
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