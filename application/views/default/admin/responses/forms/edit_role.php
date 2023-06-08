<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<form class="z-form" action="<?php admin_action( 'settings/update_role' ); ?>" method="post">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_role' ); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- /.modal-header -->
  <div class="modal-body">
    <div class="response-message"></div>
    <div class="form-group">
      <label for="name-edit"><?php echo lang( 'name' ); ?> <span class="required">*</span></label>
      <input type="text" class="form-control" id="name-edit" name="name" value="<?php echo html_escape( $name ); ?>" required>
    </div>
    <!-- /.form-group -->
    <label for="access-key-edit"><?php echo lang( 'access_key' ); ?> <span class="required">*</span></label>
    
    <?php
    if ( $is_built_in == 0 )
    {
        $state = 'required';
    }
    else
    {
        $state = 'readonly';
    }
    ?>
    
    <input type="text" class="form-control" id="access-key-edit" name="access_key" value="<?php echo html_escape( $access_key ); ?>" <?php echo html_escape( $state ); ?>>
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