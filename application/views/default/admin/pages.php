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
          <div class="card-header">
            <h3 class="card-title"><?php echo lang( 'pages' ); ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body pt-0 pb-0 records-card-body">
            <div class="table-responsive">
              <table class="custom-table table table-striped text-nowrap table-valign-middle mb-0">
                <thead>
                  <tr>
                    <th class="th-2"><?php echo lang( 'name' ); ?></th>
                    <th class="text-right"><?php echo lang( 'updated' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'created' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'action' ); ?></th>
                  </tr>
                </thead>
                <tbody class="text-sm">
                  <?php
                  if ( ! empty( $pages ) )
                  {
                    foreach ( $pages as $page ) { ?>
                      <tr>
                        <td><?php echo get_page_name( $page->id ); ?></td>
                        <td class="text-right"><?php manage_updated_at( html_escape( $page->updated_at ) ); ?></td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $page->created_at ) ); ?></td>
                        <td class="text-right">
                          <div class="btn-group">
                            <?php
                            if ( $page->id == 2 )
                            {
                                $page_slug = 'privacy-policy';
                            }
                            else
                            {
                                $page_slug = 'terms';
                            }
                            ?>
                            
                            <a href="<?php echo env_url( $page_slug ); ?>" class="btn btn-sm btn-info" target="_blank">
                              <span class="fas fa-eye"></span>
                            </a>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-page-<?php echo html_escape( $page->id ); ?>">
                              <span class="fas fa-edit"></span>
                            </button>
                          </div>
                          <!-- /.btn-group -->
                        </td>
                      </tr>
                      <?php }
                    } else {
                  ?>
                    <tr>
                      <td colspan="5"><?php echo lang( 'no_records_found' ); ?></td>
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

<?php load_modals( 'admin/pages' ); ?>