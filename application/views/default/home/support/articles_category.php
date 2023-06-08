<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-posts container mt-5 extra-height-2">
  <div class="row mb-4">
    <div class="col">
      <?php load_view( 'home/support/breadcrumb', ['name' => $category->name, 'slug' => $category->slug, 'parent_id' => $category->parent_id] ); ?>
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
  <div class="row row-main">
    <?php load_view( 'home/support/articles_block' ); ?>
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