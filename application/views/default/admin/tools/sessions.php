<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="not-in-form">
          <div class="response-message"><?php echo alert_message(); ?></div>
        </div>
        <!-- /.not-in-form -->
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"><?php echo lang( 'sessions' ); ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0 pb-0 records-card-body">
            <div class="table-responsive">
              <table class="custom-table z-table table table-striped text-nowrap table-valign-middle mb-0">
                <thead class="records-thead">
                  <tr>
                    <th class="th-1"><?php echo lang( 'user_agent' ); ?></th>
                    <th><?php echo lang( 'user' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'ip_address' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'last_activity' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'logged_in' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'action' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $sessions ) )
                  {
                    foreach ( $sessions as $session ) { ?>
                      <tr id="record-<?php echo html_escape( $session->id ); ?>">
                        <td>
                          <h5><?php echo ( ! empty( $session->platform ) ) ? html_escape( $session->platform ) : lang( 'unknown' ); ?></h5>
                          <?php echo ( ! empty( $session->browser ) ) ? html_escape( $session->browser ) : lang( 'unknown' ); ?>
                          
                          <?php if ( $session->token == get_session( USER_TOKEN ) && count( $sessions ) > 1 ) { ?>
                            <strong class="text-primary">(<?php echo lang( 'current_device' ); ?>)</strong>
                          <?php } ?>
                        </td>
                        <td>
                          <?php
                          if ( ! empty( $session->user_id ) )
                          {
                              echo '<a href="' . env_url( 'admin/users/edit_user/' . html_escape( $session->user_id ) ) . '" target="_blank">';
                              echo html_escape( $session->first_name . ' ' . $session->last_name );
                              echo '</a>';
                          }
                          else
                          {
                              echo lang( 'guest' );
                          }
                          ?>
                        </td>
                        <td class="text-right">
                          <?php echo html_escape( $session->ip_address ); ?>

                          <?php if ( db_config( 'ipinfo_token' ) !== '' ) { ?>
                            <span class="ml-1 badge badge-success get-data-tool" data-source="<?php admin_action( 'tools/ip_geolocation' ); ?>" data-id="<?php echo html_escape( $session->ip_address ); ?>">
                              <?php echo lang( 'geolocation_data' ); ?>
                            </span>
                          <?php } ?>
                        </td>
                        <td class="text-right">
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
                          
                          <span class="text-secondary d-block">
                            <?php
                            if ( ! empty( $session->last_location ) )
                            {
                                echo html_escape( $session->last_location );
                            }
                            else
                            {
                                echo lang( 'main_website' );
                            }
                            ?>
                          </span>
                        </td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $session->logged_in_at ) ); ?></td>
                        <td class="text-right">
                          <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $session->id ); ?>" data-toggle="modal" data-target="#delete">
                            <i class="fas fa-trash tool-c"></i>
                          </button>
                        </td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
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

<?php load_modals( ['admin/delete_user_session', 'read_lg'] ); ?>