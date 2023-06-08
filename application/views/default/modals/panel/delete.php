<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Delete Modal: -->
<div class="modal" id="delete">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <?php
      
      $method = 'delete';
      
      if ( ! empty( $delete_method ) )
      {
          $method = $delete_method;
      }
      
      ?>
      
      <?php
      
      // $area is to handle the request according to the area/panel type.
      // $controller is used to reach to the request receiver controller.
      // $method is to pass the customized method name for the delete operation handling. 
      
      $controller = ( ! empty( $main_controller ) ) ? $main_controller : $this->uri->segment( 2 );
      
      ?>
      
      <form class="z-form" action="<?php echo env_url(); ?>actions/<?php echo strtolower( $area ); ?>/<?php echo strtolower( $controller ); ?>/<?php echo strtolower( $method ); ?>" method="post">
        <div class="modal-body">
          <div class="response-message"></div>
          <?php $key = ( ! empty( $delete_message_lang_key ) ) ? $delete_message_lang_key : 'sure_delete'; ?>
          <p><?php echo lang( $key ); ?></p>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'no' ); ?>
          </button>
          <button type="submit" class="btn btn-danger text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'yes' ); ?>
          </button>
          <input type="hidden" name="id">
        </div>
        <!-- /.modal-footer -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->