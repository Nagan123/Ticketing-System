<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Read More Response Template: -->
<div class="modal-body">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <p><?php echo nl2br( html_escape( $detail ) ); ?></p><hr>
  <small class="text-primary d-block">
    <i>&mdash; <?php echo html_escape( $type ); ?>, <?php echo lang( 'id' ); ?> <?php echo html_escape( $id ); ?></i>
  </small>
</div>
<!-- /.modal-body -->