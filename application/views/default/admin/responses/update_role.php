<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<td><?php echo html_escape( $id ); ?></td>
<td>
  <?php echo html_escape( $name ); ?>
  <a class="d-block" href="<?php echo html_escape( env_url( "admin/settings/roles/{$id}" ) ); ?>"><?php echo lang( 'permissions' ); ?></a>
</td>
<td><?php echo html_escape( $access_key ); ?></td>
<td class="text-right">
  <div class="btn-group">
    <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'settings/edit_role' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
      <span class="fas fa-edit get-data-tool-c"></span>
    </button>
    
    <?php if ( $is_built_in == 0 ) { ?>
      <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
        <i class="fas fa-trash tool-c"></i>
      </button>
    <?php } ?>
    
  </div>
  <!-- /.btn-group -->
</td>
