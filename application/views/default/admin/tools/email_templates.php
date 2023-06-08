<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="not-in-form">
          <div class="response-message"><?php echo alert_message(); ?></div>
        </div>
        <!-- /.not-in-form -->
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"><?php echo lang( 'email_templates' ); ?></h3>
            <div class="card-tools ml-auto">
              <button class="btn btn-success text-sm" data-toggle="modal" data-target="#add-email-template">
                <i class="fas fa-plus-circle mr-2"></i> <?php echo lang( 'add_email_template' ); ?>
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
                    <th class="th-2"><?php echo lang( 'title' ); ?></th>
                    <th><?php echo lang( 'hook' ); ?></th>
                    <th class="text-right"><?php echo lang( 'language' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'updated' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'created' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'actions' ); ?></th>
                  </tr>
                </thead>
                <tbody class="text-sm">
                  <?php
                  if ( ! empty( $templates ) )
                  {
                    foreach ( $templates as $template ) { ?>
                      <tr>
                        <td><?php echo html_escape( $template->id ); ?></td>
                        <td><?php echo html_escape( $template->title ); ?></td>
                        <td><tt><?php echo html_escape( $template->hook ); ?></tt></td>
                        <td class="text-right"><?php echo get_language_label( html_escape( $template->language ) ); ?></td>
                        <td class="text-right"><?php manage_updated_at( html_escape( $template->updated_at ) ); ?></td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $template->created_at ) ); ?></td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-template-<?php echo html_escape( $template->id ); ?>">
                              <span class="fas fa-edit"></span>
                            </button>
                            
                            <?php if ( $template->is_built_in == 0 ) { ?>
                              <button class="btn btn-sm btn-danger tool" data-id="<?php echo html_escape( $template->id ); ?>" data-toggle="modal" data-target="#delete">
                                <i class="fas fa-trash tool-c"></i>
                              </button>
                            <?php } ?>
                            
                          </div>
                          <!-- /.btn-group -->
                        </td>
                      </tr>
                      <?php }
                    } else {
                  ?>
                    <tr id="record-0">
                      <td colspan="7"><?php echo lang( 'no_records_found' ); ?></td>
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

<?php load_modals( ['admin/add_email_template', 'admin/emails', 'delete'] ); ?>