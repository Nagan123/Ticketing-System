<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-posts container mt-5 extra-height-2">
  <div class="row mb-4">
    <div class="col">
      <div class="float-lg-start mb-2 mb-lg-0">
        <h2 class="h4 fw-bold mb-2"><?php printf( lang( 'search_results_for' ), $searched ); ?></h2>
        <span class="small text-muted"><i class="fas fa-search me-1"></i> <?php printf( lang( 'found_articles' ), $found_count ); ?></span>
      </div>
      <div class="float-lg-end">
        <form class="search-form posts" action="<?php echo env_url( 'search' ); ?>">
          <div class="input-group align-items-center">
            <input type="search" class="form-control" name="query" placeholder="<?php echo lang( 'search_articles' ); ?>"  value="<?php echo html_escape( $searched ); ?>" required>
            <button class="btn btn-sub btn-wide"><i class="fas fa-search"></i></button>
          </div>
          <!-- /.input-group -->
        </form>
      </div>
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
  <div class="row row-main">
    <?php load_view( 'home/support/articles_block',  ['display_category' => true] ); ?>
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col">
      <div class="clearfix pagination-wrapper"><?php echo $pagination; ?></div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->

<?php load_view( 'home/still_no_luck' ); ?>