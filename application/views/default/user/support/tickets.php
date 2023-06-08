<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="response-message no-radius"><?php echo alert_message(); ?></div>

<div class="z-listing-tickets bordered extra-height-1 container my-5">
  <div class="row mb-4">
    <div class="col">
      <div class="float-lg-start mb-2 mb-lg-0">
        <h2 class="h4 fw-bold mb-0"><?php echo lang( 'tickets' ); ?></h2>
      </div>
      <div class="float-lg-end">
        <form class="search-form" action="<?php echo env_url( 'user/support/tickets/' . html_escape( $this->uri->segment( 4 ) ) ); ?>">
          <div class="input-group align-items-center">
            <input type="search" class="form-control" name="search" placeholder="<?php echo lang( 'search' ); ?>"  value="<?php echo html_escape( $searched ); ?>" required>
            <button class="btn btn-sub btn-wide"><i class="fas fa-search"></i></button>
          </div>
          <!-- /.input-group -->
        </form>
      </div>
    </div>
    <!-- /col -->
  </div>
  <div class="shadow-sm">
    <div class="z-tabs row">
      <div class="col">
        <ul class="nav nav-pills nav-fill">
          <li class="nav-item">
            <a class="nav-link <?php echo activate_page( 'all', 'user', 4 ); ?>" href="<?php echo env_url( 'user/support/tickets/all' ); ?>"><?php echo lang( 'all' ); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo activate_page( 'opened', 'user', 4 ); ?>" href="<?php echo env_url( 'user/support/tickets/opened' ); ?>"><?php echo lang( 'opened' ); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo activate_page( 'closed', 'user', 4 ); ?>" href="<?php echo env_url( 'user/support/tickets/closed' ); ?>"><?php echo lang( 'closed' ); ?></a>
          </li>
        </ul>
      </div>
      <!-- /col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col">
        
        <?php
        if ( ! empty( $tickets ) )
        {
          foreach ( $tickets as $ticket ) { ?>
            <div class="list-item">
              <div class="row">
                <div class="col-lg-1 ps-lg-3 pe-lg-1 align-self-center">
                  <h3 class="h5 mb-lg-0 rounded text-center bg-sub text-white py-2 fw-bold"><?php echo ticket_replies_count( $ticket->id ); ?></h3>
                </div>
                <!-- /col -->
                <div class="col-lg-8">
                  <p class="h5 mb-2 mb-lg-1 fw-bold">
                    <a href="<?php echo env_url( 'user/support/ticket/' . html_escape( $ticket->id ) ); ?>"><?php echo replace_some_with_actuals( html_escape( $ticket->subject ) );?></a>
                    
                    <?php if ( $ticket->is_read == 0 && ( $ticket->sub_status == 2 || ( $ticket->sub_status == 3 && $ticket->last_reply_area != 2 ) ) ) { ?>
                      <span class="ms-1 badge bg-danger"><?php echo lang( 'unread' ); ?></span>
                    <?php } ?>
                  </p>
                  <span class="text-secondary me-2 small basic-info"><i class="fas fa-fingerprint"></i> <?php printf( lang( 'request_id' ), html_escape( $ticket->id ) ); ?></span>
                  <span class="text-secondary small basic-info d-block d-sm-inline-block">
                    <i class="far fa-clock"></i>
                    <?php echo lang( 'last_activity' ); ?>:
                    <?php
                    if ( ! empty( $ticket->updated_at ) )
                    {
                        $time = $ticket->updated_at;
                    }
                    else
                    {
                        $time = $ticket->created_at;
                    }
                    
                    echo get_date_time_by_timezone( html_escape( $time ) );
                    ?>
                  </span>
                </div>
                <!-- /col -->
                <div class="col-lg-3">
                  <div class="float-lg-end mt-2 mt-lg-0 text-lg-end">
                    <span class="badge <?php echo ticket_sub_status_color( $ticket->sub_status ); ?>"><?php echo manage_ticket_sub_status( $ticket->sub_status ); ?></span>
                    
                    <?php if ( $page_all === true ) { ?>
                      <div>
                        <span class="mt-1 badge <?php echo ticket_status_color( $ticket->status ); ?>"><?php echo manage_ticket_status( $ticket->status ); ?></span>
                      </div>
                    <?php } ?>
                  </div>
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