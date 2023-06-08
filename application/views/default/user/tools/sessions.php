<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="response-message"><?php echo alert_message(); ?></div>

<div class="z-list extra-height-1 container my-5">
  <div class="row mb-4">
    <div class="col">
      <div class="float-lg-start mb-2 mb-lg-0">
        <h2 class="h4 fw-bold mb-0"><?php echo lang( 'manage_sessions' ); ?></h2>
      </div>
      <?php if ( ! empty( $sessions ) ) {
       if ( $count > 1 ) { ?>
        <div class="float-lg-end">
          <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#logout-others">
            <small><i class="fas fa-minus-circle me-2"></i> <?php echo lang( 'logout_my_others' ); ?></small>
          </button>
        </div>
      <?php }
      } ?>
    </div>
    <!-- /col -->
  </div>
  <div class="shadow-sm z-card">
    <div class="row">
      <div class="col">
        <?php
        if ( ! empty( $sessions ) )
        {
          foreach ( $sessions as $session ) { ?>
            <div class="list-item" id="record-<?php echo html_escape( $session->id ); ?>">
              <div class="row">
                <div class="col-lg-9 ">
                  <p class="mb-0 fw-bold">
                    <?php echo ( ! empty( $session->platform ) ) ? html_escape( $session->platform ) : lang( 'unknown' ); ?>
                    
                    <?php if ( $session->token == get_session( USER_TOKEN ) && $count > 1 ) { ?>
                      <strong class="text-primary">(<?php echo lang( 'current_device' ); ?>)</strong>
                    <?php } ?>
                  </p>
                  <span class="text-secondary small basic-info mt-2">
                    <?php echo ( ! empty( $session->browser ) ) ? html_escape( $session->browser ) : lang( 'unknown' ); ?> &mdash;
                    <strong><?php echo lang( 'last_activity' ); ?>:</strong> 
                    <?php
                    if ( ! empty( $session->last_activity ) )
                    {
                        echo get_date_time_by_timezone( html_escape( $session->last_activity ) );
                    }
                    else
                    {
                        echo lang( 'n_a' );
                    }
                    ?>
                  </span>
                </div>
                <!-- /col -->
                <div class="col-lg-3 align-self-center clearfix">
                  <button class="btn btn-danger float-lg-end mt-3 mt-lg-0 tool" data-id="<?php echo html_escape( $session->id ); ?>" data-bs-toggle="modal" data-bs-target="#delete">
                    <i class="fas fa-trash tool-c"></i>
                  </button>
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

<?php load_modals( ['user/delete_user_session', 'user/logout_my_others'] ); ?>