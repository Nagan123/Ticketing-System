<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>

<?php if ( $body_type === 'starting' ) {
  $messages = get_user_active_chat_by_id( $chat_id, false ); ?>
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
          
          <small class="text-center d-block mt-3 text-primary"><?php echo lang( 'waiting_agent' ); ?></small>
        </div>
        <!-- /.chat-message -->
      <?php } ?>
      
    </div>
    <!-- /.chat-messages -->
    <textarea id="chat-reply" class="form-control border-0 chat-textarea mt-2 px-4" name="reply" placeholder="<?php echo lang( 'type_message' ); ?>"></textarea>
  </form>
<?php } else if ( $body_type === 'replies' && ! empty( $replies ) ) {
    foreach ( $replies as $reply ) { ?>
  
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
  
<?php } ?>

<?php } else if ( $body_type === 'ending' ) { ?>
  <form class="z-form p-4" action="<?php user_action( 'support/create_chat' ); ?>" method="post">
    <div class="response-message"></div>
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