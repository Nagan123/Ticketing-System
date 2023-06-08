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
          <div class="card-header d-flex align-items-center border-bottom-0">
            <h3 class="card-title"><?php echo lang( 'search_articles' ); ?></h3>
            <div class="card-tools ml-auto">
              <form action="<?php echo env_url( 'admin/knowledge_base/articles' ); ?>" class="d-inline-block form-inline mr-2">
                <input
                  class="form-control text-sm search-field mr-1 mb-2 mb-sm-0"
                  name="search"
                  type="search"
                  value="<?php echo do_secure( get( 'search' ) ); ?>"
                  placeholder="<?php echo lang( 'id_or_title' ); ?>"
                  aria-label="Search">
                <select class="form-control text-sm search-field mr-1 mb-2 mb-sm-0" name="visibility">
                  <option value=""><?php echo lang( 'any_visibility' ); ?></option>
                  <option value="public" <?php echo select_get_visibility( 'public' ); ?>><?php echo lang( 'public' ); ?></option>
                  <option value="hidden" <?php echo select_get_visibility( 'hidden' ); ?>><?php echo lang( 'hidden' ); ?></option>
                </select>
                <button class="btn btn-primary text-sm btn-user-search" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title"><?php echo lang( 'articles' ); ?></h3>
            <div class="card-tools ml-auto">
              <a class="btn btn-success text-sm" href="<?php echo env_url( 'admin/knowledge_base/new_article' ); ?>">
                <i class="fas fa-plus-circle mr-2"></i> <?php echo lang( 'new_article' ); ?>
              </a>
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
                    <th><?php echo lang( 'title' ); ?></th>
                    <th class="text-right"><?php echo lang( 'visibility' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'updated' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'created' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'actions' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $articles ) )
                  {
                    foreach ( $articles as $article ) {
                      $id = $article->id; ?>
                      <tr id="record-<?php echo html_escape( $id ); ?>">
                        <td><?php echo html_escape( $id ); ?></td>
                        <td><?php echo html_escape( $article->title ); ?></td>
                        <td class="text-right">
                          <?php
                          if ( $article->visibility == 1 )
                          {
                              echo '<span class="badge badge-success">' . lang( 'public' ) . '</span>';
                          }
                          else
                          {
                              echo '<span class="badge badge-danger">' . lang( 'hidden' ) . '</span>';
                          }
                          ?>
                        </td>
                        <td class="text-right"><?php manage_updated_at( html_escape( $article->updated_at ) ); ?></td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $article->created_at ) ); ?></td>
                        <td class="text-right">
                          <div class="btn-group">
                            <a href="<?php echo env_url( get_kb_article_slug( html_escape( $article->slug ) ) ); ?>" class="btn btn-sm btn-info" target="_blank">
                              <span class="fas fa-eye"></span>
                            </a>
                            <a class="btn btn-sm btn-primary" href="<?php echo env_url( 'admin/knowledge_base/edit_article/' . html_escape( $id ) ); ?>">
                              <span class="fas fa-edit"></span>
                            </a>
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

<?php load_modals( ['admin/add_articles_category', 'read', 'delete'] ); ?>