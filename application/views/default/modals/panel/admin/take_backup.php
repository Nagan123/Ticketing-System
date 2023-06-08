<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Take Backup Modal: -->
<div class="modal close-after" id="take-backup">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="take-backup-form" action="<?php admin_action( 'tools/take_backup' ); ?>" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'take_backup' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="callout callout-warning">
            <p><?php echo lang( 'backup_guide' ); ?></p>
          </div>
          <!-- /.callout -->
          <div class="form-group">
            <label for="backup-option"><?php echo lang( 'option' ); ?></label>
            <select class="form-control select2 search-disabled" id="backup-option" name="option">
              <?php foreach ( backup_options() as $key => $value ) { ?>
                <option value="<?php echo html_escape( $key ); ?>"><?php echo html_escape( $value ); ?></option>
              <?php } ?>
            </select>
          </div>
          <!-- /.form-group -->
          <label for="backup-action"><?php echo lang( 'action' ); ?></label>
          <select class="form-control select2 search-disabled" id="backup-action" name="action">
            <?php foreach ( backup_actions() as $key => $value ) { ?>
              <option value="<?php echo html_escape( $key ); ?>"><?php echo html_escape( $value ); ?></option>
            <?php } ?>
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