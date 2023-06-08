<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="z-form" action="<?php admin_action( 'settings/general' ); ?>" method="post" enctype="multipart/form-data" data-csrf="manual">
          <div class="response-message"><?php echo alert_message(); ?></div>
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" role="tablist">
                <li class="pt-2 px-3"><?php echo lang( 'general_settings' ); ?></li>
                <li class="nav-item">
                  <a class="nav-link active" id="basic-tab" data-toggle="pill" href="#basic" role="tab" aria-controls="basic" aria-selected="true">
                    <?php echo lang( 'basic' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="appearance-tab" data-toggle="pill" href="#appearance" role="tab" aria-controls="appearance" aria-selected="false">
                    <?php echo lang( 'appearance' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="maintenance-tab" data-toggle="pill" href="#maintenance" role="tab" aria-controls="maintenance" aria-selected="false">
                    <?php echo lang( 'maintenance' ); ?>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="miscellaneous-tab" data-toggle="pill" href="#miscellaneous" role="tab" aria-controls="miscellaneous" aria-selected="false">
                    <?php echo lang( 'miscellaneous' ); ?>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
              
                <!-- Basic: -->
                <div class="tab-pane show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="site-name"><?php echo lang( 'site_name' ); ?> <span class="required">*</span></label>
                      <input type="text" id="site-name" class="form-control" name="site_name" value="<?php echo html_escape( db_config( 'site_name' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group col-md-6">
                      <label for="site-tagline"><?php echo lang( 'site_tagline' ); ?> <span class="required">*</span></label>
                      <input type="text" id="site-tagline" class="form-control" name="site_tagline" value="<?php echo html_escape( db_config( 'site_tagline' ) ); ?>">
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.form-row -->
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="site-theme"><?php echo lang( 'site_theme' ); ?></label>
                      <select class="form-control select2 search-disabled" id="site-theme" name="site_theme">
                        <?php foreach ( SITE_THEMES as $key => $value ) { ?>
                          <option value="<?php echo html_escape( $key ); ?>" <?php echo select_single( $key, db_config( 'site_theme' ) ); ?>><?php echo html_escape( $value['display_label'] ); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group col-md-6">
                      <label for="site-timezone"><?php echo lang( 'timezone' ); ?></label>
                      <select id="site-timezone" class="form-control select2" data-placeholder="<?php echo lang( 'select_timezone' ); ?>" name="site_timezone">
                        <option></option>
                        
                        <?php foreach ( DateTimeZone::listIdentifiers( DateTimeZone::ALL ) as $timezone ) { ?>
                          <option value="<?php echo html_escape( $timezone ); ?>" <?php echo select_single( $timezone, db_config( 'site_timezone' ) ); ?>><?php echo html_escape( $timezone ); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.form-row -->
                  <div class="form-group">
                    <label for="site-about"><?php echo lang( 'site_about' ); ?></label>
                    <textarea id="site-about" class="form-control" name="site_about" rows="5"><?php echo html_escape( db_config( 'site_about' ) ); ?></textarea>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="site-description"><?php echo lang( 'site_description' ); ?></label>
                    <textarea id="site-description" class="form-control" name="site_description" rows="5"><?php echo html_escape( db_config( 'site_description' ) ); ?></textarea>
                  </div>
                  <!-- /.form-group -->
                  <label for="site-keywords"><?php echo lang( 'site_keywords' ); ?></label>
                  <input type="text" id="site-keywords" class="form-control" name="site_keywords" value="<?php echo html_escape( db_config( 'site_keywords' ) ); ?>">
                </div>
                <!-- /.tab-pane -->
                
                <!-- Logo and Favicon: -->
                <div class="tab-pane" id="appearance" role="tabpanel" aria-labelledby="appearance-tab">
                  <div class="form-group position-relative">
                    <label for="site-logo" class="d-block"><?php echo lang( 'site_logo' ); ?></label>
                    
                    <?php if ( ! empty( db_config( 'site_logo' ) ) ) { ?>
                      <button type="button" class="btn btn-danger text-sm tr-absolute" data-toggle="modal" data-target="#delete-site-logo">
                        <i class="fas fa-trash mr-2"></i> <?php echo lang( 'delete_logo' ); ?>
                      </button>
                      <img class="d-block mb-2 settings-logo-view" src="<?php echo general_uploads( html_escape( db_config( 'site_logo' ) ) ); ?>" alt="">
                    <?php } ?>
                    
                    <input type="file" id="site-logo" name="site_logo" accept="<?php echo ALLOWED_IMG_EXT_HTML; ?>">
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="site-favicon" class="d-block"><?php echo lang( 'site_favicon' ); ?></label>
                    
                    <?php if ( ! empty( db_config( 'site_favicon' ) ) ) { ?>
                      <img class="d-block mb-2 favicon-lg" src="<?php echo general_uploads( html_escape( db_config( 'site_favicon' ) ) ); ?>" alt="">
                    <?php } ?>
                    
                    <input type="file" id="site-favicon" name="site_favicon" accept="<?php echo ALLOWED_IMG_EXT_HTML; ?>">
                  </div>
                  <!-- /.form-group -->
                  <div class="colors-radios">
                    <label for="site-color" class="d-block">
                      <?php echo lang( 'site_color' ); ?>
                      <i class="fas fa-info-circle text-sm" data-toggle="tooltip" data-placement="right" title="<?php echo lang( 'site_color_tip' ); ?>"></i>
                    </label>
                    <label class="color-wrapper">
                      <input type="radio" name="site_color" value="1" <?php echo check_single( 1, db_config( 'site_color' ) ); ?>>
                      <span class="check-circle color_1"></span>
                    </label>
                    <label class="color-wrapper">
                      <input type="radio" name="site_color" value="2" <?php echo check_single( 2, db_config( 'site_color' ) ); ?>>
                      <span class="check-circle color_2"></span>
                    </label>
                    <label class="color-wrapper">
                      <input type="radio" name="site_color" value="3" <?php echo check_single( 3, db_config( 'site_color' ) ); ?>>
                      <span class="check-circle color_3"></span>
                    </label>
                  </div>
                  <!-- /.colors-radios -->
                </div>
                <!-- /.tab-pane -->
                
                <!-- Maintenance: -->
                <div class="tab-pane" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
                  <div class="form-group">
                    <label for="allowed-ips"><?php echo lang( 'allowed_ips' ); ?></label>
                    <textarea id="allowed-ips" class="form-control" name="mm_allowed_ips" rows="5"><?php echo html_escape( db_config( 'mm_allowed_ips' ) ); ?></textarea>
                    <small class="form-text text-muted"><?php echo lang( 'mm_ip_addr_tip' ); ?></small>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="message"><?php echo lang( 'leave_visitors_msg' ); ?> <span class="required">*</span></label>
                    <textarea id="message" class="form-control" name="mm_message" rows="5"><?php echo html_escape( db_config( 'mm_message' ) ); ?></textarea>
                  </div>
                  <!-- /.form-group -->
                  <label class="d-block"><?php echo lang( 'maintenance_mode' ); ?></label>
                  <div class="icheck icheck-primary d-inline-block mr-2">
                    <input type="radio" name="maintenance_mode" id="maintenance-mode-1" value="1" <?php echo check_single( 1, db_config( 'maintenance_mode' ) ); ?>>
                    <label for="maintenance-mode-1"><?php echo lang( 'enable' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                  <div class="icheck icheck-primary d-inline-block">
                    <input type="radio" name="maintenance_mode" id="maintenance-mode-0" value="0" <?php echo check_single( 0, db_config( 'maintenance_mode' ) ); ?>>
                    <label for="maintenance-mode-0"><?php echo lang( 'disable' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                </div>
                <!-- /.tab-pane -->
                
                <!-- Miscellaneous: -->
                <div class="tab-pane" id="miscellaneous" role="tabpanel" aria-labelledby="miscellaneous-tab">
                  <label class="d-block"><?php echo lang( 'show_cookie_popup' ); ?></label>
                  <div class="icheck icheck-primary d-inline-block mr-2">
                    <input type="radio" name="site_show_cookie_popup" id="site-show-cookie-popup-1" value="1" <?php echo check_single( 1, db_config( 'site_show_cookie_popup' ) ); ?>>
                    <label for="site-show-cookie-popup-1"><?php echo lang( 'yes' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                  <div class="icheck icheck-primary d-inline-block">
                    <input type="radio" name="site_show_cookie_popup" id="site-show-cookie-popup-0" value="0" <?php echo check_single( 0, db_config( 'site_show_cookie_popup' ) ); ?>>
                    <label for="site-show-cookie-popup-0"><?php echo lang( 'no' ); ?></label>
                  </div>
                  <!-- /.icheck -->
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right text-sm">
                <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'update' ); ?>
              </button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php load_modals( 'admin/delete_site_logo' ); ?>