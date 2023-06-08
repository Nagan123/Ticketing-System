<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="response-message"><?php echo alert_message(); ?></div>

<div class="z-list extra-height-1 container my-5">
  <div class="row mb-4">
    <div class="col">
      <div class="float-lg-start mb-2 mb-lg-0">
        <h2 class="h4 fw-bold mb-0"><?php echo lang( 'notifications' ); ?></h2>
      </div>
      
      <?php if ( $unread_notifications && $unread_notifications > 1 ) { ?>
        <div class="float-lg-end">
          <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#mark-all-as-read">
            <small><i class="fas fa-check-circle me-2"></i> <?php echo lang( 'mark_all_as_read' ); ?></small>
          </button>
        </div>
      <?php } ?>
      
    </div>
    <!-- /col -->
  </div>
  <div class="shadow-sm">
    <div class="row">
      <div class="col">
        <?php
        if ( ! empty( $notifications ) )
        {
          foreach ( $notifications as $notify ) {
            $togo = ( $notify->is_read == 1 ) ? $notify->location : "user/read_notification/{$notify->id}"; ?>
            <div class="list-item">
              <div class="row">
                <div class="col-lg-9 ">
                  <p class="mb-1">
                    <?php echo lang( html_escape( $notify->message_key ) ); ?>
                    
                    <?php if ( $notify->is_read == 0 ) { ?>
                      <span class="ml-1 badge bg-danger"><?php echo lang( 'unread' ); ?></span>
                    <?php } ?>
                  </p>
                  <span class="text-secondary small basic-info mt-2"><i class="far fa-clock"></i> <?php echo get_date_time_by_timezone( html_escape( $notify->created_at ) ); ?></span>
                </div>
                <!-- /col -->
                <div class="col-lg-3 align-self-center clearfix">
                  <a href="<?php echo env_url( $togo ); ?>" class="btn btn-sub float-lg-end mt-3 mt-lg-0"><i class="far fa-eye"></i></a>
                </div>
                <!-- /col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.list-item -->
            <?php }
          } else {
        ?>
          <div class="list-item">
            <div class="row">
              <div class="col">
                <div class="text-center">
                  <img class="not-found mt-2 mb-4" src="<?php illustration_by_color( 'not_found' ); ?>" alt="">
                  <h2 class="h4 fw-bold"><?php echo lang( 'no_records_found' ); ?></h2>
                </div>
              </div>
              <!-- /col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.list-item -->
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
</div>
<!-- /.container -->

<?php load_modals( ['user/mark_all_as_read'] ); ?>