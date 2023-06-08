<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="response-message"><?php echo alert_message(); ?></div>
        <div class="card">
          <div class="card-header border-bottom-0 d-flex align-items-center">
            <h3 class="card-title"><?php echo lang( 'notifications' ); ?></h3>
            
            <?php if ( $unread_notifications && $unread_notifications > 1 ) { ?>
              <div class="card-tools ml-auto">
                <button class="btn btn-danger text-sm" data-toggle="modal" data-target="#mark-all-as-read">
                  <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'mark_all_as_read' ); ?>
                </button>
              </div>
              <!-- /.card-tools -->
            <?php } ?>
            
          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0 pb-0 records-card-body">
            <div class="table-responsive">
              <table class="custom-table table text-nowrap table-valign-middle mb-0">
                <tbody class="text-sm">
                  <?php
                  if ( ! empty( $notifications ) )
                  {
                    foreach ( $notifications as $notify ) {
                      $togo = ( $notify->is_read == 1 ) ? $notify->location : "admin/read_notification/{$notify->id}"; ?>
                      <tr class="<?php echo ( $notify->is_read == 0 ) ? 'bg-light' : ''; ?>">
                        <td class="th-2"><?php echo get_date_time_by_timezone( html_escape( $notify->created_at ) ); ?></td>
                        <td>
                          <?php echo lang( html_escape( $notify->message_key ) ); ?>
                          
                          <?php if ( $notify->is_read == 0 ) { ?>
                            <span class="ml-1 badge badge-danger"><?php echo lang( 'unread' ); ?></span>
                          <?php } ?>
                        </td>
                        <td class="text-right">
                          <a href="<?php echo env_url( $togo ); ?>" class="btn btn-sm btn-info">
                            <span class="fas fa-eye"></span>
                          </a>
                        </td>
                      </tr>
                      <?php }
                    } else {
                  ?>
                    <tr>
                      <td><?php echo lang( 'no_notifications' ); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
            
            <div class="clearfix"><?php echo $pagination; ?></div>
            
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php load_modals( ['admin/mark_all_as_read'] ); ?>