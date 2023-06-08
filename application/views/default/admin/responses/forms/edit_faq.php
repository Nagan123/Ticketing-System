<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<form class="z-form" action="<?php admin_action( 'support/update_faq' ); ?>" method="post">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo lang( 'edit_faq' ); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <!-- /.modal-header -->
  <div class="modal-body">
    <div class="response-message"></div>
    <div class="form-group">
      <label for="question-edit"><?php echo lang( 'question' ); ?> <span class="required">*</span></label>
      <input type="text" class="form-control" id="question-edit" name="question" value="<?php echo html_escape( $question ); ?>" required>
    </div>
    <!-- /.form-group -->
    <div class="form-group">
      <label for="answer-edit"><?php echo lang( 'answer' ); ?> <span class="required">*</span></label>
      <textarea class="form-control" id="answer-edit" name="answer" rows="5" required><?php echo html_escape( $answer ); ?></textarea>
    </div>
    <!-- /.form-group -->
    <div class="form-group">
      <label for="category-edit"><?php echo lang( 'category' ); ?> <span class="required">*</span></label>
      <select class="form-control select2 search-disabled" id="category-edit" data-placeholder="<?php echo lang( 'select_category' ); ?>" name="category" required>
        <option></option>
        
        <?php if ( ! empty( $categories = get_faqs_categories( 'ASC' ) ) ) {
          foreach ( $categories as $category ) { ?>
          <option value="<?php echo html_escape( $category->id ); ?>" <?php echo select_single( $category->id, $category_id ); ?>><?php echo html_escape( $category->name ); ?></option>
        <?php }
        } ?>
      </select>
    </div>
    <!-- /.form-group -->
    <label for="visibility-edit"><?php echo lang( 'visibility' ); ?></label>
    <select class="form-control select2 search-disabled" id="visibility-edit" name="visibility">
      <option value="1" <?php echo select_single( 1, $visibility ); ?>><?php echo lang( 'public' ); ?></option>
      <option value="0" <?php echo select_single( 0, $visibility ); ?>><?php echo lang( 'hidden' ); ?></option>
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