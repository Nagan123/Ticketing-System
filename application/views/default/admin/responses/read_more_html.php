<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Read More ( HTML Based ) Response Template: -->
<div class="modal-body">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <p><?php echo strip_extra_html( do_secure( $detail, true ) ); ?></p><hr>
  <small class="text-primary d-block">
    <i>&mdash; <?php echo html_escape( $type ); ?>, <?php echo lang( 'id' ); ?> <?php echo html_escape( $id ); ?></i>
  </small>
</div>
<!-- /.modal-body -->