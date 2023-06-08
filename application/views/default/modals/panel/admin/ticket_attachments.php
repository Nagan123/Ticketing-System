<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
if ( ! empty( $ticket->attachment ) && is_image_file( $ticket->attachment ) ) {
?>
  <div class="modal" id="view-attachment-ticket-<?php echo md5( $ticket->id ); ?>">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <img src="<?php echo attachments_uploads( html_escape( $ticket->attachment ) ); ?>" class="img-fluid align-img-center" alt="Attachment">
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'close' ); ?>
          </a>
        </div>
        <!-- /.modal-footer -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<?php } ?>

<?php if ( ! empty( $replies ) ) {
  foreach ( $replies as $reply ) {
    if ( is_image_file( $reply->attachment ) ) { ?>
  <div class="modal" id="view-attachment-<?php echo md5( $reply->id ); ?>">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <img src="<?php echo attachments_uploads( html_escape( $reply->attachment ) ); ?>" class="img-fluid align-img-center" alt="Attachment">
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'close' ); ?>
          </a>
        </div>
        <!-- /.modal-footer -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<?php }
  }
} ?>