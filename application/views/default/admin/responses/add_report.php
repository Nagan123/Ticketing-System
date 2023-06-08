<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<tr id="record-<?php echo html_escape( $id ); ?>">
  <td><?php echo html_escape( $id ); ?></td>
  <td><?php echo lang( html_escape( $period ) ); ?></td>
  <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $generated_at ) ); ?></td>
  <td class="text-right">
    <div class="btn-group">
      <a href="<?php echo env_url( 'admin/report/' . html_escape( $id ) ); ?>" class="btn btn-sm btn-primary" target="_blank">
        <i class="fas fa-file-invoice mr-2"></i> <?php echo lang( 'report_pdf' ); ?>
      </a>
      <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
        <i class="fas fa-trash tool-c"></i>
      </button>
    </div>
    <!-- /.btn-group -->
  </td>
</tr>