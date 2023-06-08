<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>

<?php if ( ! empty( $replies ) ) {
  foreach ( $replies as $reply ) { ?>
  
  <?php if ( $reply->area == 1 ) { ?>
    <div class="chat-message sender mt-3" data-reply-id="<?php echo html_escape( $reply->id ); ?>">
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
    <div class="chat-message mt-2" data-reply-id="<?php echo html_escape( $reply->id ); ?>">
      <div class="d-flex">
        <div class="sender-pic">
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