<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<tr id="record-<?php echo html_escape( $id ); ?>">
  <td><?php echo html_escape( $id ); ?></td>
  <td>
    <?php echo html_escape( $name ); ?>
    <span class="text-muted text-sm d-block"><?php echo '/' . get_kb_category_slug( html_escape( $slug ) ); ?></span>
  </td>
  <td class="text-right"><?php echo lang( 'never_updated' ); ?></td>
  <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $created_at ) ); ?></td>
  <td class="text-right">
    <div class="btn-group">
      <a href="<?php echo env_url( get_kb_category_slug( html_escape( $slug ) ) ); ?>" class="btn btn-sm btn-info" target="_blank">
        <span class="fas fa-eye"></span>
      </a>
      <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'support/edit_articles_category' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
        <span class="fas fa-edit get-data-tool-c"></span>
      </button>
      <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
        <i class="fas fa-trash tool-c"></i>
      </button>
    </div>
    <!-- /.btn-group -->
  </td>
</tr>