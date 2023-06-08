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
            <h3 class="card-title"><?php echo lang( 'search_tickets' ); ?></h3>
            <div class="card-tools ml-auto">
              <form action="<?php echo env_url( 'admin/tickets/' . html_escape( $this->uri->segment( 3 ) ) ); ?>" class="d-inline-block form-inline mr-2">
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
                  <option value="3" <?php echo select_get_reply_status( '3' ); ?>><?php echo lang( 'solved' ); ?></option>
                  <option value="4" <?php echo select_get_reply_status( '4' ); ?>><?php echo lang( 'awaiting_user_reply' ); ?></option>
                </select>
                <select class="form-control text-sm search-field mr-1 mb-2 mb-sm-0" name="priority">
                  <option value=""><?php echo lang( 'all_priorities' ); ?></option>
                  <option value="low" <?php echo select_get_priority( 'low' ); ?>><?php echo lang( 'low' ); ?></option>
                  <option value="medium" <?php echo select_get_priority( 'medium' ); ?>><?php echo lang( 'medium' ); ?></option>
                  <option value="high" <?php echo select_get_priority( 'high' ); ?>><?php echo lang( 'high' ); ?></option>
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
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"><?php echo html_escape( $card_title ); ?></h3>
            
            <?php if ( $assigned === true || ! $this->zuser->has_permission( 'all_tickets' ) ) { ?>
              <p class="ml-2 text-muted float-left text-sm"><?php echo lang( 'assigned_tickets_msg' ); ?></p>
            <?php } ?>
            
            <?php if ( $this->zuser->has_permission( 'all_tickets' ) ) { ?>
              <div class="card-tools ml-auto">
                <div class="dropdown">
                  <button class="btn btn-success text-sm" type="button" id="create-ticket-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-plus-circle mr-2"></i> <?php echo lang( 'create_ticket' ); ?>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="create-ticket-menu">
                    <a class="dropdown-item text-sm" href="<?php echo env_url( 'admin/tickets/create_ticket?type=unregistered_users' ); ?>">
                      <i class="fas fa-users-slash dropdown-menu-icon"></i> <?php echo lang( 'for_unregistered_users' ); ?>
                    </a>
                    <a class="dropdown-item text-sm" href="<?php echo env_url( 'admin/tickets/create_ticket?type=registered_users' ); ?>">
                      <i class="fas fa-users dropdown-menu-icon"></i> <?php echo lang( 'for_registered_users' ); ?>
                    </a>
                  </div>
                  <!-- /.dropdown-menu -->
                </div>
                <!-- /.dropdown -->
              </div>
              <!-- /.card-tools -->
            <?php } ?>
            
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
                    <th class="text-right th-2"><?php echo lang( 'priority' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'updated' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'created' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'actions' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $tickets ) )
                  {
                    foreach ( $tickets as $ticket ) { ?>
                      <tr id="record-<?php echo html_escape( $ticket->id ); ?>">
                        <td><?php echo html_escape( $ticket->id );?></td>
                        <td>
                          <div class="d-inline-block align-top">
                            <div class="mb-1">
                              <?php if ( $ticket->is_read_assigned == 0 && ( $ticket->assigned_to == $this->zuser->get( 'id' ) && ( $assigned === true || ! $this->zuser->has_permission( 'all_tickets' ) ) ) ) { ?>
                                <span class="badge badge-danger mr-1"><?php echo lang( 'newly_assigned' ); ?></span>
                              <?php } ?>
                              
                              <?php if ( $ticket->is_read == 0 && ( $ticket->sub_status == 1 || ( $ticket->sub_status == 3 && $ticket->last_reply_area != 1 ) ) && ( $ticket->assigned_to == null || $ticket->assigned_to == $this->zuser->get( 'id' ) ) ) { ?>
                                <span class="badge badge-danger mr-1"><?php echo lang( 'unread' ); ?></span>
                              <?php } ?>
                            </div>
                            <!-- /.mb-1 -->
                            
                            <a class="mr-1" href="<?php echo env_url( 'admin/tickets/ticket/' . html_escape( $ticket->id ) ); ?>">
                              <?php echo get_sized_text( replace_some_with_actuals( html_escape( $ticket->subject ) ), 45 );?>
                            </a>
                            
                            <?php if ( is_increased_length( $ticket->subject, 45 ) ) { ?>
                              <span class="badge badge-success get-data-tool" data-source="<?php admin_action( 'support/ticket_subject' ); ?>" data-id="<?php echo html_escape( $ticket->id ); ?>">
                                <?php echo lang( 'read_more' ); ?>
                              </span>
                            <?php } ?>
                            
                            <small class="d-block text-muted">
                            <?php
                            if ( $ticket->user_id !== null )
                            {
                                if ( ! empty( $ticket->r_first_name ) ) { ?>
                                
                                    <?php if ( $this->zuser->has_permission( 'users' ) ) { ?>
                                      <a class="text-muted" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $ticket->user_id ) ); ?>" target="_blank">
                                        <?php echo html_escape( long_to_short_name( $ticket->r_first_name . ' ' . $ticket->r_last_name ) ); ?>
                                      </a>
                                    <?php
                                    }
                                    else
                                    {
                                        echo html_escape( long_to_short_name( $ticket->r_first_name . ' ' . $ticket->r_last_name ) );
                                    }
                                    ?>
                                    
                                <?php }
                                else
                                {
                                    echo lang( 'user_deleted' );
                                }
                            } else { ?>
                              <a class="text-muted" href="mailto:<?php echo html_escape( $ticket->email_address ); ?>">
                                <?php echo lang( 'unregistered' ); ?>
                              </a>
                            <?php } ?>
                            </small>
                          </div>
                          <!-- /.d-inline-block -->
                        </td>
                        <td class="text-right">
                          <?php if ( ! empty( $ticket->user_picture ) ) { ?>
                            <span class="badge badge-dark">
                              <?php if ( $this->zuser->has_permission( 'users' ) ) { ?>
                                <a class="text-white" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $ticket->assigned_to ) ); ?>" target="_blank">
                                  <?php echo html_escape( long_to_short_name( $ticket->first_name . ' ' . $ticket->last_name ) ); ?>
                                </a>
                              <?php } else { ?>
                                <span><?php echo html_escape( long_to_short_name( $ticket->first_name . ' ' . $ticket->last_name ) ); ?></span>
                              <?php } ?>
                            </span>
                            <img src="<?php echo user_picture( html_esc_url( $ticket->user_picture ) ); ?>" class="ml-2 elevation-1 img-circle profile-pic-sm" alt="User Image">
                          <?php
                          }
                          else if ( empty( $ticket->assigned_to ) )
                          {
                              echo lang( 'n_a' );
                          }
                          ?>
                        </td>
                        <td class="text-right">
                          <span class="badge <?php echo ticket_sub_status_color( $ticket->sub_status, 'admin' ); ?>">
                            <?php echo manage_ticket_sub_status( $ticket->sub_status, 'admin' ); ?>
                          </span>
                        </td>
                        <td class="text-right">
                          <span class="badge <?php echo ticket_status_color( $ticket->status, 'admin' ); ?>">
                            <?php echo manage_ticket_status( $ticket->status );?>
                          </span>
                        </td>
                        <td class="text-right">
                          <span class="badge <?php echo ticket_priority_color( $ticket->priority, 'admin' ); ?>"><?php echo lang( html_escape( $ticket->priority ) ); ?></span>
                        </td>
                        <td class="text-right"><?php manage_updated_at( html_escape( $ticket->updated_at ) ); ?></td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $ticket->created_at ) ); ?></td>
                        <td class="text-right">
                          <div class="btn-group">
                            <a href="<?php echo env_url( 'admin/tickets/ticket/' . html_escape( $ticket->id ) ); ?>" class="ml-2 btn btn-primary btn-sm">
                              <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $ticket->id ); ?>" data-toggle="modal" data-target="#delete">
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
                      <td colspan="9"><?php echo lang( 'no_records_found' ); ?></td>
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