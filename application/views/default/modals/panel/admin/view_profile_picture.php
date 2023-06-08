<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- View Profile Picture Modal: -->
<div class="modal" id="view-pp">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img src="<?php echo user_picture( html_esc_url( $user->picture ) ); ?>" class="img" alt="User Image">
      </div>
      <!-- /.modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
          <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'close' ); ?>
        </button>
      </div>
      <!-- /.modal-footer -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->