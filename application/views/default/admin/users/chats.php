<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-spinner"></i></span>
          <div class="info-box-content">
            <span class="info-box-text"><?php echo lang( 'active_chats' ); ?></span>
            <span class="info-box-number"><?php echo html_escape( $active_chats ); ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text"><?php echo lang( 'ended_chats' ); ?></span>
            <span class="info-box-number"><?php echo html_escape( $ended_chats ); ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- Fix for Small Devices Only: -->
      <div class="clearfix hidden-md-up"></div>
      
      <div class="col-12 col-md-4">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-list-ul"></i></span>
          <div class="info-box-content">
            <span class="info-box-text"><?php echo lang( 'all_chats' ); ?></span>
            <span class="info-box-number"><?php echo html_escape( $all_chats ); ?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php printf( lang( 'user_chats' ), html_escape( $user_email_address ) ); ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0 pb-0 records-card-body">
            <div class="table-responsive">
              <table class="custom-table table z-table table-striped text-nowrap table-valign-middle mb-0">
                <thead class="records-thead">
                  <tr>
                    <th class="th-1"><?php echo lang( 'id' ); ?></th>
                    <th><?php echo lang( 'subject_and_requestor' ); ?></th>
                    <th class="text-right"><?php echo lang( 'assigned_to' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'reply_status' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'status' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'updated' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'created' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'actions' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $chats ) )
                  {
                    foreach ( $chats as $chat ) { ?>
                      <tr id="record-<?php echo html_escape( $chat->id ); ?>">
                        <td><?php echo html_escape( $chat->id );?></td>
                        <td>
                          <div class="d-inline-block align-top mr-1">
                            <div class="mb-1">
                              <?php if ( $chat->is_read == 0 && $chat->sub_status == 1 && $chat->assigned_to == null ) { ?>
                                <span class="badge badge-danger mr-1"><?php echo lang( 'unread' ); ?></span>
                              <?php } ?>
                            </div>
                            <!-- /.mb-1 -->
                            
                            <a href="<?php echo env_url( 'admin/chats/chat/' . html_escape( $chat->id ) ); ?>">
                              <?php echo get_sized_text( replace_some_with_actuals( html_escape( $chat->subject ) ), 45 );?>
                            </a>
                            
                            <?php if ( is_increased_length( $chat->subject, 45 ) ) { ?>
                              <span class="badge badge-success get-data-tool" data-source="<?php admin_action( 'support/chat_subject' ); ?>" data-id="<?php echo html_escape( $chat->id ); ?>">
                                <?php echo lang( 'read_more' ); ?>
                              </span>
                            <?php } ?>
                            
                            <small class="d-block text-muted">
                            <?php if ( ! empty( $chat->r_first_name ) ) {
                              if ( $this->zuser->has_permission( 'users' ) ) { ?>
                              <a class="text-muted" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $chat->user_id ) ); ?>" target="_blank">
                                <?php echo html_escape( long_to_short_name( $chat->r_first_name . ' ' . $chat->r_last_name ) ); ?>
                              </a>
                            <?php
                            }
                                else
                                {
                                    echo html_escape( long_to_short_name( $chat->r_first_name . ' ' . $chat->r_last_name ) );
                                }
                            }
                            else
                            {
                                echo lang( 'user_deleted' );
                            }
                            ?>
                            </small>
                          </div>
                          <!-- /.d-inline-block -->
                        </td>
                        <td class="text-right">
                          <?php if ( ! empty( $chat->user_picture ) ) { ?>
                            <span class="badge badge-dark">
                              <?php if ( $this->zuser->has_permission( 'users' ) ) { ?>
                                <a class="text-white" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $chat->assigned_to ) ); ?>" target="_blank">
                                  <?php echo html_escape( long_to_short_name( $chat->first_name . ' ' . $chat->last_name ) ); ?>
                                </a>
                              <?php } else { ?>
                                <span><?php echo html_escape( long_to_short_name( $chat->first_name . ' ' . $chat->last_name ) ); ?></span>
                              <?php } ?>
                            </span>
                            <img src="<?php echo user_picture( html_esc_url( $chat->user_picture ) ); ?>" class="ml-2 elevation-1 img-circle profile-pic-sm" alt="User Image">
                          <?php
                          }
                          else if ( empty( $chat->assigned_to ) )
                          {
                              echo lang( 'n_a' );
                          }
                          ?>
                        </td>
                        <td class="text-right">
                          <span class="badge bg-dark">
                            <?php echo manage_chat_sub_status( $chat->sub_status ); ?>
                          </span>
                        </td>
                        <td class="text-right">
                          <span class="badge <?php echo chat_status_color( $chat->status, 'admin' ); ?>">
                            <?php echo manage_chat_status( $chat->status );?>
                          </span>
                        </td>
                        <td class="text-right"><?php manage_updated_at( html_escape( $chat->updated_at ) ); ?></td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $chat->created_at ) ); ?></td>
                        <td class="text-right">
                          <div class="btn-group">
                            <a href="<?php echo env_url( 'admin/chats/chat/' . html_escape( $chat->id ) ); ?>" class="btn btn-primary btn-sm">
                              <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $chat->id ); ?>" data-toggle="modal" data-target="#delete">
                              <i class="fas fa-trash tool-c"></i>
                            </button>
                          </div>
                          <!-- /.btn-group -->
                        </td>
                      </tr>
                      <?php }
                    } else {
                  ?>
                    <tr id="record-0">
                      <td colspan="8"><?php echo lang( 'no_records_found' ); ?></td>
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