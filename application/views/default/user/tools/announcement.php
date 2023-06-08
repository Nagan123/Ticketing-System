<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-posts container mt-5 extra-height-2">
  <div class="row row-main">
    <div class="col">
      <div class="shadow-sm">
        <?php if ( ! empty( $announcement ) ) { ?>
          <h3 class="fw-bold mb-2"><?php echo html_escape( $announcement->subject ); ?></h3>
          <span class="d-inline-block small me-2">
            <i class="far fa-clock"></i> <?php printf( lang( 'posted_on' ), get_date_time_by_timezone( html_escape( $announcement->created_at ) ) ); ?>
          </span>
          
          <div class="content border-top">
            <div class="content-holder">
              <p class="mb-0"><?php echo nl2br( html_escape( $announcement->announcement ) ); ?></p>
            </div>
            <!-- /.content-holder -->
          </div>
          <!-- /.content -->
        <?php } ?>
      </div>
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->

<?php load_view( 'home/still_no_luck' ); ?>