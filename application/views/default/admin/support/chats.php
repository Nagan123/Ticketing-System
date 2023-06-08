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
          <div class="card-header d-flex align-items-center border-bottom-0">
            <h3 class="card-title"><?php echo lang( 'search_chats' ); ?></h3>
            <div class="card-tools ml-auto">
              <form action="<?php echo env_url( 'admin/chats/' . html_escape( $this->uri->segment( 3 ) ) ); ?>" class="d-inline-block form-inline mr-2">
                <input
                  class="form-control text-sm search-field mr-1 mb-2 mb-sm-0"
                  name="search"
                  type="search"
                  value="<?php echo do_secure( get( 'search' ) ); ?>"
                  placeholder="<?php echo lang( 'subject_or_id' ); ?>"
                  aria-label="Search">
                <select class="form-control text-sm search-field mr-1 mb-2 mb-sm-0" name="reply_status">
                  <option value=""><?php echo lang( 'any_reply_status' ); ?></option>
                  <option value="1" <?php echo select_get_reply_status( '1' ); ?>><?php echo lang( 'unanswered' ); ?></option>
                  <option value="2" <?php echo select_get_reply_status( '2' ); ?>><?php echo lang( 'replied' ); ?></option>
                </select>
                <button class="btn btn-primary text-sm btn-user-search" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php echo html_escape( $card_title ); ?></h3>
            
            <p class="ml-2 text-muted float-left text-sm">
              <?php
              if ( $assigned === true )
              {
                  echo lang( 'assigned_chats_msg' );
              }
              else if ( ! $this->zuser->has_permission( 'all_chats' ) )
              {
                  echo lang( 'c_assigned_to_dptmt_msg' );
              }
              ?>
            </p>
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
                              <?php if ( $chat->is_read_assigned == 0 && ( $chat->assigned_to == $this->zuser->get( 'id' ) && $assigned === true ) ) { ?>
                                <span class="badge badge-danger mr-1"><?php echo lang( 'newly_assigned' ); ?></span>
                              <?php } ?>
                              
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