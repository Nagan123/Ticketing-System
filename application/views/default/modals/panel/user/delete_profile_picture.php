<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Delete Profile Picture Modal ( User ): -->
<div class="modal" id="delete-pp">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php user_action( 'account/delete_profile_picture' ); ?>" method="post">
        <div class="modal-body">
          <div class="response-message"></div>
          <p class="mb-0"><?php echo lang( 'sure_delete_pp' ); ?></p>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <small><i class="fas fa-times-circle me-2"></i> <?php echo lang( 'no' ); ?></small>
          </button>
          <button type="submit" class="btn btn-danger">
            <small><i class="fas fa-check-circle me-2"></i> <?php echo lang( 'yes' ); ?></small>
          </button>
        </div>
        <!-- /.modal-footer -->
        <input type="hidden" name="area" value="user">
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->