<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="not-in-form">
          <div class="response-message"><?php echo alert_message(); ?></div>
        </div>
        <!-- /.not-in-form -->
      </div>
      <!-- /col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-8">
        <div class="card z-card">
          <div class="card-body">
            <div class="clearfix">
              <span class="badge badge-primary"><?php printf( lang( 'ticket_no' ), html_escape( $ticket->id ) ); ?></span>
              
              <?php if ( $ticket->user_id == null ) { ?>
                <a class="float-right" href="<?php echo env_url( 'ticket/guest/' . html_escape( $ticket->security_key ) . '/' . html_escape( $ticket->id ) ); ?>" target="_blank">
                  <i class="fas fa-external-link-alt mr-1"></i> <?php echo lang( 'open_guest_view' ); ?>
                </a>
              <?php } ?>
              
            </div>
            <!-- /.clearfix -->
            <h3 class="mt-2"><?php echo replace_some_with_actuals( html_escape( $ticket->subject ) ); ?></h3>
            <p>
              <?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $ticket->message ) ) ) ); ?>
              
              <?php if ( ! empty( $fields ) && is_custom_fields_having_value( $fields ) ) { ?>
                <div class="mt-3">
                  <span class="d-block font-weight-bold"><?php echo lang( 'additional_information' ); ?>:</span>
                  <?php $i = 0;
                    foreach ( $fields as $field )
                    {
                      if ( ! empty( $field->value ) )
                      {
                        $mt_class = ( $i == 0 ) ? 'mt-1' : 'mt-2'; ?>
                    <p class="<?php echo html_escape( $mt_class ); ?>"><span><?php echo html_escape( $field->name ); ?>:</span> <?php echo nl2br( html_escape( $field->value ) ); ?></p>
                  <?php $i++; } } ?>
                </div>
                <!-- /.mt-3 -->
              <?php } ?>
              
              <?php if ( ! empty( $ticket->attachment_name ) ) { ?>
                <span class="mt-3 d-block font-weight-bold"><?php echo lang( 'attachment' ); ?>:</span>
                
                <?php if ( is_image_file( $ticket->attachment ) ) { ?>
                  <img
                    class="shadow mt-2 mb-2 attached-img d-block cursor-pointer"
                    src="<?php echo attachments_uploads( html_escape( $ticket->attachment ) ); ?>"
                    alt="Attachment"
                    data-toggle="modal"
                    data-target="#view-attachment-ticket-<?php echo md5( $ticket->id ); ?>">
                <?php } ?>
                
                <a href="<?php echo attachments_uploads( html_escape( $ticket->attachment ) ); ?>" class="text-primary fs-sm" download>
                  <span data-toggle="tooltip" title="<?php echo html_escape( $ticket->attachment_name ); ?>">
                    <?php printf( lang( 'download' ), html_escape( long_to_short_name( $ticket->attachment_name ) ) ); ?>
                  </span>
                </a>
                
              <?php } ?>
            </p>
            <hr>
            <?php if ( ! empty( $replies ) ) {
              foreach ( $replies as $reply ) { ?>
                <div class="reply-message" id="section-<?php echo md5( $reply->id ); ?>">
                  <div class="replier mb-2">
                    <?php if ( ! empty( $reply->user_picture ) ) { ?>
                      <img src="<?php echo user_picture( html_esc_url( $reply->user_picture ) ); ?>" class="img-circle" alt="User Image">
                      <span class="name"><?php echo html_escape( $reply->first_name . ' ' . $reply->last_name ); ?></span>
                    <?php } else { ?>
                      <img src="<?php echo user_picture( DEFAULT_USER_IMG ); ?>" class="img-circle" alt="User Image">
                      <span class="name"><?php echo ( $reply->user_id == null ) ? lang( 'customer' ) : lang( 'user_deleted' ); ?></span>
                    <?php } ?>
                  </div>
                  <!-- /.replier -->
                  <p class="mb-2">
                    <?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $reply->message ) ) ) ); ?>
                    
                    <?php if ( ! empty( $reply->attachment_name ) ) { ?>
                      <span class="mt-3 d-block"><?php echo lang( 'attachment' ); ?>:</span>
                      
                      <?php if ( is_image_file( $reply->attachment ) ) { ?>
                        <img
                          class="shadow mt-2 mb-2 attached-img d-block cursor-pointer"
                          src="<?php echo attachments_uploads( html_escape( $reply->attachment ) ); ?>"
                          alt="Attachment"
                          data-toggle="modal"
                          data-target="#view-attachment-<?php echo md5( $reply->id ); ?>">
                      <?php } ?>
                      
                      <a href="<?php echo attachments_uploads( html_escape( $reply->attachment ) ); ?>" class="text-primary fs-sm" download>
                        <span data-toggle="tooltip" title="<?php echo html_escape( $reply->attachment_name ); ?>">
                          <?php printf( lang( 'download' ), html_escape( long_to_short_name( $reply->attachment_name ) ) ); ?>
                        </span>
                      </a>
                    <?php } ?>
                  </p>
                  <div class="fs-sm text-secondary mb-4">
                    <p>
                      <i class="nav-icon far fa-clock"></i>
                      
                      <?php
                      if ( ! empty( $reply->updated_at ) )
                      {
                          echo get_date_time_by_timezone( html_escape( $reply->updated_at ) ) . ' <i>' . lang( 'edited_brackets' ) . '</i>';
                      }
                      else
                      {
                          echo get_date_time_by_timezone( html_escape( $reply->replied_at ) );
                      }
                      ?>
                    </p>
                  </div>
                  <!-- /.replied-at -->
                  <div class="btn-group">
                    <button class="btn text-sm btn-primary get-data-tool" data-source="<?php admin_action( 'support/edit_ticket_reply' ); ?>" data-id="<?php echo html_escape( $reply->id ); ?>">
                      <span class="fas fa-edit get-data-tool-c"></span>
                    </button>
                    <button class="btn text-sm btn-danger tool" data-id="<?php echo html_escape( $reply->id ); ?>" data-toggle="modal" data-target="#delete">
                      <i class="fas fa-trash tool-c"></i>
                    </button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.reply-message -->
              <?php }
              } else { ?>
              <div class="text-center">
                <span class="d-block text-secondary"><?php echo lang( 'no_replies' ); ?></span>
              </div>
            <?php } ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-body">
            <?php if ( $ticket->status != 0 ) { ?>
              <form class="z-form add-reply-admin" action="<?php admin_action( 'support/add_reply' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
                <div class="response-message"></div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="form-group">
                  <div class="row mb-3 d-flex align-items-center">
                    <div class="col-xl-8">
                      <label for="your-reply"><?php echo lang( 'your_reply' ); ?> <span class="required">*</span></label>
                    </div>
                    <!-- /.col -->
                    <div class="col-xl-4">
                      <select class="form-control select2" id="canned-reply" data-placeholder="<?php echo lang( 'select_canned_reply' ); ?>" data-action="<?php admin_action( 'support/get_canned_reply/' . html_escape( $ticket->id ) ); ?>">
                        <option></option>
                        
                        <?php if ( ! empty( $canned_replies ) ) {
                          foreach ( $canned_replies as $canned_reply ) { ?>
                          <option value="<?php echo html_escape( $canned_reply->id ); ?>"><?php echo html_escape( $canned_reply->subject ); ?></option>
                        <?php }
                        } ?>
                      </select>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                  <textarea id="your-reply" class="form-control" name="reply" rows="10"></textarea>
                  
                  <?php if ( $ticket->sub_status != 3 ) { ?>
                    <small class="form-text text-muted"><?php echo lang( 'your_reply_opt' ); ?></small>
                  <?php } ?>
                </div>
                <!-- /.form-group -->
                
                <?php
                $my_id = $this->zuser->get( 'id' );
                
                if ( $ticket->sub_status != 3 || $ticket->assigned_to != $my_id ) { ?>
                  <div class="form-group">
                  
                    <?php if ( $ticket->sub_status != 3 ) { ?>
                      <div class="icheck icheck-primary d-inline-block mr-2">
                        <input type="checkbox" name="solved" value="1" id="solved">
                        <label for="solved"><?php echo lang( 'mark_as_solved' ); ?></label>
                      </div>
                      <!-- /.icheck -->
                    <?php } ?>
                    
                    <?php if ( $ticket->assigned_to != $my_id && $ticket->user_id != $my_id ) { ?>
                      <div class="icheck icheck-primary d-inline-block">
                        <input type="checkbox" name="assign_to_me" value="1" id="assign-to-me" <?php echo ( $ticket->assigned_to == null ) ? 'checked' : ''; ?>>
                        <label for="assign-to-me"><?php echo lang( 'assign_to_me' ); ?></label>
                      </div>
                      <!-- /.icheck -->
                    <?php } ?>
                    
                  </div>
                  <!-- /.form-group -->
                <?php } ?>
                
                <div class="form-group">
                  <label for="attachment"><?php echo lang( 'attach_file_opt' ); ?></label>
                  <input type="file" class="d-block" id="attachment" name="attachment" accept="<?php echo ALLOWED_ATTACHMENTS_EXT_HTML; ?>">
                  <small class="form-text text-muted"><?php echo lang( 'attach_file_tip' ); ?></small>
                </div>
                <!-- /.form-group -->
                <button type="submit" class="btn btn-primary float-right text-sm">
                  <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'submit' ); ?>
                </button>
                
                <input type="hidden" name="id" value="<?php echo html_escape( $ticket->id ); ?>">
              </form>
            <?php } else if ( $ticket->user_id != null || ! empty( $ticket->closed_by ) ) {
              $closed_by = ( ! empty( $ticket->closed_by ) ) ? $ticket->cb_first_name . ' ' . $ticket->cb_last_name : lang( 'system' ); ?>
              <div class="text-center">
                <span class="d-block"><?php printf( lang( 'ticket_closed_by_msg' ), $closed_by ); ?></span>
              </div>
            <?php } else { ?>
              <div class="text-center">
                <span class="d-block"><?php echo lang( 'ticket_closed_msg' ); ?></span>
              </div>
            <?php } ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            
            <?php if ( $ticket->user_id == null ) { ?>
              <button class="btn-block btn btn-secondary text-sm mb-3" data-toggle="modal" data-target="#resend-access">
                <i class="fas fa-paper-plane mr-2"></i> <?php echo lang( 'resend_access' ); ?>
              </button>
            <?php } ?>
            
            <ul class="list-group">
              <li class="list-group-item">
                <?php echo lang( 'status' ); ?>:
                <span class="float-right badge <?php echo ticket_status_color( $ticket->status, 'admin' ); ?>">
                  <?php echo manage_ticket_status( $ticket->status ); ?>
                </span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'reply_status' ); ?>:
                <span class="float-right badge <?php echo ticket_sub_status_color( $ticket->sub_status, 'admin' ); ?>">
                  <?php echo manage_ticket_sub_status( $ticket->sub_status, 'admin' ); ?>
                </span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'requester' ); ?>:
                
                <?php if ( ! empty( $ticket->first_name ) ) { ?>
                  
                  <?php if ( $this->zuser->has_permission( 'users' ) ) { ?>
                    <a class="float-right" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $ticket->user_id ) ); ?>" target="_blank">
                      <?php echo html_escape( $ticket->first_name . ' ' . $ticket->last_name ); ?>
                    </a>
                  <?php } else { ?>
                    <span class="float-right"><?php echo html_escape( $ticket->first_name . ' ' . $ticket->last_name ); ?></span>
                  <?php } ?>
                  
                <?php } else { ?>
                  <span class="float-right"><?php echo ( $ticket->email_address != '' ) ? html_escape( long_to_short_name( $ticket->email_address ) ) : lang( 'user_deleted' ); ?></span>
                <?php } ?>
              </li>
              
              <?php if ( $ticket->user_id == null ) { ?>
                <li class="list-group-item">
                  <?php echo lang( 'email_verified' ); ?>:
                  <span class="float-right badge <?php echo ( $ticket->is_verified == 0 ) ? 'badge-danger' : 'badge-success'; ?>">
                    <?php echo ( $ticket->is_verified == 0 ) ? lang( 'no' ) : lang( 'yes' ); ?>
                  </span>
                </li>
              <?php } ?>
              
              <li class="list-group-item">
                <?php echo lang( 'department' ); ?>:
                <span class="float-right">
                  <?php
                  if ( ! empty( $ticket->department ) ) { ?>
                    <span data-toggle="tooltip" title="<?php echo html_escape( $ticket->department ); ?>">
                      <?php echo html_escape( long_to_short_name( $ticket->department ) ); ?>
                    </span>
                  <?php
                  }
                  else
                  {
                      echo lang( 'unknown' );
                  }
                  ?>
                </span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'assigned_to' ); ?>:
                
                <span class="float-right">
                  <?php if ( ! empty( $ticket->assigned_to && ! empty( $ticket->au_first_name ) ) ) { ?>
                  
                  <?php if ( $this->zuser->has_permission( 'users' ) ) { ?>
                    <a class="float-right" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $ticket->assigned_to ) ); ?>" target="_blank">
                      <?php echo html_escape( $ticket->au_first_name . ' ' . $ticket->au_last_name ); ?>
                    </a>
                  <?php } else { ?>
                    <span class="float-right"><?php echo html_escape( $ticket->au_first_name . ' ' . $ticket->au_last_name ); ?></span>
                  <?php } ?>
                  
                <?php } else if ( ! empty( $ticket->assigned_to ) ) { ?>
                  <span class="float-right"><?php echo lang( 'user_deleted' ); ?></span>
                <?php } else { ?>
                  <span class="float-right"><?php echo lang( 'n_a' ); ?></span>
                <?php } ?>
                </span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'priority' ); ?>:
                <span class="float-right badge <?php echo ticket_priority_color( $ticket->priority, 'admin' ); ?>">
                  <?php echo lang( html_escape( $ticket->priority ) ); ?>
                </span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'updated' ); ?>:
                <span class="float-right"><?php manage_updated_at( html_escape( $ticket->updated_at ) ); ?></span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'created' ); ?>:
                <span class="float-right">
                  <?php echo get_date_time_by_timezone( html_escape( $ticket->created_at ) ); ?>
                </span>
              </li>
            </ul>
            <div class="clearfix">
              <?php if ( $ticket->status != 0 ) { ?>
                <form class="z-form" method="post" action="<?php admin_action( 'support/close_ticket' ); ?>" data-csrf="manual">
                  <div class="response-message c-alert-spacing"></div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <button type="submit" class="float-right mt-3 btn btn-danger text-sm">
                    <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'close_ticket' ); ?>
                  </button>
                  <input type="hidden" name="id" value="<?php echo html_escape( $ticket->id ); ?>">
                </form>
                <button class="float-right mr-1 mt-3 btn btn-primary text-sm" data-toggle="modal" data-target="#assign-user">
                  <i class="fas fa-user mr-2"></i> <?php echo lang( 'assign' ); ?>
                </button>
              <?php } else { ?>
                <form class="z-form" method="post" action="<?php admin_action( 'support/reopen_ticket' ); ?>" data-csrf="manual">
                  <div class="response-message c-alert-spacing"></div>
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <button type="submit" class="float-right mt-3 btn btn-success text-sm">
                    <i class="fas fa-envelope-open-text mr-2"></i> <?php echo lang( 'reopen_ticket' ); ?>
                  </button>
                  
                  <input type="hidden" name="id" value="<?php echo html_escape( $ticket->id ); ?>">
                </form>
              <?php } ?>
            </div>
            <!-- /.clearfix -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        
        <?php if ( ! empty( $history ) ) { ?>
          <div class="card">
            <div class="card-header d-flex align-items-center">
              <h3 class="card-title"><?php echo lang( 'history' ); ?></h3>
              
              <?php if ( $history_count > 3 ) { ?>
                <div class="card-tools ml-auto">
                  <a href="<?php echo env_url( 'admin/tickets/history/' . html_escape( $ticket->id ) ); ?>/page/1" class="btn btn-dark text-sm">
                    <i class="fas fa-eye mr-2"></i> <?php echo lang( 'see_all' ); ?>
                  </a>
                </div>
                <!-- /.card-tools -->
              <?php } ?>
            </div>
            <div class="card-body">
              <ul class="list-group">
                <?php foreach ( $history as $data ) { ?>
                  <li class="list-group-item">
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
                    
                    <small class="d-block text-muted"><?php echo get_date_time_by_timezone( html_escape( $data->created_at ) ); ?></small>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        <?php } ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php load_modals( ['admin/assign_user', 'admin/ticket_attachments', 'admin/ticket_resend_access', 'read_lg', 'delete'] ); ?>