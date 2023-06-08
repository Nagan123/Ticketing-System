<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <?php if ( $role_id == 1 ) { ?>
          <div class="alert alert-info">
            <p><?php echo lang( 'cb_disabled_note' ); ?></p>
          </div>
          <!-- /.alert -->
        <?php } ?>
        
        <form class="z-form" action="<?php admin_action( 'settings/update_role_permissions' ); ?>" method="post" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="card">
            <div class="card-header d-flex align-items-center border-bottom-0">
              <h3 class="card-title"><?php printf( lang( 'permissions_for_role' ), $role ); ?></h3>
              <div class="card-tools ml-auto">
                <button type="submit" class="btn btn-primary text-sm">
                  <i class="fas fa-save mr-2"></i> <?php echo lang( 'update' ); ?>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body pt-0 pb-0 records-card-body">
              <div class="table-responsive">
                <table class="custom-table table table-hover table-valign-middle mb-0">
                  <tbody>
                    <?php
                    
                    if ( ! empty( $permissions ) )
                    {
                      $role_permissions = $this->Setting_model->role_permissions( $role_id );
                      
                      foreach ( $permissions as $permission ) {
                        $id = $permission->id; ?>
                        <tr>
                          <td><?php echo html_escape( $permission->name ); ?></td>
                          <td class="text-right">
                            <div class="icheck icheck-primary d-inline-block">
                              <input
                                type="checkbox"
                                class="<?php echo ( $role_id == 1 ) ? 'prevent-cb' : ''; ?>"
                                name="perm_<?php echo html_escape( $id ); ?>"
                                value="1"
                                id="perm-<?php echo html_escape( $id ); ?>" <?php echo check_single_by_array( $id, $role_permissions ); ?>>
                              <label for="perm-<?php echo html_escape( $id ); ?>"></label>
                            </div>
                            <!-- /.icheck -->
                          </td>
                        </tr>
                        <?php }
                      } else {
                    ?>
                      <tr>
                        <td><?php echo lang( 'no_records_found' ); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <input type="hidden" name="role_id" value="<?php echo intval( $role_id ); ?>">
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->