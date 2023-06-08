<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="container my-5">
  <div class="row">
    <div class="col">
      <div class="z-page-wrapper shadow-sm">
        <div class="border-bottom pb-2 pb-lg-0 mb-4 clearfix">
          <div class="float-lg-start">
            <h3 class="fw-bold"><?php echo get_page_name( $page->id ); ?></h3>
          </div>
          <?php if ( ! empty( $page->updated_at ) ) { ?>
            <div class="float-lg-end">
              <span class="text-secondary small basic-info">
                <i class="far fa-clock"></i>
                <?php echo lang( 'last_updated' ); ?>: <?php echo get_date_time_by_timezone( html_escape( $page->updated_at ) ); ?>
              </span>
            </div>
          <?php } ?>
        </div>
        <!-- /.clearfix -->
        <div class="page">
          <?php echo strip_extra_html( do_secure( $page->content ) ); ?>
        </div>
        <!-- /.page -->
      </div>
      <!-- /.list-wrapper -->
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->