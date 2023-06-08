<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-posts container mt-5 extra-height-2">
  <div class="row mb-4">
    <div class="col">
      <h2 class="h4 fw-bold mb-0"><?php echo lang( 'announcements' ); ?></h2>
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
  <div class="row row-main">
    <div class="col">
      <?php if ( ! empty( $announcements ) ) {
        foreach ( $announcements as $announcement ) { ?>
        <div class="post shadow-sm">
          <div class="clearfix">
            <p class="h5 fw-bold"><?php echo html_escape( $announcement->subject ); ?></p>
          </div>
          <span class="d-inline-block small me-2">
            <i class="far fa-clock"></i> <?php echo get_date_time_by_timezone( html_escape( $announcement->created_at ) ); ?>
          </span>
          
          <p class="text-muted mt-1 mb-0"><?php echo nl2br( get_sized_text( html_escape( $announcement->announcement ), 345, true ) ); ?></p>
          
          <?php if ( is_increased_length( $announcement->announcement, 345 ) ) { ?>
            <a class="mt-3 d-inline-block" href="<?php echo env_url( 'user/tools/announcement/' . html_escape( $announcement->id ) ); ?>">
              <?php echo lang( 'read_more' ); ?> <i class="ms-1 fas fa-angle-right"></i>
            </a>
          <?php } ?>
          
        </div>
        <!-- /.post -->
      <?php }
      } else { ?>
        <div class="text-center shadow-sm">
          <img class="not-found mt-2 mb-4" src="<?php illustration_by_color( 'not_found' ); ?>" alt="">
          <h2 class="h4 fw-bold"><?php echo lang( 'no_records_found' ); ?></h2>
        </div>
      <?php } ?>
    </div>
    <!-- /col -->
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