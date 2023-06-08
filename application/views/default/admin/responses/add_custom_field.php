<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<tr id="record-<?php echo html_escape( $id ); ?>">
  <td><?php echo html_escape( $id ); ?></td>
  <td><?php echo html_escape( $name ); ?></td>
  <td><?php echo lang( html_escape( $type ) ); ?></td>
  <td class="text-right"><?php echo lang( 'never_updated' ); ?></td>
  <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $created_at ) ); ?></td>
  <td class="text-right">
    <div class="btn-group">
      <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'custom_fields/edit_custom_field' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
        <span class="fas fa-edit get-data-tool-c"></span>
      </button>
      <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
        <i class="fas fa-trash tool-c"></i>
      </button>
    </div>
    <!-- /.btn-group -->
  </td>
</tr>