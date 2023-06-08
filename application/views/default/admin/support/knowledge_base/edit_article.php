<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <form class="z-form" action="<?php admin_action( 'support/update_article' ); ?>" method="post" data-csrf="manual">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <div class="row">
        <div class="col">
          <div class="response-message"><?php echo alert_message(); ?></div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xl-9">
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'edit_article' ); ?></h3>
              
              <div class="card-tools ml-auto">
                <a href="<?php echo env_url( get_kb_article_slug( html_escape( $article->slug ) ) ); ?>" class="btn text-sm btn-dark" target="_blank">
                  <span class="fas fa-eye mr-2"></span> <?php echo lang( 'view_article' ); ?>
                </a>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="title"><?php echo lang( 'title' ); ?> <span class="required">*</span></label>
                  <input type="text" id="title" class="form-control" name="title" value="<?php echo html_escape( $article->title ); ?>" required>
                </div>
                <!-- /.form-group -->
                <div class="form-group col-md-6">
                  <label for="slug">
                    <?php echo lang( 'slug' ); ?>
                    <i class="fas fa-info-circle text-sm" data-toggle="tooltip" title="<?php echo lang( 'slug_tip' ); ?>"></i>
                  </label>
                  <input type="text" class="form-control" id="slug" name="slug" value="<?php echo html_escape( $article->slug ); ?>">
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.form-row -->
              <div class="form-group">
                <label for="textarea"><?php echo lang( 'content' ); ?> <span class="required">*</span></label>
                <textarea class="form-control textarea" id="textarea" name="content"><?php echo html_escape( do_secure( $article->content, true ) ); ?></textarea>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="meta-keywords"><?php echo lang( 'meta_keywords' ); ?></label>
                <input type="text" class="form-control" id="meta-keywords" name="meta_keywords" value="<?php echo html_escape( $article->meta_keywords ); ?>">
              </div>
              <!-- /.form-group -->
              <label for="meta-description"><?php echo lang( 'meta_description' ); ?></label>
              <textarea class="form-control" id="meta-description" name="meta_description" rows="2"><?php echo html_escape( $article->meta_description ); ?></textarea>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3">
          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title"><?php echo lang( 'article_statistics' ); ?></h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item">
                  <span>
                    <strong><?php echo lang( 'helpful' ); ?>:</strong>
                    <?php echo html_escape( $article->helpful ); ?>
                  </span>
                </li>
                <li class="list-group-item">
                  <span>
                    <strong><?php echo lang( 'not_helpful' ); ?>:</strong>
                    <?php echo html_escape( $article->not_helpful ); ?>
                  </span>
                </li>
                <li class="list-group-item">
                  <span>
                    <strong><?php echo lang( 'views' ); ?>:</strong>
                    <?php echo html_escape( $article->views ); ?>
                  </span>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo lang( 'action' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="submit" class="btn btn-primary btn-block text-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'update' ); ?>
              </button>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo lang( 'visibility' ); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="icheck icheck-primary d-inline-block mr-2">
                <input type="radio" name="visibility" id="visibility-1" value="1" <?php echo check_single( 1, $article->visibility ); ?>>
                <label for="visibility-1"><?php echo lang( 'public' ); ?></label>
              </div>
              <!-- /.icheck -->
              <div class="icheck icheck-primary d-inline-block">
                <input type="radio" name="visibility" id="visibility-0" value="0" <?php echo check_single( 0, $article->visibility ); ?>>
                <label for="visibility-0"><?php echo lang( 'hidden' ); ?></label>
              </div>
              <!-- /.icheck -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo lang( 'category' ); ?> <span class="required">*</span></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <select class="form-control select2 search-disabled" id="category" data-placeholder="<?php echo lang( 'select_category' ); ?>" name="category" required>
              <option></option>
              
              <?php if ( ! empty( $categories = get_articles_categories() ) ) {
                foreach ( $categories as $category ) { ?>
                <option
                  value="<?php echo html_escape( $category->id ); ?>"
                  <?php echo select_single( $category->id, $article->category_id ); ?>>
                  <?php echo html_escape( $category->name ); ?>
                </option>
                
                <?php if ( ! empty( $subcategories = get_articles_subcategories( $category->id ) ) ) {
                  foreach ( $subcategories as $subcategory ) { ?>
                  <option
                    value="<?php echo html_escape( $subcategory->id ); ?>"
                    <?php echo select_single( $subcategory->id, $article->category_id ); ?>>
                    &mdash; <?php echo html_escape( $subcategory->name ); ?>
                  </option>
                <?php }
                } ?>
                
              <?php }
              } ?>
            </select>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <input type="hidden" name="id" value="<?php echo html_escape( $article->id ); ?>">
    </form>
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->