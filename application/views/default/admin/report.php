<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!DOCTYPE html>
<html>

<body>

<div class="main-wrapper">
  <div class="section-1">
    <div class="col-left">
      <h2 class="main-title"><?php echo html_escape( db_config( 'site_name' ) ); ?></h2>
      <span class="break margin-bottom-1">
        <strong><?php echo lang( 'report_number' ); ?>:</strong>
        <?php echo sprintf( '%06d', html_escape( $id ) ); ?>
      </span>
      <span class="break margin-bottom-1">
        <strong><?php echo lang( 'generated' ); ?>:</strong>
        <?php echo get_date_time_by_timezone( html_escape( $generated_at ) ); ?>
      </span>
      <span>
        <strong><?php echo lang( 'period' ); ?>:</strong>
        <?php echo lang( html_escape( $period ) ); ?>
      </span>
    </div>
    <!-- /.col-left -->
    <div class="col-right">
      <h3 class="status"><?php echo lang( 'report' ); ?></h3>
    </div>
    <!-- /.col-right -->
  </div>
  <!-- /.section-1 -->
  <div class="section-2">
    <div class="header">
      <div class="col-left">
        <strong><?php echo lang( 'type' ); ?></strong>
      </div>
      <!-- /.col-left -->
      <div class="col-right">
        <strong><?php echo lang( 'count' ); ?></strong>
      </div>
      <!-- /.col-right -->
    </div>
    <!-- /.header -->
    <div class="body">
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'opened_tickets' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $opened_tickets ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'closed_tickets' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $closed_tickets ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'solved_tickets' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $solved_tickets ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'total_tickets' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $total_tickets ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'active_chats' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $active_chats ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'ended_chats' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $ended_chats ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'total_chats' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $total_chats ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-left">
          <span><?php echo lang( 'registered_users' ); ?></span>
        </div>
        <!-- /.col-left -->
        <div class="col-right text-right">
          <span><?php echo html_escape( $users ); ?></span>
        </div>
        <!-- /.col-right -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.body -->
  </div>
  <!-- /.section-2 -->
</div>
<!-- /.main-wrapper -->

</body>

</html>