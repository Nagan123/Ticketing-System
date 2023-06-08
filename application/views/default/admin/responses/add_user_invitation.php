<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<tr id="record-<?php echo html_escape( $id ); ?>">
  <td><?php echo html_escape( $id ); ?></td>
  <td><?php echo html_escape( $email_address ); ?></td>
  <td><?php echo html_escape( $invitation_code ); ?></td>
  <td><?php echo lang( 'not_registered' ); ?></td>
  <td class="text-right"><span class="badge badge-primary"><?php echo lang( 'unused' ); ?></span></td>
  <td class="text-right"><?php echo lang( 'never_updated' ); ?></td>
  <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $invited_at ) ); ?></td>
  <td class="text-right">
    <div class="btn-group">
      <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'users/edit_user_invitation' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
        <span class="fas fa-edit get-data-tool-c"></span>
      </button>
      <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
        <i class="fas fa-trash tool-c"></i>
      </button>
    </div>
    <!-- /.btn-group -->
  </td>
</tr>