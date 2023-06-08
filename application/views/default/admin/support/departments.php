<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="not-in-form">
          <div class="response-message"></div>
        </div>
        <!-- /.not-in-form -->
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"><?php echo lang( 'departments' ); ?></h3>
            <div class="card-tools ml-auto">
              <button class="btn btn-success text-sm" data-toggle="modal" data-target="#add-tickets-department">
                <i class="fas fa-plus-circle mr-2"></i> <?php echo lang( 'add_department' ); ?>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0 pb-0 records-card-body">
            <div class="table-responsive">
              <table class="custom-table z-table table table-striped text-nowrap table-valign-middle mb-0">
                <thead class="records-thead">
                  <tr>
                    <th class="th-1"><?php echo lang( 'id' ); ?></th>
                    <th><?php echo lang( 'department' ); ?></th>
                    <th class="text-right"><?php echo lang( 'visibility' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'updated' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'created' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'actions' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $departments ) )
                  {
                    foreach ( $departments as $department ) {
                      $id = $department->id; ?>
                      <tr id="record-<?php echo html_escape( $id ); ?>">
                        <td><?php echo html_escape( $id ); ?></td>
                        <td>
                          <?php echo html_escape( $department->name ); ?>
                          
                          <?php if ( $this->zuser->has_permission( 'tickets' ) ) { ?>
                            <div>
                              <a class="small" href="<?php echo env_url( 'admin/support/departments/' . html_escape( $department->id ) . '/tickets' ); ?>"><?php echo lang( 'browse_tickets' ); ?></a>
                            </div>
                          <?php } ?>
                          
                          <?php if ( $this->zuser->has_permission( 'chats' ) ) { ?>
                            <div>
                              <a class="small" href="<?php echo env_url( 'admin/support/departments/' . html_escape( $department->id ) . '/chats' ); ?>"><?php echo lang( 'browse_chats' ); ?></a>
                            </div>
                          <?php } ?>
                          
                        </td>
                        <td class="text-right">
                          <?php
                          if ( $department->visibility == 1 )
                          {
                              echo '<span class="badge badge-success">' . lang( 'public' ) . '</span>';
                          }
                          else
                          {
                              echo '<span class="badge badge-danger">' . lang( 'hidden' ) . '</span>';
                          }
                          ?>
                        </td>
                        <td class="text-right"><?php manage_updated_at( html_escape( $department->updated_at ) ); ?></td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $department->created_at ) ); ?></td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'support/edit_department' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
                              <span class="fas fa-edit get-data-tool-c"></span>
                            </button>
                            <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
                              <i class="fas fa-trash tool-c"></i>
                            </button>
                          </div>
                          <!-- /.btn-group -->
                        </td>
                      </tr>
                      <?php }
                    } else {
                  ?>
                    <tr id="record-0">
                      <td colspan="6"><?php echo lang( 'no_records_found' ); ?></td>
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
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php load_modals( ['admin/add_tickets_department', 'read', 'delete'] ); ?>