<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php echo lang( 'ticket_history' ); ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0 pb-0 records-card-body">
            <div class="table-responsive">
              <table class="custom-table table table-striped text-nowrap table-valign-middle mb-0">
                <thead>
                  <tr>
                    <th class="th-2"><?php echo lang( 'activity' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'performed' ); ?></th>
                  </tr>
                </thead>
                <tbody class="text-sm">
                  <?php
                  if ( ! empty( $history ) )
                  {
                    foreach ( $history as $data ) { ?>
                      <tr>
                        <td>
                          <?php
                          if ( ! empty( $data->user_id ) )
                          {
                              printf( lang( html_escape( $data->message_key ) ), $data->username );
                          }
                          else
                          {
                              echo lang( html_escape( $data->message_key ) );
                          }
                          ?>
                        </td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $data->created_at ) ); ?></td>
                      </tr>
                      <?php }
                    } else {
                  ?>
                    <tr>
                      <td colspan="2"><?php echo lang( 'no_records_found' ); ?></td>
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