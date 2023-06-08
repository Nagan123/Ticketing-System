<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Logout From Other Devices Modal: -->
<div class="modal" id="logout-others">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php user_action( 'tools/logout_my_others' ); ?>" method="post">
        <div class="modal-body">
          <div class="response-message"></div>
          <p class="mb-0"><?php echo lang( 'sure_logout_my_others' ); ?></p>
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
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->