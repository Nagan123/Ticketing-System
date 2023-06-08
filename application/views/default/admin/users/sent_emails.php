<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="not-in-form">
          <div class="response-message"></div>
        </div>
        <!-- /.not-in-form -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php printf( lang( 'user_sent_emails' ), html_escape( $user_email_address ) ); ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0 pb-0 records-card-body">
            <div class="table-responsive">
              <table class="custom-table z-table table table-striped text-nowrap table-valign-middle mb-0">
                <thead class="records-thead">
                  <tr>
                    <th class="th-1"><?php echo lang( 'id' ); ?></th>
                    <th class="th-2"><?php echo lang( 'subject' ); ?></th>
                    <th><?php echo lang( 'message' ); ?></th>
                    <th class="text-right"><?php echo lang( 'sender' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'sent' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'action' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $sent_emails ) )
                  {
                    foreach ( $sent_emails as $sent_email ) {
                      $id = $sent_email->id; ?>
                      <tr id="record-<?php echo html_escape( $id ); ?>">
                        <td><?php echo html_escape( $id ); ?></td>
                        <td><?php echo html_escape( $sent_email->subject ); ?></td>
                        <td>
                          <?php echo short_text( strip_tags( $sent_email->message ) ); ?>
                          
                          <?php if ( is_increased_short_text( $sent_email->message ) ) { ?>
                            <span class="badge badge-success get-data-tool" data-source="<?php admin_action( 'users/sent_email' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
                              <?php echo lang( 'read_more' ); ?>
                            </span>
                          <?php } ?>
                        </td>
                        <td class="text-right">
                          <?php
                          if ( ! empty( $sent_email->first_name ) )
                          {
                              echo '<a href="' . env_url( 'admin/users/edit_user/' . html_escape( $sent_email->sent_by ) ) . '" target="_blank">';
                              echo html_escape( $sent_email->first_name . ' ' . $sent_email->last_name );
                              echo '</a>';
                          }
                          else
                          {
                              echo lang( 'user_deleted' );
                          }
                          ?>
                        </td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $sent_email->sent_at ) ); ?></td>
                        <td class="text-right">
                          <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
                            <i class="fas fa-trash tool-c"></i>
                          </button>
                        </td>
                      </tr>
                      <?php }
                    } else {
                  ?>
                    <tr id="record-0">
                      <td colspan="6"><?php echo lang( 'no_records_found' ); ?></td>
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

<?php load_modals( ['read', 'delete'] ); ?>