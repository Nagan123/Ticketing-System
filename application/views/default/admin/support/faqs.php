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
            <h3 class="card-title"><?php echo lang( 'faqs' ); ?></h3>
            <div class="card-tools ml-auto">
              <a href="<?php echo env_url( 'admin/support/faqs/categories' ); ?>" class="btn btn-dark text-sm mr-1">
                <i class="fas fa-folder mr-2"></i> <?php echo lang( 'categories' ); ?>
              </a>
              <button class="btn btn-success text-sm" data-toggle="modal" data-target="#add-faq">
                <i class="fas fa-plus-circle mr-2"></i> <?php echo lang( 'add_faq' ); ?>
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
                    <th class="th-2"><?php echo lang( 'question' ); ?></th>
                    <th><?php echo lang( 'answer' ); ?></th>
                    <th class="text-right"><?php echo lang( 'category' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'visibility' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'updated' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'created' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'actions' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $faqs ) )
                  {
                    foreach ( $faqs as $faq ) {
                      $id = $faq->id; ?>
                      <tr id="record-<?php echo html_escape( $id ); ?>">
                        <td><?php echo html_escape( $id ); ?></td>
                        <td>
                          <?php echo html_escape( short_text( $faq->question ) ); ?>
                          
                          <?php if ( is_increased_short_text( $faq->question ) ) { ?>
                            <span class="badge badge-success get-data-tool" data-source="<?php admin_action( 'support/faq/question' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
                              <?php echo lang( 'read_more' ); ?>
                            </span>
                          <?php } ?>
                        </td>
                        <td>
                          <?php echo html_escape( short_text( $faq->answer ) ); ?>
                          
                          <?php if ( is_increased_short_text( $faq->answer ) ) { ?>
                            <span class="badge badge-success get-data-tool" data-source="<?php admin_action( 'support/faq/answer' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
                              <?php echo lang( 'read_more' ); ?>
                            </span>
                          <?php } ?>
                        </td>
                        <td class="text-right">
                          <?php
                          if ( ! empty( $faq->category_name ) )
                          {
                              echo html_escape( $faq->category_name );
                          }
                          else
                          {
                              echo lang( 'uncategorized' );
                          }
                          ?>
                        </td>
                        <td class="text-right">
                          <?php
                          if ( $faq->visibility == 1 )
                          {
                              echo '<span class="badge badge-success">' . lang( 'public' ) . '</span>';
                          }
                          else
                          {
                              echo '<span class="badge badge-danger">' . lang( 'hidden' ) . '</span>';
                          }
                          ?>
                        </td>
                        <td class="text-right"><?php manage_updated_at( html_escape( $faq->updated_at ) ); ?></td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $faq->created_at ) ); ?></td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn btn-sm btn-primary get-data-tool" data-source="<?php admin_action( 'support/edit_faq' ); ?>" data-id="<?php echo html_escape( $id ); ?>">
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
                      <td colspan="8"><?php echo lang( 'no_records_found' ); ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
            
            <div class="clearfix"><?php echo $pagination; ?></div>
            
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

<?php load_modals( ['admin/add_faq', 'read', 'delete'] ); ?>