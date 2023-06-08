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
            <h3 class="card-title"><?php echo lang( 'manage_users' ); ?></h3>
            <div class="card-tools ml-auto">
              <form action="<?php echo env_url( 'admin/users/manage' ); ?>" class="d-inline-block form-inline mr-2">
                <input
                  class="form-control text-sm search-users-field mr-1 mb-2 mb-sm-0"
                  name="search"
                  type="search"
                  value="<?php echo do_secure( get( 'search' ) ); ?>"
                  placeholder="<?php echo lang( 'search_users' ); ?>"
                  aria-label="Search">
                <select class="form-control text-sm search-users-field mr-1 mb-2 mb-sm-0" name="role">
                  <option value=""><?php echo lang( 'all_roles' ); ?></option>
                  
                  <?php if ( ! empty( $roles ) ) {
                    foreach ( $roles as $role ) {?>
                      <option value="<?php echo html_escape( $role->id ); ?>" <?php echo select_user_role( $role->id ); ?>><?php echo html_escape( $role->name ); ?></option>
                  <?php }
                  } ?>
                </select>
                <select class="form-control text-sm search-users-field mr-1 mb-2 mb-sm-0" name="filter">
                  <option value=""><?php echo lang( 'all_users' ); ?></option>
                  <option value="new_tfhrs" <?php echo select_user_filter( 'new_tfhrs' ); ?>><?php echo lang( 'new_within_24hrs' ); ?></option>
                  <option value="online_today" <?php echo select_user_filter( 'online_today' ); ?>><?php echo lang( 'online_today' ); ?></option>
                  <option value="online" <?php echo select_user_filter( 'online' ); ?>><?php echo lang( 'online_users' ); ?></option>
                  <option value="offline" <?php echo select_user_filter( 'offline' ); ?>><?php echo lang( 'offline_users' ); ?></option>
                  <option value="non_verified" <?php echo select_user_filter( 'non_verified' ); ?>><?php echo lang( 'non_verified_users' ); ?></option>
                  <option value="active" <?php echo select_user_filter( 'active' ); ?>><?php echo lang( 'active_users' ); ?></option>
                  <option value="banned" <?php echo select_user_filter( 'banned' ); ?>><?php echo lang( 'banned_users' ); ?></option>
                  <option value="social" <?php echo select_user_filter( 'social' ); ?>><?php echo lang( 'social_users' ); ?></option>
                </select>
                
                <button class="btn btn-primary text-sm btn-user-search" type="submit"><i class="fas fa-search"></i></button>
              </form>
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
                    <th class="th-2"><?php echo lang( 'full_name' ); ?></th>
                    <th class="th-2"><?php echo lang( 'email_address' ); ?></th>
                    <th><?php echo lang( 'username' ); ?></th>
                    <th class="text-right"><?php echo lang( 'email_verified' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'status' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'registered' ); ?></th>
                    <th class="text-right th-2"><?php echo lang( 'actions' ); ?></th>
                  </tr>
                </thead>
                <tbody class="records-tbody text-sm">
                  <?php
                  if ( ! empty( $users ) )
                  {
                    foreach ( $users as $user ) {
                      $id = $user->id; ?>
                      <tr id="record-<?php echo html_escape( $id ); ?>">
                        <td><?php echo html_escape( $id ); ?></td>
                        <td>
                          <div class="d-inline-block align-middle position-relative mr-2">
                            <img src="<?php echo user_picture( html_esc_url( $user->picture ) ); ?>" class="img-circle profile-pic-sm elevation-1" alt="<?php echo html_escape( $user->username ); ?>">
                            
                            <?php if ( $user->is_online == 0 ) { ?>
                              <span class="connectivity-status bg-secondary" data-toggle="tooltip" data-placement="right" title="<?php echo lang( 'offline' ); ?>"></span>
                            <?php } else { ?>
                              <span class="connectivity-status bg-success" data-toggle="tooltip" data-placement="right" title="<?php echo lang( 'online' ); ?>"></span>
                            <?php } ?>
                          </div>
                          <div class="d-inline-block align-middle">
                            <a href="<?php echo env_url( 'admin/users/edit_user/' . html_escape( $user->id ) ); ?>">
                              <?php echo html_escape( $user->first_name . ' ' . $user->last_name ); ?>
                            </a>
                            <small class="d-block text-muted"><?php echo html_escape( $user->role_name ); ?></small>
                          </div>
                        </td>
                        <td>
                          <?php echo html_escape( $user->email_address ); ?>
                          
                          <div class="text-muted">
                            <?php if ( $user->registration_source == 2 ) { ?>
                              <small>
                                <i class="fab fa-facebook"></i>
                                <?php echo lang( 'reg_with_facebook' ); ?>
                              </small>
                            <?php } else if ( $user->registration_source == 3 ) { ?>
                              <small>
                                <i class="fab fa-twitter"></i>
                                <?php echo lang( 'reg_with_twitter' ); ?>
                              </small>
                            <?php } else if ( $user->registration_source == 4 ) { ?>
                              <small>
                                <i class="fab fa-google"></i>
                                <?php echo lang( 'reg_with_google' ); ?>
                              </small>
                            <?php } ?>
                          </div>
                          
                        </td>
                        <td><?php echo html_escape( $user->username ); ?></td>
                        <td class="text-right">
                          <?php if ( $user->is_verified == 0 ) { ?>
                            <span class="tool cursor-pointer" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#send-vlink">
                              <i class="fas fa-paper-plane text-primary text-lg mt-2 tool-c" data-toggle="tooltip" data-placement="top" title="<?php echo lang( 'send_link' ); ?>"></i>
                            </span>
                          <?php } else { ?>
                            <i class="fas fa-check-circle text-success text-lg mt-2"></i>
                          <?php } ?>
                        </td>
                        <td class="text-right">
                          <?php if ( $user->status == 0 ) { ?>
                            <span class="badge badge-danger"><?php echo lang( 'banned' ); ?></span>
                          <?php } else if ( $user->status == 1 ) { ?>
                            <span class="badge badge-success"><?php echo lang( 'active' ); ?></span>
                          <?php } ?>
                        </td>
                        <td class="text-right"><?php echo get_date_time_by_timezone( html_escape( $user->registered_at ) ); ?></td>
                        <td class="text-right">
                          <button class="btn btn-sm btn-primary" data-toggle="dropdown">
                            <span class="fas fa-ellipsis-v"></span>
                          </button>
                          <div class="dropdown-menu">
                            <?php if ( $this->zuser->has_permission( 'all_tickets' ) ) { ?>
                              <a class="dropdown-item" href="<?php echo env_url( 'admin/users/tickets/' . html_escape( $user->username ) ); ?>">
                                <i class="fas fa-headset dropdown-menu-icon"></i> <?php echo lang( 'tickets' ); ?>
                              </a>
                            <?php } ?>
                            
                            <!--<?php if ( $this->zuser->has_permission( 'all_chats' ) ) { ?>-->
                            <!--  <a class="dropdown-item" href="<?php echo env_url( 'admin/users/chats/' . html_escape( $user->username ) ); ?>">-->
                            <!--    <i class="fas fa-comments dropdown-menu-icon"></i> <?php echo lang( 'chats' ); ?>-->
                            <!--  </a>-->
                            <!--<?php } ?>-->
                            
                            <!--<a class="dropdown-item tool seu-tool" href="#" data-id="<?php echo html_escape( $id ); ?>" data-email="<?php echo html_escape( $user->email_address ); ?>" data-toggle="modal" data-target="#send-email-user">-->
                            <!--  <i class="fas fa-envelope dropdown-menu-icon tool-c"></i> <?php echo lang( 'send_email' ); ?>-->
                            <!--</a>-->
                            <!--<a class="dropdown-item" href="<?php echo env_url( 'admin/users/sent_emails/' . html_escape( $user->username ) ); ?>">-->
                            <!--  <i class="fas fa-share dropdown-menu-icon"></i> <?php echo lang( 'sent_emails' ); ?>-->
                            <!--</a>-->
                            
                            <!--<div class="dropdown-divider"></div>-->
                            
                            <!--<?php if ( $this->zuser->has_permission( 'impersonate' ) ) { ?>-->
                            <!--  <a class="dropdown-item tool" href="#" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#impersonate-user">-->
                            <!--    <i class="fas fa-sign-in-alt dropdown-menu-icon tool-c"></i> <?php echo lang( 'impersonate' ); ?>-->
                            <!--  </a>-->
                            <!--<?php } ?>-->
                            
                            <!--<a class="dropdown-item" href="<?php echo env_url( 'admin/users/sessions/' . html_escape( $user->username ) ); ?>">-->
                            <!--  <i class="fab fa-firefox-browser dropdown-menu-icon"></i> <?php echo lang( 'sessions' ); ?>-->
                            <!--</a>-->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo env_url( "admin/users/edit_user/{$id}" ); ?>">
                              <i class="fas fa-edit dropdown-menu-icon"></i> <?php echo lang( 'edit_user' ); ?>
                            </a>
                            <a class="dropdown-item tool" href="#" data-id="<?php echo html_escape( $id ); ?>" data-toggle="modal" data-target="#delete">
                              <i class="fas fa-trash dropdown-menu-icon tool-c"></i> <?php echo lang( 'delete' ); ?>
                            </a>
                          </div>
                          <!-- /.dropdown-menu -->
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

<?php load_modals( ['admin/impersonate_user', 'admin/send_vlink', 'admin/send_email_user', 'delete'] ); ?>