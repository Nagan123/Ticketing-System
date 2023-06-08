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
          <div class="card-body p-0">
            <p class="pb-2 my-2 text-center shadow-sm">
              <span class="badge badge-primary mr-1 mb-2 mb-sm-0"><?php printf( lang( 'chat_no' ), html_escape( $chat->id ) ); ?></span>
              <span class="d-block d-sm-inline-block font-weight-bold"><?php echo replace_some_with_actuals( html_escape( $chat->subject ) ); ?></span>
            </p>
            <div id="chat-box-body" class="chat-box-body">
              <div id="chat-messages" class="chat-messages" data-chat-status="<?php echo html_escape( $chat->status ); ?>" data-chat-action="<?php admin_action( 'support/get_chat_messages/' . html_escape( $chat->id ) ); ?>">
                <div class="chat-message">
                  <div class="d-flex">
                    <div class="sender-pic">
                      <img src="<?php echo user_picture( html_esc_url( $chat->user_picture ) ); ?>" class="img-circle" alt="User Image">
                    </div>
                    <!-- /.sender-pic -->
                    <div class="ml-2">
                      <p class="message py-2 px-3 rounded"><?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $chat->message ) ) ) ); ?></p>
                      <div class="fs-sm text-secondary">
                        <?php printf( lang( 'sent_by_at' ), html_escape( $chat->first_name . ' ' . $chat->last_name ), get_time_by_timezone( html_escape( $chat->created_at ) ) ); ?>
                      </div>
                    </div>
                    <!-- /.ml-2 -->
                  </div>
                  <!-- /.d-flex -->
                </div>
                <!-- /.chat-message -->
                
                <?php if ( ! empty( $replies ) ) {
                  foreach ( $replies as $reply ) { ?>
                    <?php if ( $reply->area == 1 ) { ?>
                      <div class="chat-message sender" data-reply-id="<?php echo html_escape( $reply->id ); ?>">
                        <div class="clearfix">
                          <p class="message py-2 px-3 rounded"><?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $reply->message ) ) ) ); ?></p>
                        </div>
                        <!-- /.clearfix -->
                        <div class="fs-sm message-time text-secondary">
                          <?php printf( lang( 'sent_by_at' ), html_escape( $reply->first_name . ' ' . $reply->last_name ), get_time_by_timezone( html_escape( $reply->replied_at ) ) ); ?>
                        </div>
                      </div>
                      <!-- /.chat-message -->
                    <?php } else { ?>
                      <div class="chat-message" data-reply-id="<?php echo html_escape( $reply->id ); ?>">
                        <div class="d-flex">
                          <div class="sender-pic mb-2">
                            <?php if ( ! empty( $reply->user_picture ) ) { ?>
                              <img src="<?php echo user_picture( html_esc_url( $reply->user_picture ) ); ?>" class="img-circle" alt="User Image">
                            <?php } else { ?>
                              <img src="<?php echo user_picture( DEFAULT_USER_IMG ); ?>" class="img-circle" alt="User Image">
                            <?php } ?>
                          </div>
                          <!-- /.sender-pic -->
                          <div class="ml-2">
                            <p class="message py-2 px-3 rounded"><?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $reply->message ) ) ) ); ?></p>
                            <div class="fs-sm text-secondary">
                              <?php printf( lang( 'sent_by_at' ), html_escape( $reply->first_name . ' ' . $reply->last_name ), get_time_by_timezone( html_escape( $reply->replied_at ) ) ); ?>
                            </div>
                          </div>
                          <!-- /.ml-2 -->
                        </div>
                        <!-- /.d-flex -->
                      </div>
                      <!-- /.chat-message -->
                    <?php } ?>

                  <?php }
                  } ?>
                
              </div>
              <!-- /.chat-messages -->
            </div>
            <!-- /.chat-box-body -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-body">
            <?php if ( $chat->status != 0 ) { ?>
              <form class="z-form add-reply-admin" action="<?php admin_action( 'support/add_chat_reply' ); ?>" method="post" data-csrf="manual">
                <div class="response-message"></div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="form-group">
                  <div class="row mb-3 d-flex align-items-center">
                    <div class="col-xl-8">
                      <label for="your-reply"><?php echo lang( 'your_reply' ); ?> <span class="required">*</span></label>
                    </div>
                    <!-- /.col -->
                    <div class="col-xl-4">
                      <select class="form-control select2" id="canned-reply" data-placeholder="<?php echo lang( 'select_canned_reply' ); ?>" data-action="<?php admin_action( 'support/get_canned_reply/' . html_escape( $chat->id ) ); ?>/chat">
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
                  <textarea id="your-reply" class="form-control chat-textarea" name="reply" rows="2" placeholder="<?php echo lang( 'admin_chat_reply_tip' ); ?>" required></textarea>
                </div>
                <!-- /.form-group -->
                <button type="submit" class="btn btn-primary float-right text-sm">
                  <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'send' ); ?>
                </button>
                
                <input type="hidden" name="id" value="<?php echo html_escape( $chat->id ); ?>">
              </form>
            <?php } else {
              $ended_by = ( ! empty( $chat->ended_by ) ) ? $chat->eb_first_name . ' ' . $chat->eb_last_name : lang( 'n_a' ); ?>
              <div class="text-center">
                <span class="d-block"><?php printf( lang( 'chat_ended_by_msg' ), $ended_by ); ?></span>
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
            <ul class="list-group">
              <li class="list-group-item">
                <?php echo lang( 'status' ); ?>:
                <span class="float-right badge <?php echo chat_status_color( $chat->status ); ?>">
                  <?php echo manage_chat_status( $chat->status ); ?>
                </span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'requester' ); ?>:
                
                <?php if ( ! empty( $chat->first_name ) ) { ?>
                  
                  <?php if ( $this->zuser->has_permission( 'users' ) ) { ?>
                    <a class="float-right" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $chat->user_id ) ); ?>" target="_blank">
                      <?php echo html_escape( $chat->first_name . ' ' . $chat->last_name ); ?>
                    </a>
                  <?php } else { ?>
                    <span class="float-right"><?php echo html_escape( $chat->first_name . ' ' . $chat->last_name ); ?></span>
                  <?php } ?>
                  
                <?php } else { ?>
                  <span class="float-right"><?php echo lang( 'user_deleted' ); ?></span>
                <?php } ?>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'department' ); ?>:
                <span class="float-right">
                  <?php
                  if ( ! empty( $chat->department ) ) { ?>
                    <span data-toggle="tooltip" title="<?php echo html_escape( $chat->department ); ?>">
                      <?php echo html_escape( long_to_short_name( $chat->department ) ); ?>
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
                  <?php if ( ! empty( $chat->assigned_to && ! empty( $chat->au_first_name ) ) ) { ?>
                  
                  <?php if ( $this->zuser->has_permission( 'users' ) ) { ?>
                    <a class="float-right" href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $chat->assigned_to ) ); ?>" target="_blank">
                      <?php echo html_escape( $chat->au_first_name . ' ' . $chat->au_last_name ); ?>
                    </a>
                  <?php } else { ?>
                    <span class="float-right"><?php echo html_escape( $chat->au_first_name . ' ' . $chat->au_last_name ); ?></span>
                  <?php } ?>
                  
                <?php } else if ( ! empty( $chat->assigned_to ) ) { ?>
                  <span class="float-right"><?php echo lang( 'user_deleted' ); ?></span>
                <?php } else { ?>
                  <span class="float-right"><?php echo lang( 'n_a' ); ?></span>
                <?php } ?>
                </span>
              </li>
              <li class="list-group-item">
                <?php echo lang( 'created' ); ?>:
                <span class="float-right">
                  <?php echo get_date_time_by_timezone( html_escape( $chat->created_at ) ); ?>
                </span>
              </li>
            </ul>
            <?php if ( $chat->status != 0 ) { ?>
              <button class="float-right mt-3 btn btn-success text-sm" data-toggle="modal" data-target="#end-chat">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'end_chat' ); ?>
              </button>
              <button class="float-right mr-1 mt-3 btn btn-primary text-sm" data-toggle="modal" data-target="#assign-user-chat">
                <i class="fas fa-user mr-2"></i> <?php echo lang( 'assign' ); ?>
              </button>
            <?php } ?>
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

<?php load_modals( ['admin/assign_user_chat', 'admin/end_chat', 'delete'] ); ?>