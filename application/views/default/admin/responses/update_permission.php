<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<td><?php echo html_escape( $id ); ?></td>
<td><?php echo html_escape( $name ); ?></td>
<td><?php echo html_escape( $access_key ); ?></td>
<td class="text-right">
  <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'settings/edit_permission' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
    <span class="fas fa-edit get-data-tool-c"></span>
  </button>
</td>