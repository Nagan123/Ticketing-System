<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<td><?php echo html_escape( $id ); ?></td>
<td><?php echo html_escape( $subject ); ?></td>
<td>
  <?php echo html_escape( short_text( $message ) ); ?>   
  
  <?php if ( is_increased_short_text( $message ) ) { ?>
    <span class="badge badge-success get-data-tool" data-source="<?php admin_action( 'support/canned_reply' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
      <?php echo lang( 'read_more' ); ?>
    </span>
  <?php } ?>
</td>
<td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $updated_at ) ); ?></td>
<td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $created_at ) ); ?></td>
<td class="text-right">
  <div class="btn-group">
    <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'support/edit_canned_reply' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
      <span class="fas fa-edit get-data-tool-c"></span>
    </button>
    <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
      <i class="fas fa-trash tool-c"></i>
    </button>
  </div>
  <!-- /.btn-group -->
</td>