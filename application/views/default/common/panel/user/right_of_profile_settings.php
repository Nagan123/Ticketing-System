<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="card">
  <div class="card-header d-flex align-items-center">
    <h3 class="card-title"><?php echo lang( 'profile_picture' ); ?></h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="image-preview">
      <label for="image-upload" id="image-label"><?php echo lang( 'choose_file' ); ?></label>
      <input type="file" name="picture" id="image-upload" accept="<?php echo ALLOWED_IMG_EXT_HTML; ?>">
    </div>
    <!-- /#image-preview -->
    <hr>
    <small class="form-text text-muted"><?php echo avator_tip(); ?></small>
  </div>
  <!-- /.card-body -->
  <?php if ( $user->picture !== DEFAULT_USER_IMG ) { ?>
    <div class="card-footer">
      <span class="text-primary cursor-pointer text-sm" data-toggle="modal" data-target="#view-pp">
        <i class="fas fa-image mr-1"></i> <?php echo lang( 'view' ); ?>
      </span>      
      <span class="text-danger cursor-pointer text-sm float-right" data-toggle="modal" data-target="#delete-pp">
        <i class="fas fa-trash mr-1"></i> <?php echo lang( 'delete' ); ?>
      </span>
    </div>
    <!-- /.card-footer -->
  <?php } ?>
</div>
<!-- /.card -->