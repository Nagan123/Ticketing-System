<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Add Articles Subcategory Modal: -->
<div class="modal close-after" id="add-articles-subcategory">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'support/add_articles_category/sub' ); ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo lang( 'add_subcategory' ); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- /.modal-header -->
        <div class="modal-body">
          <div class="response-message"></div>
          <div class="form-row">
            <div class="col-md-6 form-group">
              <label for="category-add"><?php echo lang( 'category' ); ?> <span class="required">*</span></label>
              <input type="text" class="form-control" id="category-add" name="category" required>
            </div>
            <!-- /.col -->
            <div class="col-md-6 form-group">
              <label for="slug-add">
                <?php echo lang( 'slug' ); ?>
                <i class="fas fa-info-circle text-sm" data-toggle="tooltip" title="<?php echo lang( 'slug_tip' ); ?>"></i>
              </label>
              <input type="text" class="form-control" id="slug-add" name="slug">
            </div>
            <!-- /.col -->
          </div>
          <!-- /.form-row -->
          <div class="form-group">
            <label for="parent-category-add"><?php echo lang( 'parent_category' ); ?> <span class="required">*</span></label>
            <select class="form-control select2 search-disabled" id="parent-category-add" data-placeholder="<?php echo lang( 'select_category' ); ?>" name="parent_category" required>
              <option></option>
              
              <?php if ( ! empty( $categories = get_articles_categories() ) ) {
                foreach ( $categories as $category ) { ?>
                <option value="<?php echo html_escape( $category->id ); ?>"><?php echo html_escape( $category->name ); ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <label for="meta-keywords-add"><?php echo lang( 'meta_keywords' ); ?></label>
            <input type="text" class="form-control" id="meta-keywords-add" name="meta_keywords">
          </div>
          <!-- /.form-group -->
          <label for="meta-description-add"><?php echo lang( 'meta_description' ); ?></label>
          <textarea class="form-control" id="meta-description-add" name="meta_description" rows="4"></textarea>
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