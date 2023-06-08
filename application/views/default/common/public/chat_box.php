<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<?php if ( db_config( 'sp_live_chatting' ) ) {
  $is_chat_available = is_chat_available();
  $is_active_chat = is_active_chat(); ?>
  <div id="chat-box" class="chat-box position-fixed shadow-lg rounded bg-white">
    <div class="chat-box-header border-bottom py-3 px-4 shadow-sm">
      <div class="d-flex">
        <div class="user-pic-parent">
          <img class="user-pic" src="<?php illustration_by_color( 'headset_support' ); ?>">
        </div>
        <!-- /.user-pic-parent -->
        <div class="px-3 header-details">
          <span class="d-block fw-bold"><?php echo lang( 'support_chat' ); ?></span>
          
          <?php if ( $is_chat_available ) { ?>
            <small class="text-sub user-presence-status position-relative"><?php echo lang( 'available' ); ?></small>
          <?php } else { ?>
            <small class="text-danger user-presence-status position-relative"><?php echo lang( 'unavailable' ); ?></small>
          <?php } ?>
         
        </div>
        
        <div id="chat-box-tools" class="chat-box-tools">
          <?php if ( $is_active_chat ) { ?>
            <div class="dropdown">
              <button class="btn btn-sub" type="button" id="chat-box-menu" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" aria-labelledby="chat-box-menu">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#end-chat"><i class="fas fa-check-circle"></i> <?php echo lang( 'end_chat' ); ?></a></li>
              </ul>
            </div>
            <!-- /.dropdown -->
          <?php } ?>
        </div>
        <!-- /.chat-box-tools -->
          
      </div>
      <!-- /.d-flex -->
    </div>
    <!-- /.chat-box-header -->
    <div id="chat-box-body" class="chat-box-body">
      <?php if ( ! $this->zuser->is_logged_in ) { ?>
        <div class="chat-inner-height-box">
          <div class="icon-parent text-center p-4">
            <span class="text-muted d-inline-block px-2"><?php printf( lang( 'account_login_required' ), env_url( 'login' ) ); ?></span>
          </div>
          <!-- /.icon-parent -->
        </div>
        <!-- /.chat-inner-height-box -->
      <?php } else if ( db_config( 'sp_verification_before_submit' ) && $this->zuser->get( 'is_verified' ) == 0 ) { ?>
        <div class="chat-inner-height-box">
          <div class="icon-parent text-center p-4">
            <img class="icon mb-3" src="<?php assets_path( 'images/envelope_open.svg' ); ?>">
            <span class="text-muted d-inline-block px-2"><?php echo lang( 'sp_everification_req' ); ?></span>
          </div>
          <!-- /.icon-parent -->
        </div>
        <!-- /.chat-inner-height-box -->
      <?php } else if ( $is_active_chat ) {
        $messages = get_user_active_chat_by_id(); ?>
        <form class="z-form" action="<?php user_action( 'support/add_reply_chat' ); ?>" method="post">
          <div class="response-message"></div>
          
          <div id="chat-messages" class="chat-messages p-4" data-chat-action="<?php user_action( 'support/get_chat_messages' ); ?>">
            
            <?php if ( ! empty( $messages ) ) {
              $chat = $messages['chat']; ?>
              <div class="chat-message requestor">
                <small class="text-center d-block mb-3 text-sub"><?php printf( lang( 'chat_subject' ), replace_some_with_actuals( html_escape( $chat->subject ) ) ); ?></small>
                
                <div class="clearfix">
                  <span class="px-3 py-2 rounded d-inline-block"><?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $chat->message ) ) ) ); ?></span>
                </div>
                <!-- /.clearfix -->
                <small class="text-muted message-time d-block">
                  <?php printf( lang( 'sent_by_at' ), html_escape( long_to_short_name( $chat->first_name . ' ' . $chat->last_name ) ), get_time_by_timezone( html_escape( $chat->created_at ) ) ); ?>
                </small>
                
                <?php if ( empty( $messages['replies'] ) ) { ?>
                  <small class="text-center d-block mt-3 text-primary"><?php echo lang( 'waiting_agent' ); ?></small>
                <?php } ?>
              </div>
              <!-- /.chat-message -->
            <?php } ?>
            
            <?php if ( ! empty( $messages['replies'] ) ) {
              foreach ( $messages['replies'] as $reply ) { ?>
              
              <?php if ( $reply->area == 1 ) { ?>
                <div class="chat-message" data-reply-id="<?php echo html_escape( $reply->id ); ?>">
                  <div class="d-flex">
                    <div class="user-pic-parent">
                      <img class="user-pic" src="<?php echo user_picture( html_esc_url( $reply->user_picture ) ); ?>" alt="<?php echo html_escape( $reply->first_name . ' ' . $reply->last_name ); ?>">
                    </div>
                    <!-- /.user-pic-parent -->
                    <div class="ms-1">
                      <span class="px-3 py-2 rounded d-inline-block"><?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $reply->message ) ) ) ); ?></span>
                      <small class="text-muted message-time d-block">
                        <?php printf( lang( 'sent_by_at' ), html_escape( long_to_short_name( $reply->first_name . ' ' . $reply->last_name ) ), get_time_by_timezone( html_escape( $reply->replied_at ) ) ); ?>
                      </small>
                    </div>
                  </div>
                  <!-- /.d-flex -->
                </div>
                <!-- /.chat-message -->
              <?php } else { ?>
                <div class="chat-message requestor" data-reply-id="<?php echo html_escape( $reply->id ); ?>">
                  <div class="clearfix">
                    <span class="px-3 py-2 rounded d-inline-block"><?php echo nl2br( make_text_links( replace_some_with_actuals( html_escape( $reply->message ) ) ) ); ?></span>
                  </div>
                  <!-- /.clearfix -->
                  <small class="text-muted message-time d-block">
                    <?php printf( lang( 'sent_by_at' ), html_escape( long_to_short_name( $reply->first_name . ' ' . $reply->last_name ) ), get_time_by_timezone( html_escape( $reply->replied_at ) ) ); ?>
                  </small>
                </div>
                <!-- /.chat-message -->
              <?php } ?>
              
            <?php }
            } ?>
            
          </div>
          <!-- /.chat-messages -->
          <textarea id="chat-reply" class="form-control border-0 chat-textarea mt-2 px-4" name="reply" placeholder="<?php echo lang( 'type_message' ); ?>"></textarea>
        </form>
      <?php } else if ( ! $is_chat_available ) { ?>
        <div class="chat-inner-height-box">
          <div class="icon-parent text-center p-4">
            <span class="text-muted d-inline-block px-2"><?php printf( lang( 'agents_offline' ), env_url( 'user/support/create_ticket' ) ); ?></span>
          </div>
          <!-- /.icon-parent -->
        </div>
        <!-- /.chat-inner-height-box -->
      <?php } else { ?>
        <form class="z-form p-4" action="<?php user_action( 'support/create_chat' ); ?>" method="post">
          <div class="response-message"></div>
          
          <?php if ( get_chat_data_from_json( 'person' ) != md5( $this->zuser->get( 'id' ) ) ) { ?>
            <small class="text-center d-block mb-3 text-danger"><?php echo lang( 'already_chatting' ); ?></small>
          <?php } ?>
          
          <div class="mb-3">
            <label for="subject" class="form-label small"><?php echo lang( 'subject' ); ?> <span class="text-danger">*</span></label>
            <input type="text" id="subject" class="form-control" name="subject" required>
          </div>
          <!-- /.mb-3 -->
          <div class="mb-3">
            <label for="chat-department" class="form-label small"><?php echo lang( 'department' ); ?> <span class="text-danger">*</span></label>
            <select id="chat-department" class="form-control select2 search-disabled" name="department" data-placeholder="<?php echo lang( 'select_department' ); ?>" required>
              <option></option>
              <?php if ( ! empty( $departments = get_public_departments() ) ) {
                foreach ( $departments as $department ) { ?>
                <option value="<?php echo html_escape( $department->id ); ?>"><?php echo html_escape( $department->name ); ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <!-- /.mb-3 -->
          <div class="mb-3">
            <label for="message" class="form-label small"><?php echo lang( 'message' ); ?> <span class="text-danger">*</span></label>
            <textarea id="message" class="form-control" name="message" rows="4" required></textarea>
          </div>
          <!-- /.mb-3 -->
          <div class="d-grid">
            <button class="btn btn-sub" type="submit"><?php echo lang( 'send' ); ?></button>
          </div>
        </form>
      <?php } ?>
    </div>
    <!-- /.chat-box-body -->
  </div>
  <!-- /.chat-box -->
  
  <div id="chat-toggle" class="chat-toggle-button position-fixed bg-sub">
    <i class="fas fa-envelope"></i>
  </div>
  <!-- /.chat-toggle-button -->
  
  <?php load_modals( 'user/end_chat' ); ?>
  
<?php } ?>