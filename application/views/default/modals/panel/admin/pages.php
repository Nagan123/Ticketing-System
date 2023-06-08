<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<?php if ( ! empty( $pages ) ) {
  foreach ( $pages as $page ) {
    $id = $page->id; ?>
<div class="modal" id="edit-page-<?php echo html_escape( $id ); ?>">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'pages/update_page' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'edit_page' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="form-group">
            <label for="name-edit-<?php echo html_escape( $id ); ?>"><?php echo lang( 'name' ); ?></label>
            <input type="text" readonly class="form-control-plaintext" id="name-edit-<?php echo html_escape( $id ); ?>" value="<?php echo get_page_name( $id ); ?>">
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label for="textarea-<?php echo html_escape( $id ); ?>"><?php echo lang( 'content' ); ?> <span class="required">*</span></label>
            <textarea class="form-control textarea" id="textarea-<?php echo html_escape( $id ); ?>" name="content"><?php echo html_escape( do_secure( $page->content, true ) ); ?></textarea>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label for="meta-description-edit-<?php echo html_escape( $id ); ?>"><?php echo lang( 'meta_description' ); ?></label>
            <textarea class="form-control" id="meta-description-edit-<?php echo html_escape( $id ); ?>" name="meta_description" rows="2"><?php echo html_escape( $page->meta_description ); ?></textarea>
          </div>
          <!-- /.form-group -->
          <label for="meta-keywords-edit-<?php echo html_escape( $id ); ?>"><?php echo lang( 'meta_keywords' ); ?></label>
          <input type="text" class="form-control" id="meta-keywords-edit-<?php echo html_escape( $id ); ?>" name="meta_keywords" value="<?php echo html_escape( $page->meta_keywords ); ?>">
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
        
        <input type="hidden" name="id" value="<?php echo html_escape( $id ); ?>">
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php }
} ?>